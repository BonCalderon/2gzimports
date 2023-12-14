<?php
    //establish server connection using root of the server
    require_once("/home/bcalderon2/data/connect.php");

    require_once("../private/prepared.php"); // get access to all functions in prepared.php

    $make = isset($_GET['make']) ? $_GET['make'] : "";
    if(isset($_GET['make'])) 
    {    
        $selectedmake = urldecode($_GET['make']);
    }
    if(isset($_GET['make']))
    {
        $selectedmake = $_GET['make'];
        $cars = get_car_by_make($selectedmake);
    }else
    {
        $selectedmake = 'All';
        $cars = get_all_cars();
    }

    $make = (isset($_POST['make'])) ? $_POST['make'] : "";
    $model = (isset($_POST['model'])) ? $_POST['model'] : "";
    $year = (isset($_POST['year'])) ? $_POST['year'] : "";
    $body_type = (isset($_POST['body_type'])) ? $_POST['body_type'] : "";
    $engine_type = (isset($_POST['engine_type'])) ? $_POST['engine_type'] : "";
    $engine_displacement = (isset($_POST['engine_displacement'])) ? $_POST['engine_displacement'] : "";
    $turbocharge = (isset($_POST['turbocharge'])) ? $_POST['turbocharge'] : "";
    $supercharge = (isset($_POST['supercharge'])) ? $_POST['supercharge'] : "";
    $transmission = (isset($_POST['transmission'])) ? $_POST['transmission'] : "";
    $drivetrain = (isset($_POST['drivetrain'])) ? $_POST['drivetrain'] : "";
    $fuel_type = (isset($_POST['fuel_type'])) ? $_POST['fuel_type'] : "";
    $price = (isset($_POST['price'])) ? $_POST['price'] : "";
    $features = (isset($_POST['features'])) ? $_POST['features'] : "";
    $url = (isset($_POST['url'])) ? $_POST['url'] : "";
    $id = (isset($_POST['id'])) ? $_POST['id'] : "";

?>
<?php

$random_car = random_car();


?>

<?php 
    //the <title> may change, so let's just have a variable
    $title = "2Gz Imports || Home";
    include("includes/header.php") 
?>
        <!-- About-->
        <section class="about-section text-center" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="text-white mb-4">2Gz Imports Garage</h2>
                        <p class="text-white-50">
                        Where sleek lines meet tunnel visions, and the road becomes a canvas of precision. Unleash the beast within – JDM, where tradition meets triumph!
                        </p>
                    </div>
                </div>
            </div>
        </section>
<!-- Projects-->
<section class="projects-section bg-light" id="projects">
            <div class="container px-4 px-lg-5">
                <!-- Featured Vehicl-->
                <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                    <?php
                        if(isset($_GET['random']))
                        {
                            $random_car = random_car();
                        }
                        $filename = $random_car['filename'];
                        //display the details
                        echo "<div class='col-xl-8 col-lg-7'><a href='view.php?id=" . $random_car['id'] . "'><img class='img-fluid mb-3 mb-lg-0 blacknwhite' src='display800/$filename' class='card-img-top' style='height:400px' alt='$filename' /></a></div>";
                        echo "<div class='col-xl-4 col-lg-5'>";
                            echo "<div class='featured-text text-center text-lg-left'>";
                                echo "<h4>Featured JDM</h4>";
                                echo "<p class='text-black-50 mb-0'><b>Make: </b>{$random_car['make']}</p>";
                                echo "<p class='text-black-50 mb-0'><b>Model: </b>{$random_car['model']}</p>";
                                //link to youtube
                                echo "<p class='card-text'><a href='" . $random_car['url'] . "' target='_blank' class='btn btn-outline-black'>Watch Montage!</a></p>";
                            echo "</div>";
                        echo "</div>";
                    ?>
                </div>
                <!--Search-->
                <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
                    <!-- <div class="col-lg-6"><img class="img-fluid" src="assets/img/demo-image-01.jpg" alt="..." /></div> -->
                    <div class="col-lg-6">
                        <div class="bg-black text-center h-100 project">
                            <div class="d-flex h-100">
                                <div class="project-text w-100 my-auto text-center text-lg-left">                                   
                                    <h4 class="text-white text-center mt-4">Search By</h4>
                                    <div class="mt-2 text-center">
                                        <div class="btn-group mb-2">
                                        <button class="btn btn-outline-secondary fw-bold" type="button" onclick="window.location.href='make.php'">
                                            Make
                                        </button>

                                        </div>

                                        <div class="btn-group mb-2">
                                        <button class="btn btn-outline-secondary fw-bold" type="button" onclick="window.location.href='era.php'">
                                            Era
                                        </button>
                                        </div>
                                        
                                        <div class="btn-group mb-2">
                                        <button class="btn btn-outline-secondary fw-bold" type="button" onclick="window.location.href='price.php'">
                                            Price
                                        </button>
 
                                        </div>

                                        <form  action="advsearch.php" method="post" class="mt-2">
                                            <button class="btn btn-outline-secondary">Advance Search</button>
                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    <section>
    <div id="carCarousel" class="carousel slide container mx-auto mt-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $cars = get_all_cars(); // Assuming your array is named $cars
            $totalCars = count($cars);

            if ($totalCars > 0) {
                for ($i = 0; $i < $totalCars; $i += 3) {
                    echo "<div class='carousel-item" . ($i === 0 ? " active" : "") . "'>";
                    echo "<div class='row'>";

                    for ($j = 0; $j < 3 && ($i + $j) < $totalCars; $j++) {
                        $car = $cars[$i + $j];
                        $filename = $car['filename'];

                        echo "<div class='col-md-4 mb-4 d-flex align-items'>";
                        echo "<div class='card text-white bg-dark' style='width: 20rem;'>";
                        echo "<img src='thumbs200/$filename' class='card-img-top py-2 px-2' style='height: 50%' alt='$filename'>";
                        echo "<div class=''>";
                        echo "<h5 class='card-text fw-bold'>{$car['model']}</h5>";
                        echo "<p class='card-text mt-auto'><a href='" . $car['url'] . "' target='_blank' class='btn btn-outline-light'>YouTube</a></p>";
                        echo "<a href='view.php?id={$car['id']}' class='btn btn-outline-light'>View</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }

                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    </section>

 


    <iframe width="1" height="1" src="https://www.youtube.com/embed/pu_b0gP9Ijo?autoplay=1&loop=1" frameborder="0" allowfullscreen allow="autoplay"></iframe>


<?php include("includes/footer.php") ?>