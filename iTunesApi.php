<?php
/**
 * Created by PhpStorm.
 * User: thund
 * Date: 23.08.2019
 * Time: 19:36
 */

require('connect.php');

$myConnect = new Connect();

function RequestToApi($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $arr = json_decode($response, true);
    return $arr['results'];
}

$artistName = $_GET['artist'];

$resultArtist = $myConnect->getArtist($artistName);

if ( mysqli_num_rows($resultArtist) >= 1 ) {

    echo "из Базы Данных <br>";

    while (  $rowArtist = mysqli_fetch_row($resultArtist) ) {

        echo "<br>artistId: {$rowArtist[0]}  artistName: {$rowArtist[2]}";
        $resultAlbum = $myConnect->getAlbum($rowArtist[0]);

        if ( mysqli_num_rows($resultAlbum) >= 1 ) {

            while ( $rowAlbum = mysqli_fetch_row($resultAlbum) ) {

                echo "<br>collectionId: {$rowAlbum[0]}  collectionName: {$rowAlbum[2]}";
                $resultSong = $myConnect->getSong($rowAlbum[0]);

                if ( mysqli_num_rows($resultSong) >= 1 ) {

                    while ( $rowSong = mysqli_fetch_row($resultSong) ) {
                        $min = floor($rowSong[9] / 60000);
                        $sec = ceil(($rowSong[9] - $min * 60000) / 1000);
                        $trackTime = "{$min}:{$sec}";
                        echo "<br>{$rowSong[8]})  {$rowSong[2]}  {$trackTime}";
                    }
                }
            }
        }
    }

} else {

    echo "из api iTunes <br>";

    $artistName = str_replace(" ", "+", $artistName);
    $url = "https://itunes.apple.com/search?term={$artistName}&entity=allArtist";
    $artistInfo = RequestToApi($url);

    foreach ($artistInfo as $person) {

        $myConnect->addArtist($person);
        echo "artistName: {$person['artistName']}<br> artistId: {$person['artistId']}<br>";

        $url = "https://itunes.apple.com/lookup?id=" . $person["artistId"] . "&entity=album";
        $albums = RequestToApi($url);
        array_shift($albums);

        foreach ($albums as $album) {

            $myConnect->addAlbum($album);
            echo "<br> collectionName: " . $album["collectionName"] . "<br>";
            $url = "https://itunes.apple.com/lookup?id=" . $album["collectionId"] . "&entity=song";
            $albumSongs = RequestToApi($url);
            array_shift($albumSongs);

            foreach ($albumSongs as $song) {

                $myConnect->addSong($song);
                $min = floor($song["trackTimeMillis"] / 60000);
                $sec = ceil(($song["trackTimeMillis"] - $min * 60000) / 1000);
                echo "<br>trackName: {$song["trackName"]} trackTime {$min}:{$sec}";

            }
            echo "<br>";
        }
        echo "<hr>";
    }
}
