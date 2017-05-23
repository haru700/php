<?php

require_once('/Users/haru/php/kbtit2/vendor/autoload.php');
use aws¥s3¥S3Client;

// キーを設定してクライアントクラスを生成
$client = S3Client::factory([
  'key' =>  '',
  'secret' => '',
]);

var_dump('=================='); var_dump('client');
var_dump($client); var_dump('==================');

// bucketを作成する
$bucket = [
  'Bucket' =>  'dmy_bucket',
];

$client->createBucket($bucket);

// bucketを削除する
$bucket = [
  'Bucket' =>  'dmy_bucket',
];

$client->deleteBucket($bucket);
