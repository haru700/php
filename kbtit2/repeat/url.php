<?php
// 「ダウンロードURL」の生成
$url1 = $client->getObjectUrl('mookphp', "sample/data1.txt");
print sprintf("<a href='%s'>%s</a>", $url1, $url1);
print "<br />";


// 「5分間だけDLできる」URLを作成
$url2 = $client->getObjectUrl('mookphp', "sample/data2.txt", "+5 minutes");
print sprintf("<a href='%s'>%s</a>", $url2, $url2);
