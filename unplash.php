<?php
if ($_POST){
    $search = $_POST['search'];
    $list = searchPhoto($search);


    $i = 0;
    foreach ($list as $link){
        echo '<div class="col-md-4 mb-5">';
        echo '<div class="card h-100">';
        echo "<div class='card-body'>";
        echo "<h2 class='card-title'>Card One</h2>";
        echo "<img class='card-img' src='{$link}' height='200' width='200'>";
        echo "</div>";
        echo "<div class='card-footer'><a class='btn btn-primary btn-sm' href='#!'>More Info</a></div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
?>