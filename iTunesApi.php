<?php
/**
 * Created by PhpStorm.
 * User: thund
 * Date: 23.08.2019
 * Time: 19:36
 */

require('connect.php');
require('api.php');

$myConnect = new Connect();
$api = new Api();
$artistName = $_GET['artist'];
$resultArtist = $myConnect->getArtist($artistName);

if ( mysqli_num_rows($resultArtist) >= 1 ) {

    $status = "из Базы Данных <br>";
    $result = $myConnect->getAll($artistName);

} else {

    $status = "из api iTunes <br>";
    $result = $api->getApi($artistName);

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

    <div class="container m-auto">

        <?php

        foreach ($result as $person) {

            echo "<h1>Artist: {$person['artistName']}</h1><h3>ID: {$person['artistId']}</h3>";

            foreach ($person[$person['artistId']] as $album) {
        ?>

        <div class="card mb-3">
            <div class="card-header">
                <?php echo "<br> <h2>{$album['collectionName']}<h2>";?>
            </div>
            <div class="card-body">
                <?php

                if ( array_key_exists($album['collectionId'], $album) ) {

                    foreach ($album[$album['collectionId']] as $song) {

                        $min = floor($song['trackTimeMillis'] / 60000);
                        $sec = ceil(($song['trackTimeMillis'] - $min * 60000) / 1000);
                        $trackTime = "{$min}:{$sec}";
                        echo "<p class=\"card-text\">{$song['trackNumber']} {$song['trackName']} {$trackTime}</p>";
                }
                }?>
            </div>
        </div>
        <?php } } ?>
    </div>

</body>
</html>

<!---->
<!--<div class="card">-->
<!--    <div class="card-header">-->
<!--        Featured-->
<!--    </div>-->
<!--    <div class="card-body">-->
<!--        <h5 class="card-title">Special title treatment</h5>-->
<!--        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->
<!--        <a href="#" class="btn btn-primary">Go somewhere</a>-->
<!--    </div>-->
<!--</div>-->
<!---->
<?php
//
//foreach ($result as $person) {
//
//    echo "<h1>{$person['artistName']}<br>{$person['artistId']}</h1>";
//
//    foreach ($person[$person['artistId']] as $album) {
//
//        echo "<br> <h2>{$album['collectionId']} {$album['collectionName']} <h2>";
//
//        echo "это" . array_key_exists($album['collectionId'], $album);
//
//        if ( array_key_exists($album['collectionId'], $album) ) {
//
//            foreach ($album[$album['collectionId']] as $song) {
//
//                echo "<h3>{$song['trackName']}<h3>";
//            }
//        }
//    }
//}
//
//?>
