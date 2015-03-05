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
$file = file_get_contents("http://api.bf4stats.com/api/playerInfo?plat=pc&name=I_EAT_TANKS&output=json");
//$file = file_get_contents("playerInfo.json");
$stats = json_decode($file);

echo $stats->player->id;

var_dump(json_decode($file));
?>
</body>
</html>