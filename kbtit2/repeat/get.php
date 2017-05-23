<?php

require_once('/Users/haru/php/kbtit2/vendor/autoload.php');
use aws¥s3¥S3Client;

// キーを設定してクライアントクラスを生成
$client = S3Client::factory([
  'key' =>  '',
  'secret' => '',
]);

$temp_file = tempnam("data", "tmp-");

// データ取得
$ret = $client->getObject([
  'Bucket' => 'mookphp',
  'Key' => 'sample/data1.txt',
  'SaveAs' => $temp_file,
]);

// データの<meta charset="utf-8">情報
$size = $ret['ContentLength']; # => "20"
$type = $ret['ContentType']; # => "text/plain"
$mtime = $ret['LastModified']; # => "Sat, 01 Mar 2014 07:45:45 GMT"
