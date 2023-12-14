<?php
require_once("/home/bcalderon2/data/connect.php");

require_once("../private/prepared.php"); 


$title = "Search Results: 2Gz Imports Garage";
?>
<?php include('includes/header.php'); ?>

<main class="container">
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
    <section class="row justify-content-center mb-5">
        <div class="col col-md-10 col-xl-8">

        </div>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['partial-search']))
            {
                
                $partialSearch = sanitize_input($_POST['partial-search']);
                $query = "SELECT * FROM jdm_catalogue WHERE make LIKE '%$partialSearch%' OR model LIKE '%$partialSearch%' OR year LIKE '%$partialSearch%' OR body_type LIKE '%$partialSearch%' OR engine_type LIKE '%$partialSearch%' OR driving_style LIKE '%$partialSearch%' OR engine_displacement LIKE '%$partialSearch%' OR transmission LIKE '%$partialSearch%' OR drivetrain LIKE '%$partialSearch%' OR fuel_type LIKE '%$partialSearch%'  OR features LIKE '%$partialSearch%' OR url LIKE '%$partialSearch%' OR filename LIKE '%$partialSearch%'";

                $result = $connection->query($query);
                if($result === false){
                    die ("Error: " . $connection->error);
                }
               
                if($result->num_rows > 0)
                {
                    echo "<h2 class='display-5 mb-3'>Search Results for:<?php echo $partialSearch?></h2>";
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
                        <td>$make</td>
                        <td>$model</td>
                        <td>$year</td>
                        <td class='text-center'>
                        <a href='view.php?id=$id' class='btn btn-outline-dark'>View More</a>
                        </td>
                        </tr>";
                    }
                echo "</tbody>";
                echo "</table>";
                }
                



            }
            
            
            
            
            
            
            
            ?>
        
</main>



<?php include('includes/footer.php'); ?>
