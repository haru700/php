<?php
// ライブラリ / 設定ファイルを読み込む
require_once ('Hybrid/Auth.php');
require_once ('Hybrid/Endpoint.php');

$config = 'config.php';

// 初期化処理
$auth = new Hybrid_Auth($config);

// セッションの開始、認証の実行
session_start();

$twitter = $auth->authenticate('Twitter');

// 認証後の処理
// 「ユーザ情報」を取得
$twitter_user_profile = $twitter->getUserProfile();
// @以下
$twitter_id = $twitter_user_profile->identifier;
// 表示名
$twitter_name = $twitter->displayName;

echo "ようこそ、" . $twitter_name . "さん";
