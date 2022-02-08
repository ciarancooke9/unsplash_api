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
    } else {
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

    echo "<li class='list-group-item'><a href='index.php?search={$searchTerm}&page=1'>$searchTerm</a></li>";
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
        //echo '<pre>'; print_r($decoded); echo '</pre>';
    }
    $i = 0;
    $pic_list = array();

    foreach ($decoded['results'] as $result) {


        //echo $result["id"] . " ";
        $links = $result["urls"];
        $source = $links['small'];
        $alt = $result["description"];
        array_push($pic_list, array($source, $alt));
        //$pic_list[$i] = $source, $result["alt_description"];
        $i++;
        ///echo "<img src='{$avatar}'> <br>";
    }


    foreach ($pic_list as $link){
        echo '<div class="col-md-4 mb-5">';
        echo '<div class="card h-100">';
        echo "<div class='card-body'>";

        echo "<a href='{$link[0]}'><img class='card-img' src='{$link[0]}' height='200' width='200'></a>";
        echo "</div>";
        echo "<div class='card-body'> <p> {$link[1]}</p> </div>";
        echo "</div>";
        echo "</div>";

    }
    curl_close($ch);

}
function randomPhoto()
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
        //echo '<pre>'; print_r($decoded); echo '</pre>';
    }
    $i = 0;
    $pic_list = array();
    foreach ($decoded as $result) {


        //echo $result["id"] . " ";
        $links = $result["urls"];
        $source = $links['small'];
        $pic_list[$i] = $source;
        //$pic_list[$i] = $source, $result["alt_description"];
        $i++;
        ///echo "<img src='{$avatar}'> <br>";
    }
    $i = 0;
    foreach ($pic_list as $link){
        echo '<div class="col-md-4 mb-5">';
        echo '<div class="card h-100">';
        echo "<div class='card-body'>";

        echo "<a href='{$link}'><img class='card-img' src='{$link}' height='200' width='200'></a>";
        echo "</div>";

        echo "</div>";
        echo "</div>";

    }
    curl_close($ch);

}

function navFunction(){
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=1'>1</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=2'>2</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=3'>3</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=4'>4</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=5'>5</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=6'>6</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=7'>7</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=8'>8</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=9'>9</a></li>";
    echo "<li class='page-item'><a class='page-link' href='index.php?search={$_GET['search']}&page=10'>10</a></li>";
}

?>