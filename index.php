<?php
header("Content-Type: application/json");
echo json_encode([
  'service' => 'dStream',
  'version' => '1.0.0',
  'description' => 'dpop media stream server',
  'author' => 'DIDAVA'
]);
