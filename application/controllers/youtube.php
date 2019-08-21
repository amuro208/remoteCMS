<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(__DIR__ . '/../libraries/src/');
require_once 'Google/Client.php';
require_once 'Google/Service/YouTube.php';
require_once APPPATH . 'controllers/api/doctrinautoload.php';

class Youtube extends DoctrinAutoload {

    private $token;
    
    function __construct()
    {
      $parameters = array("NoAuthCheck"=>"Y");
      parent::__construct($parameters);
      $this->load->database();
      
      $this->config->load('youtube');
      $this->load->helper('url');
    }

    public function index()
    {
      $this->token = $this->getOptionValue("youtube_token");
      if(empty($this->token)){
        $this->oauth2callback();
      }
    }
    
    public function upload(){
      $userid = $this->uri->segment(3);
      $user = $this->em->find("User", $userid);
      
      log_message("debug","######## START UPLOAD TO YOUTUBE ###########");
      log_message("debug","#user : $userid");

      $application_name = $this->config->item("google_appname");
      $client_secret = $this->config->item("google_secret_api_key");
      $client_id = $this->config->item("google_api_key");
      $playlist_id = $this->config->item("google_playlist_id");

      $scope = array(
        'https://www.googleapis.com/auth/youtube.upload', 
        'https://www.googleapis.com/auth/youtube', 
        'https://www.googleapis.com/auth/youtubepartner'
      );

      $medias = $user->getMedias();
      $filePath = "";
      foreach($medias as $media){
        if($media->getTypecode() == "videoId"){
          $filePath = $media->getFilepath();
        }
      }

      if($filePath == "") return;

      log_message("debug","#filePath : $filePath");
               
      //$videoPath = __DIR__ ."/test/testfile/20150828_104021.mp4";
      $videoPath = $this->uploadPath . $filePath;

      log_message("debug","#videoPath : $videoPath");

      $videoTitle = trim($this->getOptionValue($user->getEventcode()."_fb_title"));
      $videoDescription = trim($this->getOptionValue($user->getEventcode()."_fb_message"));
      $videoCategory = "22"; //People&Blog
      $videoTags = array("Fancam360");
       
      $sendsns = $this->em->getRepository("Sendsns")
                          ->findOneBy(
                              array(
                                "snstypecode" => "Youtube",
                                "userid" => $user,
                                "valid" => "Y"
                              )
                            );

      $this->token = $this->getOptionValue("youtube_token");
      if(empty($this->token)){
        $index = 0;
        while($index <= 20 && empty($this->token)){
          log_message("debug","waiting for 3 seconds to get token");
          sleep(3);
          $this->token = $this->getOptionValue("youtube_token");
          log_message("debug","token:".$this->token);
          $index++;
        }
        if(empty($this->token)){
          log_message("debug","There is no token");

          $sendsns->setIssent('N');
          //$sendsns->setSnsid($status->id);
          //$sendsns->setSnsurl("https://www.youtube.com/watch?v=".$status->id);
          $sendsns->setUpdatedate(new DateTime('now'));
          $this->em->persist($sendsns);
          $this->em->flush();
          exit;
        }
      }

      log_message("debug","#token :". $this->token);

      try{
          // Client init
          $client = new Google_Client();
          $client->setApplicationName($application_name);
          $client->setClientId($client_id);
          $client->setAccessType('offline');
          $client->setAccessToken($this->token);
          $client->setScopes($scope);
          $client->setClientSecret($client_secret);
       
          if ($client->getAccessToken()) {
       
              /**
               * Check to see if our access token has expired. If so, get a new one and save it to file for future use.
               */
              if($client->isAccessTokenExpired()) {
                  log_message("debug","token is expired");
                  $data = array(
                    'valid' => 'N',
                  );
                  $this->db->where('name','youtube_token');
                  $this->db->update('systemoption', $data); 
                  
                  //get new token from Youtube
                  $newToken = json_decode($client->getAccessToken());
                  $client->refreshToken($newToken->refresh_token);
                  
                  $clientToken = $client->getAccessToken();
                  
                  log_message("debug","#clientToken :". $this->token);
                  
                  if( $clientToken != null && !empty($clientToken) ){
                    $data = array(
                         'name' => "youtube_token",
                         'value' => $clientToken,
                         'createDate' => date('Y-m-d H:i:s')  
                      );
                    $this->db->insert('systemoption', $data, "'name'='youtube_token'"); 
                  }else{
                    file_get_contents($cmsHomeUrl."sendemail/error/youtube-refreshtoken");
                    echo "Coundn't refresh Token of Youtube.";
                    return;
                  }
              }
       
              $youtube = new Google_Service_YouTube($client);
       
              // Create a snipet with title, description, tags and category id
              $snippet = new Google_Service_YouTube_VideoSnippet();
              $snippet->setTitle($videoTitle);
              $snippet->setDescription($videoDescription);
              $snippet->setCategoryId($videoCategory);
              $snippet->setTags($videoTags);
       
              // Create a video status with privacy status. Options are "public", "private" and "unlisted".
              $status = new Google_Service_YouTube_VideoStatus();
              $status->setPrivacyStatus('unlisted');
       
              // Create a YouTube video with snippet and status
              $video = new Google_Service_YouTube_Video();
              $video->setSnippet($snippet);
              $video->setStatus($status);
       
              // Size of each chunk of data in bytes. Setting it higher leads faster upload (less chunks,
              // for reliable connections). Setting it lower leads better recovery (fine-grained chunks)
              $chunkSizeBytes = 1 * 1024 * 1024;
       
              // Setting the defer flag to true tells the client to return a request which can be called
              // with ->execute(); instead of making the API call immediately.
              $client->setDefer(true);
       
              // Create a request for the API's videos.insert method to create and upload the video.
              $insertRequest = $youtube->videos->insert("status,snippet", $video);
       
              // Create a MediaFileUpload object for resumable uploads.
              $media = new Google_Http_MediaFileUpload(
                  $client,
                  $insertRequest,
                  'video/*',
                  null,
                  true,
                  $chunkSizeBytes
              );
              $media->setFileSize(filesize($videoPath));
       
              // Read the media file and upload it chunk by chunk.
              $status = false;
              $handle = fopen($videoPath, "rb");
              while (!$status && !feof($handle)) {
                  $chunk = fread($handle, $chunkSizeBytes);
                  $status = $media->nextChunk($chunk);
              }
       
              fclose($handle);
       
              // If you want to make other calls after the file upload, set setDefer back to false
              $client->setDefer(false);

              /**
               * Video has successfully been upload, now lets perform some cleanup functions for this video
               */
              if ($status->status['uploadStatus'] == 'uploaded') {
                  // Actions to perform for a successful upload
                  // id...
                  //echo $status->id;
                  //echo $status->kind;
                  //print_r($status);
                  log_message("debug","Youtube Result:\n".json_encode($status));
                  //echo $status->modelData->snippet->thumnails->default->url;

                  $sendsns->setIssent('Y');
                  $sendsns->setSnsid($status->id);
                  $sendsns->setSnsurl("https://www.youtube.com/watch?v=".$status->id);
                  $sendsns->setUpdatedate(new DateTime('now'));
                  $this->em->persist($sendsns);

                  // Insert Video Into Playlist.
                  // It could run 5 minutes later.
                  if($playlist_id != ""){
                      sleep(5);
                      
                      $playlistId = $playlist_id;

                      $resourceId = new Google_Service_YouTube_ResourceId();
                      $resourceId->setVideoId($status->id);
                      $resourceId->setKind($status->kind);
                      
                      $playlistItemSnippet = new Google_Service_YouTube_PlaylistItemSnippet();
                      $playlistItemSnippet->setTitle($videoTitle);
                      $playlistItemSnippet->setPlaylistId($playlistId);
                      $playlistItemSnippet->setResourceId($resourceId);
                      
                      $playlistItem = new Google_Service_YouTube_PlaylistItem();
                      $playlistItem->setSnippet($playlistItemSnippet);
                      $playlistItemResponse = $youtube->playlistItems->insert(
                          'snippet,contentDetails', 
                          $playlistItem, array());
                  }
              }
              log_message("debug","######## FINISH UPLOAD TO YOUTUBE ###########");

              $cmsHomeUrl = $this->getOptionValue("cms_home_url");
              file_get_contents($cmsHomeUrl."sendemail/standard/".$user->getId());

              log_message("debug","######## FINISH SEND EMAIL ###########");
          } else{
              // @TODO Log error
              echo 'Problems creating the client';
          }
       
      }catch(Google_Service_Exception $e) {
          print "Caught Google service Exception ".$e->getCode(). " message is ".$e->getMessage();
          print "Stack trace is ".$e->getTraceAsString();
          log_message("error","Youtube Error Log:\n".$e->getMessage()."\n".$e->getTraceAsString());
          $cmsHomeUrl = $this->getOptionValue("cms_home_url");
          file_get_contents($cmsHomeUrl."sendemail/error/youtube-upload");
      }catch (Exception $e) {
          print "Caught Google service Exception ".$e->getCode(). " message is ".$e->getMessage();
          print "Stack trace is ".$e->getTraceAsString();
          log_message("error","Youtube Error Log:\n".$e->getMessage()."\n".$e->getTraceAsString());
          $cmsHomeUrl = $this->getOptionValue("cms_home_url");
          file_get_contents($cmsHomeUrl."sendemail/error/youtube");
      }

      $this->em->flush();
    }
    
