<?php
require_once ('vendor/autoload.php');
use Bullet¥App;

// Bulletオブジェクトの生成
$app = new App();

// イベントの定義
$app->path('/hello', function($request) use($app){
  $app->param('int', function($request, $postId) use($app){
    return "int " . $postId;
  });
  $app->param('slug', function($request, $postId) use($app){
    return "slug " . $postId;
  });
});

// ルーティングの実行
echo $app->run(new Bullet¥Request() );
