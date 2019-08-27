<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoloadrestful.php';

class Statistic extends DoctrinAutoloadRestful
{

  function __construct($parameters=array())
  {
    parent::__construct();
    $this->load->database();
  }

  public function allrawdata_get(){
    $pcode = "*";
    if($this->get("projectCode") != null){
      $pcode=$this->get("projectCode");
    }
    $aid = $this->authUser->aid;
    $sql = "SELECT a.id,a.siteCode,a.firstName,a.lastName,a.mobile,a.email,a.localCreateDate,a.reserve1,a.reserve2,a.reserve3,a.reserve4,a.reserve5
              FROM `user` a
              JOIN `code` b
                ON a.eventCode = b.code
               AND b.category = 'EVENT'
              JOIN `event` e
                ON a.eventCode = e.eventCode
               AND a.localCreateDate BETWEEN e.startDate AND e.endDate
              JOIN `emaillog` c
                ON a.id = c.userid
               AND c.valid = 'Y'
             WHERE a.valid = 'Y'
               AND a.projectCode = '".$pcode."'
               AND b.valid = 'Y'
               AND e.valid = 'Y'
    ";

    $this->log($sql);

    $query = $this->db->query($sql);
    $datas = $query->result_array();

    if($this->get("format") == "csv"){
      $datas2 = array();
      foreach($datas as $data){
        $datas2[] = array(
          "Id"=>$data["id"],
          "SiteCode"=>$data["siteCode"],
          "FirstName"=>$data["firstName"],
          "LastName"=>$data["lastName"],
          "Mobile"=>$data["mobile"],
          "Email"=>$data["email"],
          "Reserve1"=>$data["reserve1"],
          "Reserve2"=>$data["reserve2"],
          "Reserve3"=>$data["reserve3"],
          "Reserve4"=>$data["reserve4"],
          "Reserve5"=>$data["reserve5"],
          "LocalCreateDate"=>$data["localCreateDate"],
        );
      }

      $datas = $datas2;
      $this->response($datas2,200);
      return;
    }

    $results = array(
      "code"=>"OK",
      "total"=>count($datas),
      "data"=>$datas
    );

    $this->response($results,200);
  }

