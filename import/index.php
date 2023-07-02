<?php
require_once './../config.php';
require_once('./getid3/getid3.php');
$getID3 = new getID3;

foreach (glob("$datadir/audio/*") as $file) unlink($file);
foreach (glob("$datadir/cover/*") as $file) unlink($file);

$now = time();
$nonce = 0;
$db = [];
foreach (glob("./que/*.mp3") as $file) {
  $tags = $getID3->analyze($file);
  $audio = file_get_contents($file, null, null, $tags['id3v2']['tag_offset_end'], $tags['avdataend']);
  $id = md5($now.$nonce);
  file_put_contents("$datadir/audio/$id.mp3", $audio);
  $nonce++;
  if (isset($tags['id3v2']['APIC'][0])) {
    $image = $tags['id3v2']['APIC'][0];
    list($type, $ext) = explode('/', $image['mime'], 2);
    file_put_contents("$datadir/cover/$id.$ext", $image['data']);
    unset($tags['id3v2']['APIC']);
  }
  $db[$id] = $tags['id3v2']['comments'];
  unlink($file);
}
$json = json_encode($db);
file_put_contents("$datadir/metadata/db.json", $json);
echo $json;

