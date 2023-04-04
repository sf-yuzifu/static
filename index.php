<?php
header('Access-Control-Allow-Origin:*');
if (date("m.d") == "03.05") {
    $path = "img_rice";
}
else {
    $path = "img";
}
header("Content-type: image/jpeg");
$url = './' . getRandomfile($path);
readfile ($url);

function getfilecounts($filePath)
{
    $dir = './' . $filePath;
    $handle = opendir($dir);
    $i = 0;
    while (false !== $file = (readdir($handle))) {
        if ($file !== '.' && $file != '..') {
            $i++;
        }
    }
    closedir($handle);
    return $i;
}

function getRandomfile($filePath)
{
    $trueFileNum = rand(1, getfilecounts($filePath));
    $dir = './' . $filePath;
    $handle = opendir($dir);
    $i = 0;
    while (false !== $file = (readdir($handle))) {
        if ($file !== '.' && $file != '..') {
            $i++;
            if ($i == $trueFileNum) {
                $trueFile = $file;
            }
        }
    }
    closedir($handle);
    return $filePath . "/" . $trueFile;
}
?>