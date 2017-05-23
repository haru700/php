<?php
// ファイル位置rん取得

// アクセスキーとシークレットキーを設定
require_once('/Users/haru/php/kbtit2/vendor/autoload.php');

// 初期設定
$apiKey = "o8q6m155fbtrsc9";
$apiSecret = "kfu3shoe7bl4dkn";
$oauth = new Dropbox_OAuth_PHP($apiKey, $apiSecret);
session_start();

// 初期設定
$token = $_SESSION['token'];
$oauth->setToken($token);
$droxbox = new Dropbox_API($oauth, 'sandbox');

// フォルダの情報(ファイル一覧)を取得
$folder = isset($_GET['path'])? $_GET['path'] : '';
$meta = $dropbox->getMetaData($folder, true);

if($meta){
  $list = $meta['contents'];
  foreach($list as $item){
    print_r($item);
  }
}
