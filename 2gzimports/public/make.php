<?php
require_once("/home/bcalderon2/data/connect.php");
require_once("../private/prepared.php")
?>



<?php


$allcars = get_all_cars();
$make = isset($_GET['make']) ? $_GET['make'] : "";
$model = isset($_GET['model']) ? $_GET['model'] : "";
$year = isset($_GET['year']) ? $_GET['year'] : "";
$features = isset($_GET['features']) ? $_GET['features'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";


//make

$make = isset($_GET['make']) ? $_GET['make'] : "";
if(isset($_GET['make']))
{
    $selectedmake = urldecode($_GET['make']);
    $allcars = get_car_by_make($make);
}
else
{
    $allcars = get_all_cars();
}



$title = "Browse by Car Make || 2Gz Imports Garage";
include('includes/header.php');
?>

<main class="container ">
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
                <div class="col-6">

        </div>
            </div>
      </section>


    <section class="row justify-content-between my-5">

        <!-- Introduction -->
        <div class="text-center">
            <h2 class="display-4">Sort by Car Make</h2>
            <p>Click any of the buttons below to browse the Cars in our database by their Make</p>
        </div>

    <nav class = "text-center ">
    <?php
        $make = [//car makes in jdm_catalogue
            "Honda",
            "Toyota",
            "Nissan",
            "Mazda",
            "Subaru",
            "Mitsubishi",
            "Suzuki",
            "Lexus"
            ];
        $msg = "";

        foreach($make as $make)
        {
            echo "<a href='make.php?make=" . urlencode($make) . "' class='btn btn-outline-dark m-2'>" . $make . "</a>";
        }
    ?>
    </nav>
    </section>

    <!-- Table of Records -->
    <section>
        <div class="container">
            <?php
            $query = "SELECT id, make, model, year, features FROM jdm_catalogue WHERE 1=1";
            if(isset($_GET['make']) && !empty($_GET['make']))
            {
                $make = urldecode($_GET['make']);
                $query .= " AND make LIKE '%" . $make . "%'";
                $msg .= "These are the Cars we have that are made of " . $make;
            }
            if($msg){
                echo "<h2 class='text-center text-dark'>{$msg}</h2>";
            }
            //echo the query for testing
            // echo "<div class=\"alert alert-info\"><b>Query:</b><br>". $query ."</div>";

            $result = $connection->query($query);
            if($connection->error){
                echo $connection->error;
            }
            else
            {
                if($result->num_rows > 0)
                {
                    echo "<table class='table table-striped table-hover table-bordered'>";
                    echo "<thead><tr>";
                    echo "<th class='text-dark'>Make</th>";
                    echo "<th class='text-dark'>Model</th>";
                    echo "<th class='text-dark'>Year</th>";
                    echo "<th class='text-dark'>...</th>";
                    echo "</tr></thead>";
                    echo "<tbody>";
                    while($row = $result->fetch_assoc()) 
                    {
                        extract($row);
                        echo "<tr>
                        <td>{$make}</td>
                        <td>{$model}</td>
                        <td>{$year}</td>
                        <td><a href='view.php?id={$id}' class='text-dark'>View</a></td>
                        </tr>";
                    }
                echo "</tbody>";
                echo "</table>";
                }
            }
                

            ?>
        </div>
        
      
    </section>
</main>

<?php

include('includes/footer.php');

?>