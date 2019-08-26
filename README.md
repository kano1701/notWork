# iTunes

решение в ветке AddClass

запросы посылаемые к iTunesAPI

для поиска исполнителя      $url = "https://itunes.apple.com/search?term={$name}&entity=allArtist";

для поиска альбомов         $url = "https://itunes.apple.com/lookup?id={$person["artistId"]}&entity=album";

для поиска песен в альбоме  $url = "https://itunes.apple.com/lookup?id={$album["collectionId"]}&entity=song";
