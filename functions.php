<?php

function searchPhoto($query, $page = 1)
{
    $ch = curl_init();

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

        echo "<img class='card-img' src='{$link[0]}' height='200' width='200' alt='{$link[0]}'>";
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

        echo "<img class='card-img' src='{$link}' height='200' width='200'>";
        echo "</div>";

        echo "</div>";
        echo "</div>";

    }
    curl_close($ch);

}

function navFunction(){

}
?>