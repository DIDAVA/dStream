<?php

require_once './../config.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $search = glob("$datadir/audio/$id.*");
  $file = count($search) > 0 ? $search[0] : 'ad.mp3';
  $size = filesize($file);
  $mime = mime_content_type($file);
  http_response_code(206);
  header("Content-Type: $mime");
  header('Accept-Ranges: bytes');
  if (!empty($_SERVER['HTTP_RANGE'])) {
    $chunk = 100*1024;
    $range = str_replace('bytes=', '', $_SERVER['HTTP_RANGE']);
    list($start) = explode('-', $range, 1);
    $start = (int) $start;
    $max = $start + $chunk;
    $end = $max > $size ? $size : $max;
    header("Content-Range: bytes $start-$end/$size");
    $data = file_get_contents($file, null, null, $start, $end);
    echo $data;
  }
}
else {
  http_response_code(400);
  echo 'Bad request';
}
