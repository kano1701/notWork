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

    echo "из Базы Данных <br>";
    $result = $myConnect->getAll($artistName);

} else {

    echo "из api iTunes <br>";
    $result = $api->getApi($artistName);

}

//var_dump($result);

foreach ($result as $person) {

    echo "{$person['artistName']}<br>{$person['artistId']}<hr>";

    foreach ($person[$person['artistId']] as $album) {

        echo "<br> {$album['collectionId']} {$album['collectionName']}<br>";

        echo array_key_exists($album['collectionId'], $album);

        if ( array_key_exists($album['collectionId'], $album) ) {

            echo "<br>есть";

            foreach ($album[$album['collectionId']] as $song) {

                echo "    {$song['trackName']}<br>";
            }
        } else {

            echo "<br>нету";
        }
    }
}
