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
    global $grey;
    imagettftext($image, $font_size, $angle, $x, $y, $color, $font, $string);
    imagerectangle($image, $x-50, $y-19, $x+50, $y+5, $grey);

    $serviceStar = imagecreatefrompng("images/servicestar-18x18.png");
    imagecopy($image, $serviceStar, $x-20, $y-16, 0, 0, 18, 18);

    $kit = imagecreatefrompng("images/kit-icons-small.png");
    if($class == "assault") {
        imagecopy($image, $kit, $x -90, $y-22, 0, 0, 32, 32);
    }else if($class == "engineer") {
        imagecopy($image, $kit, $x -90, $y-22, 32, 0, 32, 32);
    }else if($class == "support") {
        imagecopy($image, $kit, $x -90, $y-22, 64, 0, 32, 32);
    }else if($class == "recon") {
        imagecopy($image, $kit, $x -90, $y-22, 96, 0, 32, 32);
    }else if($class == "commander") {
        imagecopy($image, $kit, $x -90, $y-22, 128, 0, 32, 32);
    }
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
?>