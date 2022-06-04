<?php
//this function saves recent searches to a cookie
function recentSearches($recentSearch='') {
    if (strlen($recentSearch) > 31){
        return;
    }
    // if the cookie exists, read it and unserialize it. If not, create a blank array
    if ($recentSearch != '') {
        ///if array exsits read it and add $recentSearch value, Else create a new array
        if (array_key_exists('recentSearches', $_COOKIE)) {
            $cookie = unserialize($_COOKIE['recentSearches']);
            }
        else {
            $cookie = array();
            }

    $cookie[] = $recentSearch;

    // save the cookie
    setcookie('recentSearches', serialize($cookie), time() + 3600);
}
}

//function to edit recent searches to 3 most recent unique searched
//takes serialized cookie array as parameter and outputs edited array
function searchArrayEditor($serializedArray, $returnArrayLength=3){
    $editedArray = unserialize($serializedArray, ["allowed_classes" => false]);

    //reverse array so most recent searches are first & remove duplicates, limited to 3 by default
    $editedArray = array_reverse($editedArray);
    $editedArray = array_unique($editedArray);
    $editedArray = array_slice($editedArray, 0, $returnArrayLength);

    return $editedArray;
}

// this function takes the array from the recent searches cookie and converts it into an array
function recentSearchesTable(){

    $searchesArray = searchArrayEditor($_COOKIE['recentSearches']);

    echo "<h2>Your recent searches:</h2><br>";
    echo "<ul class='list-group'>";
    //output searches as list, limited to last 3 searches
    foreach ($searchesArray as $searchTerm) {
    echo "<li class='list-group-item'><button type='button' class='btn btn-link'><a href='index.php?search={$searchTerm}&page=1'>$searchTerm</a></button></li>";
    }
    echo "</ul>";
}

function cleanSearchInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return urlencode($data);
}

function validateQuery($query, $maxLength = 30){
    if ($query == ""){
        return ['message' => 'Please enter a search term.', 'query_valid' => false];
    } elseif (strlen($query) >= $maxLength) {
        return ['message' => 'Max search length is 30 characters', 'query_valid' => false];
    } else {
        return ['message' => "You searched for: '{$query}'", 'query_valid' => true];
    }
}

//this function takes a url, sends a get request to this url and retrieves a json response
function curlGetRequest($url){
    //curl session open
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch); ///response array
    curl_close($ch);
    // curl session close

    //check response status & output accordingly
    if ($err = curl_error($ch)){
        return ['request_success' => false, 'response' => $err];
    }
    return ['request_success' => true, 'response' => $response];
}


//this function accepts a search term and a URL
// and returns a decoded json response from unsplash
function searchPhoto($url = '', $query = '')
{
    //validate the query
    if ($_GET){
        $validation = validateQuery($query);
        echo "<h1>{$validation['message']}</h1>";
        if (!$validation['query_valid']) {
            return [];
        }
    }

    //if not GET request use random picture Url

    $response = curlGetRequest($url); //returns json response from url

    if (!$response['request_success']){ ///checks url response
        return $response['response'];
    }

    $decoded = json_decode($response['response'], true);

    return $_GET ? $decoded['results']: $decoded; //if GET(search) return results portion of array, else return full array
}

//this function extracts links and descriptions from the unsplash api response
function linkAndDescriptionExtractor($array){
    //Extract links and image descriptions from JSON response and put them into an array, which is then outputted
    $i = 0;
    $picList = array();
    foreach ($array as $result) {
        $links = $result["urls"];
        $source = $links['small'];
        $alt = $result["description"];
        array_push($picList, array($source, $alt));
        $i++;
    }
    return $picList;
}

//function to generate the picture cards and image descriptions, accepts an array as a parameter
function PictureCardGenerator($picList){
    foreach ($picList as $link){
        echo '<div class="col-md-4 mb-5">';
        echo '<div class="card h-100">';
        echo "<div class='card-body'>";

        echo "<a href='{$link[0]}'><img class='card-img' src='{$link[0]}' height='200' width='200'></a>";
        echo "</div>";
        if ($_GET){
            echo "<div class='card-body'> <p> {$link[1]}</p> </div>";
        }
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
