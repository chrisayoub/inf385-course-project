<!doctype html>
<html lang="en">

<head>
  <title>Call Me by Your Name</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/aos.css">

  <!-- MAIN CSS -->
  <link rel="stylesheet" href="css/style.css">

</head>

<!-- Custom PHP functions -->
<?php

// DB credentials
include 'db.php';

// Get states from database, mapping ID to long name
function getStates() {
    global $db;
    $result = [];

    $state_query = "SELECT * FROM states";
    $states = mysqli_query($db, $state_query);
    while ($row = mysqli_fetch_array($states)) {
        $id = $row['id'];
        $name = $row['fullName'];
        $result[$id] = $name;
    }
    return $result;
}

// Take a map and print the option list
function mapToOptionList($map) {
    foreach ($map as $id => $value) {
        print("<option value='$id'>$value</option>");
    }
}
?>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">


  <div class="site-wrap" id="home-section">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar site-navbar-target" role="banner">

      <div class="container">
        <div class="row align-items-center position-relative">

          <div class="col-3 ">
            <div class="site-logo">
                Call Me
                <br>by Your Name
            </div>
          </div>

          <div class="col-9  text-right">


            <span class="d-inline-block d-lg-none">
              <a href="#" class="text-white site-menu-toggle js-menu-toggle py-5 text-white">
                <span class="icon-menu h3 text-white"></span>
              </a>
            </span>

            <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation" id="site-menu">
              <ul class="site-menu main-menu js-clone-nav ml-auto ">
                <li class="active">
                  <a href="index.php" class="nav-link">Home</a>
                </li>
                <li>
                  <a href="index.php#search" class="nav-link">Search</a>
                </li>
                <li>
                  <a href="index.php#collections" class="nav-link">Collections</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>

    </header>

    <div class="ftco-blocks-cover-1">
      <div class="site-section-cover overlay" data-stellar-background-ratio="0.5" style="background-image: url('images/maxresdefault.jpg')">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-7">
              <span class="h4">A collection of over 31595 unique names</span>
              <h1 class="mb-2">Find the one!</h1>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <a id="search"></a> -->
    <div class="search-filter" id="">
      <div class="container">
        <div class="search-filter-wrap nav">
          <a href="#search" class="active" data-toggle="tab" id="search-tab" aria-controls="search" aria-selected="true">Search a Name</a>
          <a href="#random" class="" data-toggle="tab" id="random-tab" aria-controls="random" aria-selected="false">Random Generator</a>
        </div>
      </div>
    </div>

    <div class="search-tabpane pb-5">
        <div class="container tab-content">
          <div class="tab-pane active" id="search" role="tabpanel">

            <form action="search.php" method="post" id="search_form">

            <div class="row">
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="name" placeholder="Name *">
              </div>
              <div class="col-md-4 form-group">
                <select name="gender" class="form-control w-100">
                  <option value="all">All Genders</option>
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <select name="state" id="" class="form-control w-100">
                  <option value="all">All States</option>
                  <?php
                    mapToOptionList(getStates());
                  ?>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <input type="text" class="form-control" name="year" placeholder="4-Digit Year of Birth">
              </div>

              <div class="col-md-4 form-group" style="font-size: 24px; color: #333;">
                <p>* = required</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <input type="submit" class="btn btn-black py-3 btn-block" value="Submit">
              </div>
            </div>
            </form>
          </div>
      
          <div class="tab-pane" id="random" role="tabpanel" aria-labelledby="random-tab">

            <form action="random.php" method="post" id="random_form">

            <div class="row">
                <div class="col-md-4 form-group" style="color: #333;">
                    <p>Number of names</p>
                </div>
                <div class="col-md-4 form-group" style="color: #333;">
                    <p>Gender of names</p>
                </div>
            </div>

            <div class="row">
              <div class="col-md-4 form-group">
                <select name="number" id="" class="form-control w-100">
                   <option value="1">1</option>
                  <option value="5">5</option>
                  <option value="10">10</option>
                  <option value="15">15</option>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <select name="gender" id="" class="form-control w-100">
                  <option value="all">All Genders</option>
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </select>
              </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                  <input type="submit" class="btn btn-black py-3 btn-block" value="Submit">
                </div>
            </div>
            </form>
          </div>
        </div>
    </div>

    <div class="site-section bg-light" id="collection">
      <a id="collections"></a>
      <div class="container">

        <div class="row justify-content-center mb-5">
          <div class="col-md-6 text-center">
            <h3 class="heading-29201 text-center">Name Collections</h3>

            <p class="mb-5">Fun Facts About Names</p>
          </div>
        </div>

        <div class="row">

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="post-entry-1 h-100">
              <a href="boys.php">
                <img src="images/boys.png" alt="Image" class="img-fluid">
              </a>
              <div class="post-entry-1-contents">

                <h2>
                  <a href="boys.php">Trending Boy Names</a>
                </h2>
                <p>View the top trending boy names from the past two decades.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="post-entry-1 h-100">
              <a href="girls.php">
                <img src="images/girls.jpeg" alt="Image" class="img-fluid">
              </a>
              <div class="post-entry-1-contents">

                <h2>
                  <a href="girls.php">Trending Girl Names</a>
                </h2>
                <p>View the top trending girl names from the past two decades.</p>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 mb-4">
            <div class="post-entry-1 h-100">
              <a href="unique.php">
                <img src="images/unique.jpg" style="height:190px; width:330px" alt="Image" class="img-fluid">
              </a>
              <div class="post-entry-1-contents">
                <h2>
                  <a href="unique.php">The Most Unique Names</a>
                </h2>
                <p>Tired of having the same with others? Check out the most unique names here!</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <footer class="site-footer ">
      <div class="container ">
        <div class="row ">
          <div class="col-md-4 ">
            <h3 class="text-white h5 mb-3 ">About</h3>
            <p>Call Me by Your Name, Group Air, INF385M</p>
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center ">
          <div class="col-md-12 ">
            <div class="border-top pt-5 ">
              <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;
                <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with
                <i class="icon-heart text-danger " aria-hidden="true "></i> by
                <a href="https://colorlib.com " target="_blank ">Colorlib</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </p>
            </div>
          </div>

        </div>
      </div>
    </footer>

  </div>

  <script src="js/jquery-3.3.1.min.js "></script>
  <script src="js/jquery-migrate-3.0.0.js "></script>
  <script src="js/popper.min.js "></script>
  <script src="js/bootstrap.min.js "></script>
  <script src="js/owl.carousel.min.js "></script>
  <script src="js/jquery.sticky.js "></script>
  <script src="js/jquery.waypoints.min.js "></script>
  <script src="js/jquery.animateNumber.min.js "></script>
  <script src="js/jquery.fancybox.min.js "></script>
  <script src="js/jquery.stellar.min.js "></script>
  <script src="js/jquery.easing.1.3.js "></script>
  <script src="js/bootstrap-datepicker.min.js "></script>
  <script src="js/aos.js "></script>

  <script src="js/main.js "></script>

</body>

</html>