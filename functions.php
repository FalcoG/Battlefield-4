<?php
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

function serviceStarProgress($image, $font_size, $angle, $x, $y, $color, $font, $string, $class){
    global $grey, $stats, $orange;
    imagerectangle($image, $x-51, $y-19, $x+51, $y+5, $grey);

    $kit = imagecreatefrompng("images/kit-icons-small.png");
    $serviceStar = imagecreatefrompng("images/servicestar-18x18.png");
    $progress = 0;
    if($class == "assault") {
        $progress = (($stats->stats->kits->$class->score/155000) - $stats->stats->kits->$class->stars) * 100;
        $kit_x = 0;
    }else if($class == "engineer") {
        $progress = (($stats->stats->kits->$class->score/131000) - $stats->stats->kits->$class->stars) * 100;
        $kit_x = 32;
    }else if($class == "support") {
        $progress = (($stats->stats->kits->$class->score/134000) - $stats->stats->kits->$class->stars) * 100;
        $kit_x = 64;
    }else if($class == "recon") {
        $progress = (($stats->stats->kits->$class->score/104000) - $stats->stats->kits->$class->stars) * 100;
        $kit_x = 96;
    }else if($class == "commander") {
        $progress = (($stats->stats->kits->$class->score/20000) - $stats->stats->kits->$class->stars) * 100;
        $kit_x = 128;
    }

    imagefilledrectangle($image, $x-50, $y-18, $x-50+$progress, $y+4, $orange);
    imagecopy($image, $serviceStar, $x-20, $y-16, 0, 0, 18, 18);
    imagecopy($image, $kit, $x -90, $y-22, $kit_x, 0, 32, 32);
    imagettftext($image, $font_size, $angle, $x, $y, $color, $font, $string);
}

function time_elapsed_string($timestamp, $full = false) {
    $now = new DateTime;
    $ago = new DateTime("@$timestamp");
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}