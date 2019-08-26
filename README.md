# iTunes

решение в ветке AddClass

запросы к iTunes Api

запрос на поиск исполнителя

"https://itunes.apple.com/search?term={$name}&entity=allArtist"

запрос на поиск альбомов исполнителя

https://itunes.apple.com/lookup?id={$person["artistId"]}&entity=album

запрос на поиск песен альбома

https://itunes.apple.com/lookup?id={$album["collectionId"]}&entity=song