    public function oauth2callback(){
      session_start();
      if (isset($_SESSION['token'])) {
        unset($_SESSION['token']);
      }

      //clear token data.
      //$this->db->delete('systemoption', array('name'=>'youtube_token'));
      $data = array(
        'valid' => 'N',
      );
      $this->db->where('name','youtube_token');
      $this->db->update('systemoption', $data); 
                                                              
      $OAUTH2_CLIENT_ID =  $this->config->item("google_api_key");
      $OAUTH2_CLIENT_SECRET =  $this->config->item("google_secret_api_key");
      $REDIRECT =  $this->config->item("google_redirect");
      $APPNAME =  $this->config->item("google_appname");

      $htmlBody = "";
      $authUrl = $REDIRECT;
      
      $client = new Google_Client();
      $client->setClientId($OAUTH2_CLIENT_ID);
      $client->setClientSecret($OAUTH2_CLIENT_SECRET);
      $client->setScopes('https://www.googleapis.com/auth/youtube');
      $client->setRedirectUri($REDIRECT);
      $client->setApplicationName($APPNAME);
      $client->setAccessType('offline');    
      $client->setApprovalPrompt('force');

      // Define an object that will be used to make all API requests.
      $youtube = new Google_Service_YouTube($client);
       
      if (isset($_GET['code'])) {
          if (strval($_SESSION['state']) !== strval($_GET['state'])) {
              die('The session state did not match.');
          }
       
          $client->authenticate($_GET['code']);
          $_SESSION['token'] = $client->getAccessToken();
      }
       
      if (isset($_SESSION['token'])) {
          $client->setAccessToken($_SESSION['token']);
          //echo '<code>' . $_SESSION['token'] . '</code>';
          $data = array(
               'name' => "youtube_token",
               'value' => $_SESSION['token'],
               'createDate' => date('Y-m-d H:i:s')  
            );
          $this->db->insert('systemoption', $data); 
      }
       
      // Check to ensure that the access token was successfully acquired.
      if ($client->getAccessToken()) {
          try {
              // Call the channels.list method to retrieve information about the
              // currently authenticated user's channel.
              /*
              $channelsResponse = $youtube->channels->listChannels('contentDetails', array(
                  'mine' => 'true',
              ));
              */
       
              $htmlBody .= "<h3>The Server Received Your Access Token To Youtube.</h3>";

              /*
              foreach ($channelsResponse['items'] as $channel) {
                  // Extract the unique playlist ID that identifies the list of videos
                  // uploaded to the channel, and then call the playlistItems.list method
                  // to retrieve that list.
                  $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];
       
                  $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
                      'playlistId' => $uploadsListId,
                      'maxResults' => 50
                  ));
       
                  $htmlBody .= "<h3>Videos in list $uploadsListId</h3><ul>";
                  foreach ($playlistItemsResponse['items'] as $playlistItem) {
                      $htmlBody .= sprintf('<li>%s (%s)</li>', $playlistItem['snippet']['title'],
                          $playlistItem['snippet']['resourceId']['videoId']);
                  }
                  $htmlBody .= '</ul>';
              }
              */

          } catch (Google_ServiceException $e) {
              $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
                  htmlspecialchars($e->getMessage()));
          } catch (Google_Exception $e) {
              $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
                  htmlspecialchars($e->getMessage()));
          }
       
          $_SESSION['token'] = $client->getAccessToken();
      } else {
          $state = mt_rand();
          $client->setState($state);
          $_SESSION['state'] = $state;
       
          $authUrl = $client->createAuthUrl();
          
          header("Location: $authUrl");
          die();
          
          $htmlBody =" 
            <h3>Authorization Required</h3>
            <p>You need to <a href=".$authUrl.">authorise access</a> before proceeding.<p>
          ";
      }      

      echo $htmlBody;
    }
}
