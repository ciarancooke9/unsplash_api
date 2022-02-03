<?php

$ch = curl_init();

$url = "https://reqres.in/api/users?page=2";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($err = curl_error($ch)) {
    echo $err;
}
else {
    $decoded = json_decode($response, true);
    echo '<pre>'; print_r($decoded); echo '</pre>';
}
foreach($decoded['data'] as $result) {
    echo($result["first_name"]);
    $avatar = $result["avatar"];
    echo "<img src='{$avatar}'> <br>";
}
curl_close($ch);

?>