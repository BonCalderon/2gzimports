<?php

    //security: only authenticated users aer allowed here
    // If not authenticated, redirect to login
    session_start();
    if(!isset($_SESSION['username123321']))
    {
        echo "You are not authenticated";
        header("Location: login.php");
    }

//initialize all variables
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




//establish server connection using root of the server
require_once("/home/bcalderon2/data/connect.php");
require_once("../private/prepared.php"); // get access to all functions in prepared.php

?>
<?php 
//the <title> may change, so let's just have a variable
$title = "Administrative Access for Edmonton Attractions";
include("includes/header.php") 
?>
     <section class="about-section text-center" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="text-white mb-4">2Gz Imports Garage Administrative Access</h2>
                        <p class="text-white-50">
                        Where sleek lines meet tunnel visions, and the road becomes a canvas of precision. Unleash the beast within – JDM, where tradition meets triumph!
                        </p>
                    </div>
                    <div class="text-center my-3">
                        <a href="add.php" class="btn btn-outline-light">Add/Upload a Vehicle</a>
                        <a href="delete.php" class="btn btn-outline-light">Delete a Vehicle Record</a>
                        <a href="logout.php" class="btn btn-outline-light">Logout</a>
                    </div>
                </div>
                <div class="col-6">

        </div>
            </div>
      </section>

    <section>
        <h1 class="text-center text-mute">Current JDM Vehicles in Our Catalogue </h1>

        <?php
        //get all attractions from database
        $allcar = get_all_cars();

        if(count($allcar) > 0)
        {
            echo "\n<table class='table table-striped table-hover table-bordered'>";
            echo "\n\t<tr>";
            echo "\n\t<th>Make</th>";
            echo "\n\t<th>Model</th>";
            echo "\n\t<th>Year</th>";
            echo "\n\t<th>Features</th>";
            echo "\n\t<th>Edit</th>";
            echo "\n\t<th>View More</th>";
            echo "\n\t</tr>";
    
            foreach($allcar as $cars)
            {
                //extract the values from database for each cars. display make, model, year, and features
                extract($cars);
                echo "\n\t<tr>";
                echo "\n\t<td>$make</td>";
                echo "\n\t<td>$model</td>";
                echo "\n\t<td>$year</td>";
                echo "\n\t<td>$features</td>";
                echo "\n\t<td><a href='edit.php?id=" . urlencode($id) . "' class='btn btn-outline-dark'>Edit</a></td>";
                echo "\n\t<td><a href='view.php?id=" . urlencode($id) . "' class='btn btn-outline-dark'>View More</a></td>";
                echo "\n\t</tr>";
    
            }
            echo "\n</table>";

        }
        ?>

    </section>


<?php include("includes/footer.php") ?>