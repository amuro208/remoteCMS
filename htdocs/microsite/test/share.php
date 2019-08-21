<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8"/>
  
  <!--Facebook TAG-->
  <meta property="og:image" content="http://www.nslockerroom.com/test.png"/>
  <meta property="og:title" content="Share Image Test"/>
  <meta property="og:description" content="Share Image Test"/>
  <meta property="og:url" content="http://www.nslockerroom.com/share.php?q=<?php echo $_REQUEST["q"];?>"/>
  
  <!--Twitter TAG-->
  <meta property="twitter:image" content="http://www.nslockerroom.com/test.png"/>
  <meta property="twitter:title" content="Share Image Test"/>
  <meta property="twitter:description" content="Share Image Test"/>
  <meta property="twitter:url" content="http://www.nslockerroom.com/share.php?q=<?php echo $_REQUEST["q"];?>"/>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  
  <style>
    ul {
      list-style: none !important;
      margin: 0px !important;
      padding: 0px !important;
    }
     
    li {
      display: inline-block;
      width: 12px;
      height: 12px;
      color: #FFFFFF;
      border-radius: 50%;
      margin: 5px;
      padding: 10px;
    }
     
    li:hover {
      opacity: 0.8;
    }
     
    .fb {
      background: #3b5998;
    }
     
    .twitter {
      background: #00aced;
    }
     
    .google {
      background: #dd4b39;
    }
     
    .pinterest {
      background: #cb2027;
    }
     
    .linkedin {
      background: #007bb6;
    }
  </style>
</head>
<body>
  <ul>
    <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.nslockerroom.com/share.php?q=<?php echo $_REQUEST["q"];?>" target="_blank"><li class="fb"><i class="fa fa-facebook"></i></li></a>

    <a href="https://twitter.com/home?status=http://www.nslockerroom.com/share.php?q=<?php echo $_REQUEST["q"];?>" target="_blank"><li class="twitter"><i class="fa fa-twitter"></i></li></a>

    <a href="https://plus.google.com/share?url=http://www.nslockerroom.com/share.php?q=<?php echo $_REQUEST["q"];?>" target="_blank"><li class="google"><i class="fa fa-google-plus"></i></li></a>

    <a href="https://pinterest.com/pin/create/button/?url=http://www.nslockerroom.com/share.php?q=<?php echo $_REQUEST["q"];?>" target="_blank"><li class="pinterest"><i class="fa fa-pinterest-p"></i></li></a>

    <a href="https://www.linkedin.com/shareArticle?mini=true&url=http://www.nslockerroom.com/share.php?q=<?php echo $_REQUEST["q"];?>&title=http://www.nslockerroom.com/share.php?q=<?php echo $_REQUEST["q"];?>"><li class="linkedin"><i class="fa fa-linkedin"></i></li></a>
  </ul>
</body>
</html>
