<?php
require_once('/Users/haru/php/kbtit2/vendor/autoload.php');
use aws¥s3¥S3Client;

// 「文字列」からの登録
$result = $client->putObject($[
  'Bucket' => 'mookphp',
  'Key' => 'sample/data1.txt',
  'Body' => 'Hello!',
]);

// 「ファイル名」から登録
$client->putObject([
  'Bucket' => 'mookphp',
  'Key' => 'sample/data1.txt',
  'SourceFile' => 'data/test.txt',
]);
