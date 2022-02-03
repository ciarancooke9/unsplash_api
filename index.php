<?php

$ch = curl_init();

$url = "https://api.unsplash.com/search/photos?query=office&client_id=JfslSx-D_qWAmT2v0GDJoHQCcPNopiXkusPGA6JeXyc";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($err = curl_error($ch)) {
    echo $err;
}
else {
    $decoded = json_decode($response, true);
    //echo '<pre>'; print_r($decoded); echo '</pre>';
}
foreach($decoded['results'] as $result) {
    echo $result["id"] . " ";
    $links = $result["urls"];
    $source = $links['small'];
    echo "<img src='$source'>";
    ///echo "<img src='{$avatar}'> <br>";
}
curl_close($ch);

?>