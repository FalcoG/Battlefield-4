<?php
header("Content-Type: image/png");
$im = imagecreate(620, 300);
$font = "fonts/AftaSansThin-Regular.ttf";

$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$green = imagecolorallocate($im, 0, 255, 0);

imagecolortransparent($im, $white);

$bg = imagecreatefrompng("images/recon.png");
imagecopy($im, $bg, 161, 0, 0, 0, 297, 336);

imagettftext($im, 16, 0, 15, 30, $black, $font, "I_EAT_TANKS");
imagettftext($im, 16, 0, 15, 280, $black, $font, $_SERVER["REMOTE_ADDR"]);

imagepng($im);
imagedestroy($im);
?>