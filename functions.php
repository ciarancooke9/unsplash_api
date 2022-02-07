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

function photoEdit(){
    if (!$_POST) {
        echo "<img class='img-fluid rounded mb-4 mb-lg-0' src='https://support.apple.com/library/content/dam/edam/applecare/images/en_US/social/supportapphero/camera-modes-hero.jpg' alt='...' />";
    } elseif ($_POST) {
        print_r($_POST);
        $width = $_POST['width'];
        $height = $_POST['height'];
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        echo "<h1>$post_image</h1>";
        echo "<h2>Height:$height</h2>". ' ' . "<h2>Width:$width</h2>";

        move_uploaded_file($post_image_temp, "images/$post_image");
        $original = "images/".$_FILES['image']['name'];

        list($oldheight, $oldwidth) = getimagesize($original);

        if (isset($_POST['aspect'])){
            if (!$width == '')
            {
                $factor = (float)$width / (float)$oldwidth;
                $height = $factor * $oldheight;
            }
            else if (!$height == '')
             {
                $factor = (float)$height / (float)$oldheight;
                $width = $factor * $oldwidth;
             }
        }

        $newfile = imagecreatefromjpeg($original);
        $thumb = 'images/blabla' . $_FILES['image']['name'];
        $resized = imagecreatetruecolor($width, $height);
        imagecopyresampled($resized, $newfile, 0, 0, 0, 0, $width, $height, $oldwidth, $oldheight);
        imagejpeg($resized, $thumb, 100);
        unlink($original);
        echo "<img class='img-fluid rounded mb-4 mb-lg-0'  src='$thumb' height='$height' width='$width' />";
        ///unlink($thumb);
    }
}
?>