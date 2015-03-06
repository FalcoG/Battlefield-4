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
<img src="profile.php?type=infantry">

<?php
if(!empty($_GET["user"])){
    $username = $_GET["user"];
    $file = file_get_contents("http://api.bf4stats.com/api/playerInfo?plat=pc&name=" . $username . "&output=json");
}else{
    $file = file_get_contents("playerInfo.json");
    $username = "I_EAT_TANKS";
}

$stats = json_decode($file);

//var_dump($stats->stats->kits);
var_dump(json_decode($file));
?>
</body>
</html>