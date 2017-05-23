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

$accessToken = $_SESSION['ACCESS_TOKEN'];
$token = $accessToken['oauth_token'];
$evernote = new Client([
  'token' => $token,
]);

$noteStore = $evernote->getnoteStore();
$noteStore instanceof NoteStoreIf;

// ノートブックの生成
$notebook = new Notebook();
$notebook->name = 'API集';
$noteStore->createNotebook($token, $notebook);
