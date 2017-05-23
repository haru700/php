<?php
ini_set('error_reporting',E_ALL);
require_once('./OpenSearch.php');

//はてなキーワードのエンドポイント
$url = "http://search.hatena.ne.jp/osxml";

// 「エンドポイント」を指定して初期化処理
$foo = new Services_OpenSearch($url);
var_dump('=================='); var_dump('foo'); var_dump($foo); var_dump('==================');
