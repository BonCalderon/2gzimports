<?php
require_once("/home/bcalderon2/data/connect.php");
require_once("../private/prepared.php")
?>



<?php

$allcars = get_all_cars();
$make = isset($_GET['make']) ? $_GET['make'] : "";
$model = isset($_GET['model']) ? $_GET['model'] : "";
$price = isset($_GET['price']) ? $_GET['price'] : "";
$features = isset($_GET['features']) ? $_GET['features'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";

$min = isset($_GET['min']) ? $_GET['min'] : 0;
$max = isset($_GET['max']) ? $_GET['max'] : 0;
$year = isset($_GET['year']) ? $_GET['year'] : 0;
$msg = "";


$title = "Browse By Price || 2Gz Imports Garage";
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
            <h2 class="display-4">Browsd By Price</h2>
            <p>Click any of the buttons below to browse the titles in our database by the Era or Years in which they were released.</p>
        </div>

    <nav class = "text-center ">
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?price=1&min=0&max=15000" class="btn btn-outline-dark mx-2 mt-3">$0 - $15,000</a>
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?price=2&min=15001&max=30000" class="btn btn-outline-dark mx-2 mt-3">$15,001 - $30,000</a>
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?price=3&min=30001&max=50000" class="btn btn-outline-dark mx-2 mt-3">$30,001 - $50,000</a>
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?price=4&min=50001&max=70000" class="btn btn-outline-dark mx-2 mt-3">$50,001 - $70,000</a>
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?price=5&min=70001&max=100000" class="btn btn-outline-dark mx-2 mt-3">$70,001 - $100,000</a>
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?price=6&min=100001&max=1000000" class="btn btn-outline-dark mx-2 mt-3">$100,001+</a>
    </nav>
    </section>

    <!-- Table of Records -->
    <section>
        <div class="container">
            <?php
            $query = "SELECT id, make, model, year, features FROM jdm_catalogue WHERE 1=1";
            if(isset($_GET['price']) && !empty($_GET['price']))
            {
                $query .= " AND price BETWEEN $min AND $max";
                $msg .= "Price: " . $min . " - " . $max;
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
                else{
                    echo "<h2 class='text-center text-dark'>No Cars in that Price Range, Please upload more!</h2>";
                
                }
            }
                

            ?>
        </div>
        
      
    </section>
</main>

<?php

include('includes/footer.php');

?>