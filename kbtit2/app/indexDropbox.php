<?php
require_once('/Users/haru/php/kbtit2/vendor/autoload.php');

// 初期設定
$apiKey = "o8q6m155fbtrsc9";
$apiSecret = "kfu3shoe7bl4dkn";
$oauth = new Dropbox_OAuth_PHP($apiKey, $apiSecret);
session_start();

try{
  if(!isset($_SESSION['state'])  ){
    $_SESSION['state'] = 1;
  }
  $state = $_SESSION['state'];

  switch($state){
    // Dropbox認証ページへの遷移
    case 1 :
      $token = $oauth->getRequestToken();
      if($token){
        $_SESSION['token'] = $token;
        $_SESSION['state'] = 2;
        $url = $oauth->getAuthorizeUrl($_SERVER['SCRIPT_URI']);
        print "認証がされていません";
        print sprintf("<br /><a href='%s'>Dropboxの認証に進む</a>", $url);
      }
      break;

    case 2 :
      $oauth->setToken($_SESSION['token']);
      $token = $oauth->getAccessToken();
      $_SESSION['token'] = $token;
      $_SESSION['state'] = 3;

    case 3 :
      print "認証済み\n";
      print sprintf("<br /><a href='%s'>Dropboxの操作に進む</a>", 'list.php');
      break;
  }
}catch($xception $ex){
  $_SESSION['state'] = 1;
  print($ex->getMessage() );
}
