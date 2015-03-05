<?php
function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

    return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}

header("Content-Type: image/png");

$im = imagecreatetruecolor(620, 300);
$color = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $color);
imagesavealpha($im, true);

$afta = "fonts/AftaSansThin-Regular.ttf";
$arial = "fonts/arial.ttf";

$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$green = imagecolorallocate($im, 0, 255, 0);

//imagecolortransparent($im, $white);

$bg = imagecreatefrompng("images/recon.png");
$emblem = imagecreatefrompng("images/emblem.png");
imagecopyresized($im, $emblem, 50, 50, 0, 0, 128, 128, 256, 256);
imagecopy($im, $bg, 161, 0, 0, 0, 297, 336);

imagettftext($im, 16, 0, 15, 30, $white, $afta, "[RAGE]I_EAT_TANKS");
imagettftext($im, 16, 0, 15, 250, $green, $afta, $_SERVER["REMOTE_ADDR"]);
//imagettftext($im, 16, 0, 15, 250, $green, $arial, "Testing a lot of text");
imagettfstroketext($im, 24, 0, 15, 280, $green, $black, $afta, "Testing a lot of text", 1);

imagepng($im);
imagedestroy($im);
?>