<?php
$url = $_SERVER["QUERY_STRING"];
?>

<iframe src="<?=substr($url,4)?>" sandbox="allow-forms allow-scripts allow-same-origin allow-popups"></iframe>

<style>
  iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: unset;
  }
</style>