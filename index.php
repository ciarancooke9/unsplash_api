<?php include "functions.php"; ?>
<?php if ($_GET){
    recentSearches($_GET['search']);
} else {
    recentSearches();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Photo Search</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="https://support.apple.com/library/content/dam/edam/applecare/images/en_US/social/supportapphero/camera-modes-hero.jpg" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="#!">Photo Search</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="edit.php">Photo Editing</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Services</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="https://support.apple.com/library/content/dam/edam/applecare/images/en_US/social/supportapphero/camera-modes-hero.jpg" alt="..." /></div>
        <div class="col-lg-5">
            <div class="mb-3">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    <div class="col-auto">
                        <input type="hidden" name="page" value="1" />
                        <label for="inputPassword2" class="visually-hidden">Search</label>
                        <input type="text" class="form-control" name="search" placeholder="Search Photos">
                    </div>
                    <div class="col-auto">
                        <br>
                        <input type="submit" class="btn btn-primary mb-3">
                    </div>

                </form>
                <?php
                if (isset($_COOKIE['recentSearches'])){
                    recentSearchesTable();
                }
                ?>
        </div>
    </div>
    </div>

    <!-- Content Row-->
    <div class="row gx-4 gx-lg-5">
        <?php
        if ($_GET){
            PictureCardGenerator(linkAndDescriptionExtractor(searchPhoto("https://api.unsplash.com/search/photos?page={$_GET['page']}&per_page=9&query='{$_GET['search']}'&client_id=JfslSx-D_qWAmT2v0GDJoHQCcPNopiXkusPGA6JeXyc", $_GET['search'])));
        }
        else {
            $page = rand(1,100);
            PictureCardGenerator(linkAndDescriptionExtractor(searchPhoto("https://api.unsplash.com/photos?page={$page}&per_page=9&client_id=JfslSx-D_qWAmT2v0GDJoHQCcPNopiXkusPGA6JeXyc")));
        }
        ?>
</div>
<div class="row gx-4 gx-lg-5">
    <div class="col-lg-4"></div>
    <div class="col-lg-5">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
        <?php
            if ($_GET) {
                navbarFunction();
            }
        ?>
        </ul>
    </nav>
    </div>
    <div class="col-lg-3"></div>
</div>
<!-- Footer-->
<footer class="py-5 bg-dark">

    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>