<?php
require_once('/Users/haru/php/kbtit2/vendor/knplabs/github-api/lib/Github/Client.php');

$client = new Client();

// キーワードからのリポジトリを検索
$repo = $client->api('repo');
$repo instanceof GitHub¥Api¥Repo;
// キーワードは 'kbtit'
$repos = $repo->find('kbtit', [
  // 言語は 'php'
  'language' => 'php',
]);

$list = $repos['repositories'];
$coun = $count($list);

print sprintf("全部で%s件のリポジトリが見つかりました<br />", $count);

foreach($list as $repository){
  // リポジトリ情報の表示
  print sprintf("<h1><a href='%s' target='_blank'>%s</a></h1>¥n",
    $repository['url'], $repository['name']);
  print sprintf("followers:%s/forks:%s<span><br />",
    $repository['followers'], $repository['forks']);
  $desc = $repository['description'];
  print sprintf("<p>%s</p>¥n", htmlspecialchars($desc) );

  if($repository['language']){
    print sprintf("<p>lang:%s</p>", $repository['language']);
  }

}
