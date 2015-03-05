<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        img{background:black;}
    </style>
</head>
<body>

<img src="profile.php">

<?php
/*
$file = fopen("http://api.bf4stats.com/api/playerInfo?plat=pc&name=I_EAT_TANKS&output=js", "r");
if (!$file) {
    echo "<p>Unable to open remote file.\n";
    exit;
}
*/
//$file = file_get_contents("http://api.bf4stats.com/api/playerInfo?plat=pc&name=I_EAT_TANKS&output=json");
$file = file_get_contents("playerInfo.json");

//echo $file;
var_dump(json_decode($file));
/*
while (!feof ($file)) {
    var_dump($file);
}
*/
?>
</body>
</html>