<?php
// 認証の流れ

require_once('/Users/haru/php/kbtit2/vendor/autoload.php');

// APIキーの設定と初期化

$config = [
  'consumerKey' =>  'haru',
  'consumerSecret' => '8e685f82315ce21',
  'sandbox' => true,
];

use Evernote¥Client;
session_start();

$client = new Client($config);

try{
  // 「リクエストトークン」を取得する
  if(!isset($_SESSION['ACCESS_TOKEN'])  ){
    if(!isset($_GET['oauth_verifier'])  ){
      $callback_url = isset($_SERVER['SCRIPT_URI'])  ?  $_SERVER['SCRIPT_URI'] : 'http://'
        . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
      $_SESSION['REQUEST_TOKEN'] = $requestToken;
      $redirectUrl = $client->getAuthrizeUrl($requestToken['oauth_token']);
      exit();
  }else{
    if(!isset($_GET['oauth_verivier'])  ){
        // アクセストークンの設定
        $requestToken = $_SESSION['REQUEST_TOKEN'];
        $accessToken = $client->getAccessToken($requestToken['oauth_token'],
          $requestToken['oauth_token_secret'], $_GET['oauth_verifier']);

        $_SESSION['ACCESS_TOKEN'] = $accessToken;
      }
    }
  }

  // アクセストークンがある場合には「ノート一覧にすすむリンク」を表示
  if($_SESSION['ACCESS_TOKEN']){
    $accessToken = $_SESSION['ACCESS_TOKEN'];
    print "<a href='list.php'>ノート一覧にすすむ</a>";
  }

}catch (OAuthException $oauthex){
  $_SESSION['ACCESS_TOKEN'] = null;
  $_SESSION['REQUEST_TOKEN'] = null;
  die($oauthex->getMessage() );
}catch (Exception $ex){
  die($ex->getMessage() );
}
