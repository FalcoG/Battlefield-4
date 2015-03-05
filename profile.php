<?php
//$file = file_get_contents("http://api.bf4stats.com/api/playerInfo?plat=pc&name=I_EAT_TANKS&output=json");
$username = "I_EAT_TANKS";
$file = file_get_contents("playerInfo.json");
$stats = json_decode($file);

function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

    return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}

function imagettftextcenter($image, $font_size, $angle, $x, $y, $color, $font, $string){
    $type_space = imagettfbbox($font_size, 0, $font, $string);
    $text_width = abs($type_space[4] - $type_space[0]);

    imagettftext($image, $font_size, $angle, $x-($text_width/2), $y, $color, $font, $string);
}

header("Content-Type: image/png");

$im = imagecreatetruecolor(620, 300);
$color = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $color);
imagesavealpha($im, true);

$afta = "fonts/AftaSansThin-Regular.ttf";
$Arial = "fonts/arial.ttf";
$ArialBold = "fonts/arialbd.ttf";
$PuristaSemibold = "fonts/PuristaSemibold.ttf";
$PuristaBold = "fonts/PuristaBold.ttf";

$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$green = imagecolorallocate($im, 0, 255, 0);

$grey = imagecolorallocate($im, 168, 168, 168);

$bg = imagecreatefrompng("images/recon.png");
$emblem = imagecreatefrompng("images/emblem.png");
imagecopyresized($im, $emblem, 50, 95, 0, 0, 128, 128, 256, 256);
imagecopy($im, $bg, 161, 0, 0, 0, 297, 336);

imagettftext($im, 16, 0, 15, 95, $white, $Arial, "[" . $stats->player->tag . "] " . $username);
/*
/* --------------- BATTLEFIELD STATS ----------------- */

imagettftextcenter($im, 10, 0, 470, 65, $grey, $Arial, "K/D");
imagettftextcenter($im, 16, 0, 470, 95, $white, $PuristaSemibold, round($stats->stats->extra->kdr, 2, PHP_ROUND_HALF_DOWN));

imagettftextcenter($im, 10, 0, 560, 65, $grey, $Arial, "SPM");
imagettftextcenter($im, 16, 0, 560, 95, $white, $PuristaSemibold, floor($stats->stats->extra->spm));

/* --------------------------------------------------- */

imagettftextcenter($im, 10, 0, 470, 140, $grey, $Arial, "KILLS");
imagettftextcenter($im, 12, 0, 470, 170, $white, $PuristaSemibold, $stats->stats->kills);

imagettftextcenter($im, 10, 0, 560, 140, $grey, $Arial, "KPM");
imagettftextcenter($im, 16, 0, 560, 170, $white, $PuristaSemibold, round($stats->stats->extra->kpm, 2, PHP_ROUND_HALF_DOWN));

/* --------------------------------------------------- */

imagettftextcenter($im, 10, 0, 470, 215, $grey, $Arial, "SCORE");
imagettftextcenter($im, 10, 0, 470, 235, $white, $PuristaSemibold, $stats->player->score);

$seconds = $stats->player->timePlayed;
$time = floor($seconds/3600). "h " . gmdate("i", $seconds) . "m ";

imagettftextcenter($im, 10, 0, 560, 215, $grey, $Arial, "TIME");
imagettftextcenter($im, 10, 0, 560, 235, $white, $PuristaSemibold, $time);


imagepng($im);
imagedestroy($im);

?>