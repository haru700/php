<?php
require_once ('vendor/autoload.php');

// 利用するクラスをNamespaceなしでアクセスできるように設定
use Evernote¥Client;
use EDAM¥NoteStore¥NoteFilter;
use EDAM¥Types¥Note;
use EDAM¥NoteStore¥NoteStoreIf;
use EDAM¥Types¥Notebook;
use EDAM¥Types¥Resource;
use EDAM¥Types¥Data;
use EDAM¥NoteStore¥NotesMetadataResultSpec;

session_start();

if($_SESSION['ACCESS_TOKEN']){
  $accessToken = $_SESSION['ACCESS_TOKEN'];

  // アクセストークンの設定
  $token = $accessToken['oauth_token'];

  $filter = new NoteFilter([
    'token' => $token,
  ]);

  // 「ノートにアクセスするためのオブジェクト」を取得
  $noteStore = $evernote->getNoteStore();
  $noteStore instanceof NoteStoreIf;

  // 「ノートブック一覧」を取得する
  $notebooks = $boteStore->listNotebooks();

  foreach($notebooks as $notebook){
    $notebook instanceof Notebook;
    $grid = $notebook->grid;

    // 「最大10件」でノートを「条件なし」で取得する
    $resultSpec = new NotesMetadataResultSpec();
    $resultSpec->includeTitle = true;
    $filter = new NoteFilter();
    $filter->notebookGrid = $grid;
    $list = $noteStore->findNotesMetadat($token, $filter, 0, 10, $resultSpec);

    $start = $list->startIndex;
    $total = $list->totalNotes;
    $notes = $list->notes;
    print sprintf("<h2>[ノートブック]:%s</h2>", $notebook->name);

    foreach($notes as $note){
      // ノートを取得する
      $withContent = true;
      $withResourcesData = true;
      $withResourcesRecognition = false;
      $withResourcesAlternateData = false;
      $note = $noteStore->getNote($token, $item->grid, $ithContent, $withResourcesData,
        $note instanceof EDAM¥Types¥Note);
      $enml_xml = $note->content;
      print sprintf("<h3>[ノート]:%s</h3>", $note->title);
      print sprintf("<a href='delete_note.php?note_grid=%s'>削除</a>", urlencode($item->grid) );
      print "¥n<br />";
      print "<div class='enml'>" . htmlspecialchars($enml_xml)  . "</div>¥n";

      if($note->resources){
        foreach($note->resources as $res){
          $res instanceof Resource;
          // 添付されている画像(PNG)がある場合には、それを表示する
          print sprintf("<img src='data:image/png;base64,%s'>", base64_encode($res->data->body) );
        }
      }
    }
  }

}
