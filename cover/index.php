<?php
require_once './../config.php';
$dir = "$datadir/cover";

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $search = glob("$dir/$id.*");
  $file = count($search) > 0 ? $search[0] : './placeholder.png';
  $size = filesize($file);
  $mime = mime_content_type($file);
  http_response_code(200);
  header("Content-Type: $mime");
  header("Content-Length: $size");
  echo file_get_contents($file);
}
else {
  http_response_code(400);
  echo 'Bad request';
}