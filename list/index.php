<pre>
<?php
require_once './../config.php';
foreach (glob("$datadir/audio/*") as $index => $path) {
  $file = basename($path);
  list($id, $ext) = explode('.', $file);
  echo $index . '. <a href="audio?id='.$id.'">'.$id.'</a><br/>';
}
?>
</pre>