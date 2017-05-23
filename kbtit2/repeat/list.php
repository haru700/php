<?php

require_once('/Users/haru/php/kbtit2/vendor/autoload.php');
use aws¥s3¥S3Client;

// キーを設定してクライアントクラスを生成
$client = S3Client::factory([
  'key' =>  '',
  'secret' => '',
]);

$bucket = 'mookphp';

// 全てのオブジェクトを取得する
print "<h2>すべてのオブジェクト一覧</h2>";
print "<ul>";
  foreach($iterator as $item){
    print sprintf("<li><a href='get.php?key=%s'>%s</a></li>",
                    $urlencode($item['Key']),
                    $item['Key']
                  );
  }

  $param = [
    'Bucket' =>  $bucket,
    'Prefix' => 'sample/',
    'Delimitor' => '/',
  ];

  $iterator = $client->getListObjectsIterator($param);

  foreach($iterator as $item){
    print sprintf("<li><a href='get.php?key=%s'>%s</a></li>",
                    $urlcode($item['Key']),
                    $item['Key'],
                  );
  }
  
print"</ul>";
