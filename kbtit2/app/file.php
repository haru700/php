<?php
// ファイルとフォルダの操作

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
$dropbox = new Dropbox_API($oauth, 'sandbox');

// ファイルの登録と削除
$data = $dropbox->putFile("sample2/sample.txt", "data/sample.txt");
$fp = fopen("out/sample.txt", "w");
fwrite($fp, $data);
fclose($fp);
