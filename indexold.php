<?php

function searchPhoto($query)
{
    $ch = curl_init();

    $url = "https://api.unsplash.com/search/photos?page=1&query='{$query}'&client_id=JfslSx-D_qWAmT2v0GDJoHQCcPNopiXkusPGA6JeXyc";

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
    print_r($pic_list);
    curl_close($ch);
    return $pic_list;
}
?>