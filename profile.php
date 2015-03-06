<?php
require("functions.php");

if(!empty($_GET["user"])){
    $username = $_GET["user"];
    $file = file_get_contents("http://api.bf4stats.com/api/playerInfo?plat=pc&name=" . $username . "&opt=stats,extra&output=json");
}else{
    $file = file_get_contents("playerInfo.json");
    $username = "I_EAT_TANKS";
}

$stats = json_decode($file);

/* Load IMG files from user*/
$html = file_get_contents("http://battlelog.battlefield.com/bf4/user/" . $username);

$doc = new DOMDocument();
@$doc->loadHTML($html);

$tags = $doc->getElementsByTagName('img');

foreach($tags as $tag){
    $searchEmblem = strpos($tag->getAttribute('src'), "emblem");
    $searchSoldier = strpos($tag->getAttribute('src'), "bf4/soldier/large/");
    if($searchEmblem){
        $emblemSrc = $tag->getAttribute('src');
    }

    if($searchSoldier){
        $soldierSrc = "http:" . $tag->getAttribute('src');
    }
}
/* --------------------------------------------------- */

$types = array("classic", "infantry");

if(!empty($_GET["type"])){
    if(In_Array($_GET["type"], $types)){
        $layout = $_GET["type"];
    }else{
        $layout = "classic";
    }
}else{
    $layout = "classic";
}

header("Content-Type: image/png");

$im = imagecreatetruecolor(620, 300);
$color = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $color);
imagesavealpha($im, true);

$afta            = "fonts/AftaSansThin-Regular.ttf";
$Arial           = "fonts/arial.ttf";
$ArialBold       = "fonts/arialbd.ttf";
$PuristaSemibold = "fonts/PuristaSemibold.ttf";
$PuristaBold     = "fonts/PuristaBold.ttf";

$white  = imagecolorallocate($im, 255, 255, 255);
$black  = imagecolorallocate($im, 0, 0, 0);
$green  = imagecolorallocate($im, 0, 255, 0);
$grey   = imagecolorallocate($im, 168, 168, 168);
$orange = imagecolorallocate($im, 235, 161, 21);

$soldier = imagecreatefrompng($soldierSrc);
$emblem = imagecreatefrompng($emblemSrc);

if($stats->player->tag == ""){
    $prefix = "";
}else{
    $prefix = "[" . $stats->player->tag . "] ";
}

if($layout == "classic") {
    imagecopyresized($im, $emblem, 50, 95, 0, 0, 128, 128, 256, 256);
    imagecopy($im, $soldier, 161, 0, 0, 0, 297, 336);

    imagettftext($im, 16, 0, 15, 95, $white, $Arial, $prefix . $username);
    /* --------------- BATTLEFIELD STATS ----------------- */

    imagettftextcenter($im, 10, 0, 470, 65, $grey, $Arial, "K/D");
    imagettftextcenter($im, 16, 0, 470, 95, $white, $PuristaSemibold, round($stats->stats->extra->kdr, 2, PHP_ROUND_HALF_DOWN));

    imagettftextcenter($im, 10, 0, 560, 65, $grey, $Arial, "SPM");
    imagettftextcenter($im, 16, 0, 560, 95, $white, $PuristaSemibold, floor(round($stats->stats->extra->spm, 1)));

    /* --------------------------------------------------- */

    imagettftextcenter($im, 10, 0, 470, 140, $grey, $Arial, "KILLS");
    imagettftextcenter($im, 12, 0, 470, 170, $white, $PuristaSemibold, $stats->stats->kills);

    imagettftextcenter($im, 10, 0, 560, 140, $grey, $Arial, "KPM");
    imagettftextcenter($im, 12, 0, 560, 170, $white, $PuristaSemibold, round($stats->stats->extra->kpm, 2, PHP_ROUND_HALF_DOWN));

    /* --------------------------------------------------- */

    imagettftextcenter($im, 10, 0, 470, 215, $grey, $Arial, "SCORE");
    imagettftextcenter($im, 10, 0, 470, 240, $white, $PuristaSemibold, number_format($stats->player->score));

    $seconds = $stats->player->timePlayed;
    $time = floor($seconds / 3600) . "h " . gmdate("i", $seconds) . "m ";

    imagettftextcenter($im, 10, 0, 560, 215, $grey, $Arial, "TIME");
    imagettftextcenter($im, 10, 0, 560, 240, $white, $PuristaSemibold, $time);

    /* --------------------------------------------------- */

    $seconds = floor($stats->player->dateUpdate/1000);
    imagettftextcenter($im, 8, 0, 515, 285, $grey, $Arial, "Last update: " . time_elapsed_string($seconds));
}else{
    imagecopyresized($im, $emblem, 50, 95, 0, 0, 128, 128, 256, 256);
    imagecopy($im, $soldier, 161, 0, 0, 0, 297, 336);

    /* --------------------------------------------------- */

    imagettftext($im, 16, 0, 15, 95, $white, $Arial, $prefix . $username);
    serviceStarProgress($im, 14, 0, 520, 65, $white, $PuristaSemibold, $stats->stats->kits->assault->stars, "assault");
    serviceStarProgress($im, 14, 0, 520, 105, $white, $PuristaSemibold, $stats->stats->kits->engineer->stars, "engineer");
    serviceStarProgress($im, 14, 0, 520, 145, $white, $PuristaSemibold, $stats->stats->kits->support->stars, "support");
    serviceStarProgress($im, 14, 0, 520, 185, $white, $PuristaSemibold, $stats->stats->kits->recon->stars, "recon");
    serviceStarProgress($im, 14, 0, 520, 225, $white, $PuristaSemibold, $stats->stats->kits->commander->stars, "commander");

    /* --------------------------------------------------- */

    $seconds = floor($stats->player->dateUpdate/1000);
    imagettftextcenter($im, 8, 0, 515, 285, $grey, $Arial, "Last update: " . time_elapsed_string($seconds));
}

imagepng($im);
imagedestroy($im);