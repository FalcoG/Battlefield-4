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
$file = file_get_contents("playerInfo.json");

var_dump(json_decode($file));
?>
</body>
</html>