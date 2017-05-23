<?php
require_once ('/Users/haru/php/kbtit2/vendor/autoload.php');

use Bullet¥App;


// Bulletオブジェクトの生成
$app = new Bullet¥App();

// イベントの定義
$app->path('/hello', function($request){
  return "Hello World!";
});

// ルーティングの実行
echo $app->run(new Bullet¥Request() );
