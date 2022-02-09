<?php
//this function saves recent searches to a cookie
function recentSearches($recentSearch='')
{
    // if the cookie exists, read it and unserialize it. If not, create a blank array
    if ($recentSearch != '') {
        ///if array exsits read it and add $recentSearch value, Else create a new array
        if (array_key_exists('recentSearches', $_COOKIE)) {
            $cookie = $_COOKIE['recentSearches'];
            $cookie = unserialize($cookie);
            }
        else {
            $cookie = array();
            }

    $cookie[] = $recentSearch;


    // save the cookie
    setcookie('recentSearches', serialize($cookie), time() + 3600);
}
}

function recentSearchesTable()
{
    $searchesArray = unserialize($_COOKIE['recentSearches'], ["allowed_classes" => false]);

    //reverse array so most recent searches are first && remove duplicates
    $searchesArray = array_reverse($searchesArray);
    $searchesArray = array_unique($searchesArray);

    echo "<h2>Your recent searches:</h2><br>";
    echo "<ul class='list-group'>";
    //output searches as list, limited to last 3 searches
    foreach (array_slice($searchesArray, 0, 3) as $searchTerm) {

    echo "<li class='list-group-item'><button type='button' class='btn btn-link'><a href='index.php?search={$searchTerm}&page=1'>$searchTerm</a></button></li>";
}
    echo "</ul>";
}

function cleanSearchInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    ///Replace white spaces with +
    $searchString = " ";
    $replaceString = "+";
    $data = str_replace($searchString, $replaceString, $data);

    return $data;
}

//this function accepts a search term and a page number
// then requests images that match this search term from the unsplash api
// and the page of results it wants
function searchPhoto($query, $page = 1)
{
    $ch = curl_init();
    if ($query == ""){
        echo "<h1>Please enter a search term.</h1>";
        randomPhoto();
    } else {
        echo "<h1>You searched for: $query</h1>";
    }
    $query = cleanSearchInput($query);
    $page = cleanSearchInput($page);
    $url = "https://api.unsplash.com/search/photos?page={$page}&per_page=9&query='{$query}'&client_id=JfslSx-D_qWAmT2v0GDJoHQCcPNopiXkusPGA6JeXyc";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($err = curl_error($ch)) {
        echo $err;
    } else {
        $decoded = json_decode($response, true);

    }
    $i = 0;
    $picList = array();
    //Extract links and image descriptions from JSON response and put them into an array, which is then outputted
    foreach ($decoded['results'] as $result) {
        $links = $result["urls"];
        $source = $links['small'];
        $alt = $result["description"];
        array_push($picList, array($source, $alt));
        $i++;
    }

    curl_close($ch);
    return $picList;
}
//function to generate the picture cards and image descriptions, accepts and array as a parameter
function searchPictureCardGenerator($picList){
    foreach ($picList as $link){
        echo '<div class="col-md-4 mb-5">';
        echo '<div class="card h-100">';
        echo "<div class='card-body'>";

        echo "<a href='{$link[0]}'><img class='card-img' src='{$link[0]}' height='200' width='200'></a>";
        echo "</div>";
        echo "<div class='card-body'> <p> {$link[1]}</p> </div>";
        echo "</div>";
        echo "</div>";

    }
}

//this function returns a list of urls for random images from the unsplash api
function randomPhotoList()
{
    $ch = curl_init();
    $random = rand(1,100);
    $url = "https://api.unsplash.com/photos?page={$random}&per_page=9&client_id=JfslSx-D_qWAmT2v0GDJoHQCcPNopiXkusPGA6JeXyc";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($err = curl_error($ch)) {
        echo $err;
    } else {
        $decoded = json_decode($response, true);
    }
    $i = 0;
    $picList = array();
    //Extract links from JSON response and put them into an array, which is then outputted
    foreach ($decoded as $result) {

        $links = $result["urls"];
        $source = $links['small'];
        $picList[$i] = $source;
        $i++;
    }


    curl_close($ch);
    return $picList;
}

//function to generate the picture cards, accepts and array as a parameter
function randomPictureCardGenerator($picList){
    foreach ($picList as $link){
        echo '<div class="col-md-4 mb-5">';
        echo '<div class="card h-100">';
        echo "<div class='card-body'>";

        echo "<a href='{$link}'><img class='card-img' src='{$link}' height='200' width='200'></a>";
        echo "</div>";

        echo "</div>";
        echo "</div>";

    }
}

//function which produces navbar
function navbarFunction(){
    for ($x = 1; $x <= 10; $x++) {
        echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page={$x}'>{$x}</a></li>";
    }
}

?>