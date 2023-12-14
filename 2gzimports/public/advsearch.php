<?php
require_once("/home/bcalderon2/data/connect.php");
?>

<?php


$make = isset($_GET['genre']) ? $_GET['genre'] : array("");
$model = isset($_GET['car-search']) ? $_GET['car-search'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : array("");




$min = isset($_GET['year-min']) ? $_GET['year-min'] : 1968;
$max = isset($_GET['year-max']) ? $_GET['year-max'] : 2022;





$page_title = "Advanced Search: 2Gz Garage";
include('includes/header.php');
?>


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
        <section class="signup-section" id="signup">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5">
                    <div class="col-md-10 col-lg-8 mx-auto text-center">
                        <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "get" class ="mb-3 border border-sucess p-3 rounded text-white">
                            <div class="col col-md-10 col-xl-8">
                            <h2 class="display-5 mb-3">Advanced Search</h2>
                            </div>
                            <!--Model Search-->
                                <fieldset  class = "mb-3">
                                    <legend class="fs-5">Search</legend><br>
                                    <div>
                                        <input type="text" class="form-control" name="car-search" 
                                        value="<?php echo isset($_GET['car-search']) ? htmlspecialchars($_GET['car-search']) : '';?>">
                                    </div>
                                </fieldset>
                            <!--Make , result differs depending on Search inputs-->
                                <fieldset>
                                    <legend class="fs-5">Search By Make</legend>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="make[]" id="honda" value="Honda" <?php if (isset($_GET['make']) && in_array("Honda", $_GET['make'])) echo 'checked'; ?>>
                                                <label for="honda" class="form-check-label">Honda</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="make[]" id="toyota" value="Toyota" <?php if (isset($_GET['make']) && in_array("Toyota", $_GET['make'])) echo 'checked'; ?>>
                                                <label for="toyota" class="form-check-label">Toyota</label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="make[]" id="nissan" value="Nissan" <?php if (isset($_GET['make']) && in_array("Nissan", $_GET['make'])) echo 'checked'; ?>>
                                                <label for="nissan" class="form-check-label">Nissan</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="checkbox" class="form-check-input" name="make[]" id="mazda" value="Mazda" <?php if (isset($_GET['make']) && in_array("Mazda", $_GET['make'])) echo 'checked'; ?>>
                                            <label for="mazda" class="form-check-label">Mazda</label>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="checkbox" class="form-check-input" name="make[]" id="mitsubishi" value="Mitsubishi" <?php if (isset($_GET['make']) && in_array("Mitsubishi", $_GET['make'])) echo 'checked'; ?>>
                                            <label for="mitsubishi" class="form-check-label">Mitsubishi</label>
                                        </div class="col-md-4">

                                        <div class="col-md-4">
                                            <input type="checkbox" class="form-check-input" name="make[]" id="subaru" value="Subaru" <?php if (isset($_GET['make']) && in_array("Subaru", $_GET['make'])) echo 'checked'; ?>>
                                            <label for="subaru" class="form-check-label">Subaru</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="checkbox" class="form-check-input" name="make[]" id="lexus" value="Lexus" <?php if (isset($_GET['make']) && in_array("Lexus", $_GET['make'])) echo 'checked'; ?>>
                                            <label for="lexus" class="form-check-label">Lexus</label>
                                        </div>
                                    </div>


                                </fieldset>

                            <!-- Release Year -->
                                <fieldset class="my-5">
                                        <legend class="fs-5">Year</legend>

                                        <div class="mb-3">
                                            <label for="year-min" class="form-label">From Year: </label>
                                            <input type="number" class="form-control" id="year-min" name="year-min"
                                                min="1949" max="2024" value="<?php echo ($min != "") ? $min : 1949; ?>">

                                            <label for="year-max" class="form-label">To Year: </label>
                                            <input type="number" class="form-control" id="year-max" name="year-max"
                                                min="1949" max="2024" value="<?php echo ($max != "") ? $max : 2024; ?>">
                                        </div>
                                </fieldset>
                            <!-- Sort Order Ascending(A-Z, 0-9) Descending(Z-A, 9-0) radio buttons -->
                                <fieldset class="mb-3">
                                    <legend class="fs-5">Sort Order</legend>
                                    <div class="mb-3">
                                        <input type="radio" class="form-check-input" name="sort" id="sort-asc" value="asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'asc') ? 'checked' : ''; ?>>
                                        <label for="sort-asc" class="form-check-label">Ascending</label>
                                    </div>

                                    <div class="mb-3">
                                        <input type="radio" class="form-check-input" name="sort" id="sort-desc" value="desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'desc') ? 'checked' : ''; ?>>
                                        <label for="sort-desc" class="form-check-label">Descending</label>
                                    </div>


                                </fieldset>

                            <div class="mb-3">
                                <input type="submit" id="submit" name="submit" class="btn btn-outline-light" value="Search">
                            </div>
                        </form>
                        <!-- Results -->
                        <?php
                            //prepare statement
                            $query = "SELECT * FROM jdm_catalogue WHERE 1=1";

                            if(isset($_GET['submit']))
                            {
                                
                                
                                //filter with title
                                if(isset($_GET['car-search']) && !empty($_GET['car-search']))
                                {
                                    $car_search = $connection->real_escape_string($_GET['car-search']);
                                    $query .= " AND (make LIKE '%" . $car_search . "%' OR model LIKE '%" . $car_search . "%' OR body_type LIKE '%" . $car_search . "%' OR engine_type LIKE '%" . $car_search . "%' OR driving_style LIKE '%" . $car_search . "%' OR engine_displacement LIKE '%" . $car_search . "%' OR turbocharge LIKE '%" . $car_search . "%' OR supercharge LIKE '%" . $car_search . "%' OR transmission LIKE '%" . $car_search . "%' OR drivetrain LIKE '%" . $car_search . "%' OR fuel_type LIKE '%" . $car_search . "%' OR price LIKE '%" . $car_search . "%' OR features LIKE '%" . $car_search . "%' OR url LIKE '%" . $car_search . "%')";

                                }


                                //filter with make
                                if(isset($_GET['make']) && !empty($_GET['make']))
                                {
                                    $make = array_map([$connection, 'real_escape_string'], $_GET['make']);
                                    $makestring = implode("','", $make);
                                    $query .= " AND make LIKE '%" . $makestring . "%'";
                                    
                                }

                                //filter with year of release
                                if($min != "" && $max != "")
                                {
                                    $query .= " AND year BETWEEN " . $min . " AND " . $max;
                                }

                                //Sort Order Ascending A-Z then by 0-9
                                if(isset($_GET['sort']) && $_GET['sort'] == "asc")
                                {
                                    $query .= " ORDER BY model ASC";
                                }

                                //Sort Order Descending(Z-A, 9-0)
                                if(isset($_GET['sort']) && $_GET['sort'] == "desc")
                                {
                                    $query .= " ORDER BY model DESC";
                                }




                                //print result of submit search
                                //echo "<div class=\"alert alert-info\"><b>Query:</b><br>". $query ."</div>";
                                $result = $connection->query($query);
                                if($connection->error){
                                    echo $connection->error;
                                }
                                else
                                {
                                    if($result->num_rows > 0)
                                        {
                                            echo "<div class='bg bg-white'>";
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
                                        echo "</div>";
                                        }
                                        else{
                                            echo "<h2 class='text-center text-white'>No Cars Found from your Search!</h2>";
                                        }
                                }
                            }

                        ?>
                    </div>
                </div>
            </div>
        </section>
        



<?php

include('includes/footer.php');

?>