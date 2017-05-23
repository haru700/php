<?php
require_once('/Users/haru/php/pear/Services_OpenSearch-0.2.0/OpenSearch.php');

//はてなキーワードのエンドポイント
$url = "http://search.hatena.ne.jp/osxml";

// 「エンドポイント」を指定して初期化処理
$os = new Services_OpenSearch($url);

// キーワードを指定して検索を実行
$result = $os->search("ソチオリンピック");

// RSS2.0の書式で検索結果を取得
foreach($result as $item){
  $title = $item['title'];
  $link = $item['link'];
  $description = $item['description'];

  echo "<a href=¥"" . $link . "¥">" . $title "</a><br>";
  echo $description . "<br><br>"
}