  public function data_get(){
    $aid = $this->authUser->aid;
    $pcode = "*";
    if($this->get("projectCode") != null){
      $pcode=$this->get("projectCode");
    }
    $sql = "
SELECT RIGHT(CONCAT('0000',@rn := @rn + 1),4) rn,
       x.*
  FROM (
        SELECT CASE WHEN no = 3 THEN 'TOTAL' ELSE x.eventDate END eventDate,
               CASE WHEN no = 1 THEN x.eventName
                    WHEN no = 2 THEN 'SUBTOTAL'
                    ELSE '' END eventName,

               SUM(participant) participant,
               SUM(validEmailCount) + SUM(invalidEmailCount) totalEmailCount,
               (SELECT count(distinct c.email)
                  FROM `user` a
                  JOIN `code` b
                    ON a.eventCode = b.code
                   AND b.category = 'EVENT'
                  JOIN `emaillog` c
                    ON a.id = c.userid
                  JOIN `event` e
                    ON a.eventCode = e.eventCode
                   AND a.localCreateDate BETWEEN e.startDate AND e.endDate
                 WHERE a.valid = 'Y'
                   AND b.valid = 'Y'
                   AND c.isSent = 'Y'
                   AND (CASE WHEN no = 3 THEN 1 ELSE DATE_FORMAT(a.localCreateDate,'%Y-%m-%d') END) =
                       (CASE WHEN no = 3 THEN 1 ELSE x.eventDate END)
                   AND b.name = CASE WHEN no = 1 THEN x.eventName
                                     WHEN no = 2 or no = 3 THEN b.name
                                ELSE '' END
               ) uniqueParticipantCount,

               SUM(invalidEmailCountDNS) invalidEmailCountDNS,
               SUM(invalidEmailCountInvalidFormat) invalidEmailCountInvalidFormat,
               SUM(invalidEmailCountUnknown) invalidEmailCountUnknown,
               SUM(invalidEmailCountNoUser) invalidEmailCountNoUser,
               SUM(invalidCannotConnectUser) invalidCannotConnectUser,
               SUM(validEmailCount) validEmailCount,
               SUM(invalidEmailCount) invalidEmailCount,

               SUM(sentEmailCount) sentEmailCount,
               SUM(openedEmailCount) openedEmailCount,

               (SELECT count(distinct c.email)
                  FROM `user` a
                  JOIN `code` b
                    ON a.eventCode = b.code
                   AND b.category = 'EVENT'
                  JOIN `emaillog` c
                    ON a.id = c.userid
                  JOIN `event` e
                    ON a.eventCode = e.eventCode
                   AND a.localCreateDate BETWEEN e.startDate AND e.endDate
                  WHERE a.valid = 'Y'
                    AND b.valid = 'Y'
                    AND c.isSent = 'Y'
                    AND (CASE WHEN no = 3 THEN 1 ELSE DATE_FORMAT(a.localCreateDate,'%Y-%m-%d') END) =
                        (CASE WHEN no = 3 THEN 1 ELSE x.eventDate END)
                    AND b.name = CASE WHEN no = 1 THEN x.eventName
                                      WHEN no = 2 or no = 3 THEN b.name
                                  ELSE '' END
               ) uniqueEmailCount,

               SUM(EDMClickAllContents) EDMClickAllContents,
               SUM(EDMClickContents) EDMClickContents,
               SUM(EDMClickButton) EDMClickButton,
               SUM(EDMMicrositeClickContents) EDMMicrositeClickContents,
               SUM(EDMDownload) EDMDownload,
               SUM(EDMFacebook) EDMFacebook,
               SUM(EDMTwitter) EDMTwitter,
               SUM(EDMWeibo) EDMWeibo,
               SUM(EDMBanner) EDMBanner,

               SUM(ClickBackFromFacebook) ClickBackFromFacebook,
               SUM(ClickBackFromTwitter) ClickBackFromTwitter,
               SUM(ClickBackFromWeibo) ClickBackFromWeibo,
               SUM(ClickBackFromOther) ClickBackFromOther,
               SUM(ClickBackMicrositeClickContents) ClickBackMicrositeClickContents,
               SUM(ClickBackDownload) ClickBackDownload,
               SUM(ClickBackFacebook) ClickBackFacebook,
               SUM(ClickBackTwitter) ClickBackTwitter,
               SUM(ClickBackWeibo) ClickBackWeibo,
               SUM(ClickBackBanner) ClickBackBanner,

               SUM(EDMLink1) EDMLink1,
               SUM(EDMLink2) EDMLink2,
               SUM(EDMLink3) EDMLink3,
               SUM(EDMLink4) EDMLink4,
               SUM(EDMLink5) EDMLink5,
               SUM(EDMLink6) EDMLink6,
               SUM(EDMLink7) EDMLink7,
               SUM(EDMLink8) EDMLink8,
               SUM(EDMLink9) EDMLink9,
               SUM(EDMLink10) EDMLink10

          FROM (
                SELECT DATE_FORMAT(a.localCreateDate,'%Y-%m-%d') eventDate,
                       b.name eventName,
                       count(distinct a.id) participant,
                       SUM(CASE WHEN c.isValidEmail = 'Y' THEN 1 ELSE 0 END) validEmailCount,
                       SUM(CASE WHEN c.isValidEmail = 'N' THEN 1 ELSE 0 END) invalidCannotConnectUser,
                       SUM(CASE WHEN c.isValidEmail = 'E' THEN 1 ELSE 0 END) invalidEmailCountNoUser,
                       SUM(CASE WHEN c.isValidEmail = 'U' THEN 1 ELSE 0 END) invalidEmailCountUnknown,
                       SUM(CASE WHEN c.isValidEmail = 'D' THEN 1 ELSE 0 END) invalidEmailCountDNS,
                       SUM(CASE WHEN c.isValidEmail = 'F' THEN 1 ELSE 0 END) invalidEmailCountInvalidFormat,
                       SUM(CASE WHEN c.isValidEmail <> 'Y' THEN 1 ELSE 0 END) invalidEmailCount,
                       SUM(CASE WHEN c.isSent = 'Y' THEN 1 ELSE 0 END) sentEmailCount,
                       SUM(CASE WHEN c.isOpened = 'Y' THEN 1 ELSE 0 END) openedEmailCount,

                       IFNULL(SUM(EDMClickAllContents),0) EDMClickAllContents,
                       IFNULL(SUM(EDMClickContents),0) EDMClickContents,
                       IFNULL(SUM(EDMClickButton),0) EDMClickButton,
                       IFNULL(SUM(EDMMicrositeClickContents),0) EDMMicrositeClickContents,
                       IFNULL(SUM(EDMDownload),0) EDMDownload,
                       IFNULL(SUM(EDMFacebook),0) EDMFacebook,
                       IFNULL(SUM(EDMTwitter),0) EDMTwitter,
                       IFNULL(SUM(EDMWeibo),0) EDMWeibo,
                       IFNULL(SUM(EDMBanner),0) EDMBanner,

                       IFNULL(SUM(ClickBackFromFacebook),0) ClickBackFromFacebook,
                       IFNULL(SUM(ClickBackFromTwitter),0) ClickBackFromTwitter,
                       IFNULL(SUM(ClickBackFromWeibo),0) ClickBackFromWeibo,
                       IFNULL(SUM(ClickBackFromOther),0) ClickBackFromOther,
                       IFNULL(SUM(ClickBackMicrositeClickContents),0) ClickBackMicrositeClickContents,
                       IFNULL(SUM(ClickBackDownload),0) ClickBackDownload,
                       IFNULL(SUM(ClickBackFacebook),0) ClickBackFacebook,
                       IFNULL(SUM(ClickBackTwitter),0) ClickBackTwitter,
                       IFNULL(SUM(ClickBackWeibo),0) ClickBackWeibo,
                       IFNULL(SUM(ClickBackBanner),0) ClickBackBanner,

                       SUM(CASE WHEN c.reserve1 = 'Y' THEN 1 ELSE 0 END) EDMLink1,
                       SUM(CASE WHEN c.reserve2 = 'Y' THEN 1 ELSE 0 END) EDMLink2,
                       SUM(CASE WHEN c.reserve3 = 'Y' THEN 1 ELSE 0 END) EDMLink3,
                       SUM(CASE WHEN c.reserve4 = 'Y' THEN 1 ELSE 0 END) EDMLink4,
                       SUM(CASE WHEN c.reserve5 = 'Y' THEN 1 ELSE 0 END) EDMLink5,
                       SUM(CASE WHEN c.reserve6 = 'Y' THEN 1 ELSE 0 END) EDMLink6,
                       SUM(CASE WHEN c.reserve7 = 'Y' THEN 1 ELSE 0 END) EDMLink7,
                       SUM(CASE WHEN c.reserve8 = 'Y' THEN 1 ELSE 0 END) EDMLink8,
                       SUM(CASE WHEN c.reserve9 = 'Y' THEN 1 ELSE 0 END) EDMLink9,
                       SUM(CASE WHEN c.reserve10 = 'Y' THEN 1 ELSE 0 END) EDMLink10

                  FROM `user` a
                  JOIN `code` b
                    ON a.eventCode = b.code
                   AND b.category = 'EVENT'
                  JOIN `event` e
                    ON a.eventCode = e.eventCode
                   /*AND a.siteCode = e.siteCode*/
                   AND a.localCreateDate BETWEEN e.startDate AND e.endDate
                  JOIN `emaillog` c
                    ON a.id = c.userid
                   AND c.valid = 'Y'
                  LEFT OUTER JOIN (
                        SELECT x.emailLogId,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML' OR activityType = 'CNTFRMEML1' OR activityType = 'CNTFRMEML2') THEN 1 ELSE 0 END) EDMClickAllContents,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML' OR activityType = 'CNTFRMEML1' OR activityType = 'CNTFRMEML2') THEN 1 ELSE 0 END) EDMClickContents,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML2') THEN 1 ELSE 0 END) EDMClickButton,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML' OR activityType = 'CNTFRMEML1' OR activityType = 'CNTFRMEML2') AND clicked > 0 THEN 1 ELSE 0 END) EDMMicrositeClickContents,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML' OR activityType = 'CNTFRMEML1' OR activityType = 'CNTFRMEML2') AND downloaded > 0  THEN 1 ELSE 0 END) EDMDownload,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML' OR activityType = 'CNTFRMEML1' OR activityType = 'CNTFRMEML2') AND shared1 > 0  THEN 1 ELSE 0 END) EDMFacebook,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML' OR activityType = 'CNTFRMEML1' OR activityType = 'CNTFRMEML2') AND shared2 > 0  THEN 1 ELSE 0 END) EDMTwitter,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML' OR activityType = 'CNTFRMEML1' OR activityType = 'CNTFRMEML2') AND shared3 > 0  THEN 1 ELSE 0 END) EDMWeibo,
                               MAX(CASE WHEN (activityType = 'CNTFRMEML' OR activityType = 'CNTFRMEML1' OR activityType = 'CNTFRMEML2') AND reserve1 > 0  THEN 1 ELSE 0 END) EDMBanner,

                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND (
                                             INSTR(referer,'facebook.com') > 0
                                             OR
                                             referer = 'https://www.facebook.com/'
                                             OR
                                             referer = 'http://m.facebook.com/'
                                             ) THEN 1 ELSE 0 END) ClickBackFromFacebook,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND (LEFT(referer,12) = 'http://t.co/' OR LEFT(referer,13) = 'https://t.co/') THEN 1 ELSE 0 END) ClickBackFromTwitter,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND INSTR(referer,'http://www.weibo.com/') > 0 THEN 1 ELSE 0 END) ClickBackFromWeibo,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND referer = '' THEN 1 ELSE 0 END) ClickBackFromOther,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND clicked > 0 THEN 1 ELSE 0 END) ClickBackMicrositeClickContents,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND downloaded > 0  THEN 1 ELSE 0 END) ClickBackDownload,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND shared1 > 0  THEN 1 ELSE 0 END) ClickBackFacebook,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND shared2 > 0  THEN 1 ELSE 0 END) ClickBackTwitter,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND shared3 > 0  THEN 1 ELSE 0 END) ClickBackWeibo,
                               SUM(CASE WHEN activityType = 'CNTFRMSHR' AND reserve1 > 0  THEN 1 ELSE 0 END) ClickBackBanner
                          FROM `activitylog` x
                         GROUP BY x.emailLogId
                       ) x
                    ON c.id = x.emailLogId
                 WHERE a.valid = 'Y'
                   AND a.projectCode = '".$pcode."'
                   AND b.valid = 'Y'
                   AND e.valid = 'Y'
                 GROUP BY DATE_FORMAT(a.localCreateDate,'%Y-%m-%d'),b.name
               ) x
         CROSS JOIN (SELECT 1 no UNION ALL SELECT 2 no UNION ALL SELECT 3 no) y
         GROUP BY CASE WHEN no = 3 THEN '' ELSE x.eventDate END,
                  CASE WHEN no = 1 THEN x.eventName
                       WHEN no = 2 THEN 'SUBTOTAL'
                       ELSE '' END
         ORDER BY CASE WHEN no = 3 THEN '9999-12-31' ELSE x.eventDate END,
                  CASE WHEN no = 1 THEN x.eventName ELSE 'ZZZZZZ' END,
                  CASE WHEN no = 2 THEN x.eventName ELSE 'ZZZZZZ' END
       ) x
 CROSS JOIN (SELECT @rn := 0) y
    ";
    $this->log($sql);

    $query = $this->db->query($sql);
    $datas = $query->result_array();

    if($this->get("format") == "csv"){
      $datas2 = array();
      foreach($datas as $data){
        $datas2[] = array(
          "Date"=>$data["eventDate"],
          "Activity"=>$data["eventName"],
          "GamesPlayed"=>$data["participant"],
          "TotalParticipants"=>$data["totalEmailCount"],
          "UniquePaticipants"=>$data["uniqueParticipantCount"],

          "Sent"=>$data["participant"],
          "Delivered"=>$data["sentEmailCount"],
          "Unique"=>$data["uniqueEmailCount"],
          "Opened"=>$data["openedEmailCount"],
          "OpenRate"=>($data["sentEmailCount"] == 0 ? 0 : $data["openedEmailCount"]*100.0/$data["sentEmailCount"]),
          "AllClickInEmail"=>$data["EDMClickAllContents"],
          "ClickInEmail"=>$data["EDMClickContents"],
          "ClickButtonInEmail"=>$data["EDMClickButton"],
          "ClickConetentsInMicrosite"=>$data["EDMMicrositeClickContents"],
          "ClickDownloadInMicrosite"=>$data["EDMDownload"],
          "ClickFacebookInMicrosite"=>$data["EDMFacebook"],
          "ClickTwitterinMicrosite"=>$data["EDMTwitter"],
          "ClickInstagramInMicrosite"=>$data["EDMWeibo"],
          "ClickBannerInMicrosite"=>$data["EDMBanner"],

          "ClickBackFromFacebook"=>$data["ClickBackFromFacebook"],
          "ClickBackFromTwitter"=>$data["ClickBackFromTwitter"],
          "ClickBackFromInstagram"=>$data["ClickBackFromWeibo"],
          "ClickBackFromOther"=>$data["ClickBackFromOther"],

          "ClickContentsInClickBackMicrosite"=>$data["ClickBackMicrositeClickContents"],
          "ClickDownloadInClickBackMicrosite"=>$data["ClickBackDownload"],
          "ClickFacebookInClickBackMicrosite"=>$data["ClickBackFacebook"],
          "ClickTwitterInClickBackMicrosite"=>$data["ClickBackTwitter"],
          "ClickInstagramInClickBackMicrosite"=>$data["ClickBackWeibo"],
          "ClickBannerInClickBackMicrosite"=>$data["ClickBackBanner"],

          "EDMLink1"=>$data["EDMLink1"],
          "EDMLink2"=>$data["EDMLink2"],
          "EDMLink3"=>$data["EDMLink3"],
          "EDMLink4"=>$data["EDMLink4"],
          "EDMLink5"=>$data["EDMLink5"],
          "EDMLink6"=>$data["EDMLink6"],
          "EDMLink7"=>$data["EDMLink7"],
          "EDMLink8"=>$data["EDMLink8"],
          "EDMLink9"=>$data["EDMLink9"],
          "EDMLink10"=>$data["EDMLink10"]

        );
      }
      $datas = $datas2;
      $this->response($datas2,200);
      return;
    }

    $results = array(
      "code"=>"OK",
      "total"=>count($datas),
      "data"=>$datas
    );

    $this->response($results,200);
  }
}
