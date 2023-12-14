<?php

    //security: only authenticated users aer allowed here
    // If not authenticated, redirect to login
    session_start();
    if(!isset($_SESSION['username123321']))
    {
        echo "You are not authenticated";
        header("Location: login.php");
    }
//establish server connection using root of the server
require_once("/home/bcalderon2/data/connect.php");

require_once("../private/prepared.php"); // get access to all functions in prepared.php



//initialize variables
$make = (isset($_POST['make'])) ? $_POST['make'] : "";
$model = (isset($_POST['model'])) ? $_POST['model'] : "";
$year = (isset($_POST['year'])) ? $_POST['year'] : null;
$body_type = (isset($_POST['body_type'])) ? $_POST['body_type'] : "";
$engine_type = (isset($_POST['engine_type'])) ? $_POST['engine_type'] : "";
$driving_style = (isset($_POST['driving_style'])) ? $_POST['driving_style'] : "";
$engine_displacement = (isset($_POST['engine_displacement'])) ? $_POST['engine_displacement'] : "";
$turbo_charge = (isset($_POST['turbocharge'])) ? trim($_POST['turbocharge']) : "";
$super_charge = (isset($_POST['supercharge'])) ? trim($_POST['supercharge']) : "";
$transmission = (isset($_POST['transmission'])) ? $_POST['transmission'] : "";
$drivetrain = (isset($_POST['drivetrain'])) ? $_POST['drivetrain'] : "";
$fuel_type = (isset($_POST['fuel_type'])) ? $_POST['fuel_type'] : "";
$price = (isset($_POST['price'])) ? $_POST['price'] : "";
$features = (isset($_POST['features'])) ? $_POST['features'] : "";
$url = (isset($_POST['url'])) ? $_POST['url'] : "";
$filename = (isset($_POST['filename'])) ? $_POST['filename'] : "";


$thisfolder = "uploadedfiles/"; //folder name
$valid = 1; //default value
$msg = ""; //default value  


if(isset($_POST['addsubmit']))
{
    $message = "";

    extract($_POST);

    $do_i_proceed = true;


    //validation for attraction name if null or string lenght too much
    $model = filter_var($model, FILTER_SANITIZE_STRING);
    if(!filter_var($model, FILTER_SANITIZE_STRING))
    {
        $do_i_proceed = false;
        $message .= "<p>Car model cannot be Empty</p>";
    }elseif(strlen($model) < 2 || strlen($model) > 50 )
    {

        $do_i_proceed = false;
        $message .= "<p>Car model must be between 2 to 50 characters</p>";
    }


    //validation for make
    $make = filter_var($make, FILTER_SANITIZE_STRING);

    //validation for year
    $year = filter_var($year, FILTER_SANITIZE_NUMBER_INT);
    if($year < 1900 || $year > 2025)
    {
        $do_i_proceed = false;
        $message .= "<p>Collection only have years between 1975 to Present</p>";
    }else if(!filter_var($year, FILTER_VALIDATE_INT))
    {
        $do_i_proceed = false;
        $message .= "<p>Year must be a valid number</p>";
    }else if(!is_numeric($year))
    {
        $do_i_proceed = false;
        $message .= "<p>Year must be a valid number</p>";
    }

    //validation for body type
    if (empty($_POST['body_type']) || $_POST['body_type'] == "") {
        $do_i_proceed = FALSE;
        $message .= "<p>Please select a Body Type.</p>";
    } else {
        $category = $_POST['body_type'];
    }

    //validation for engine type
    $engine_type = filter_var($engine_type, FILTER_SANITIZE_STRING);
    if(strlen($engine_type) < 2 || strlen($engine_type) > 50)
    {
        $do_i_proceed = false;
        $message .= "<p>Engine Type must be between 2 to 50 characters</p>";
    }

    //validation for engine displacement
    $engine_displacement = filter_var($engine_displacement, FILTER_SANITIZE_NUMBER_FLOAT);
    if($engine_displacement <= 0)
    {
        $do_i_proceed = false;
        $message .= "<p>Engine Displacement Cannot be a negative value</p>";
    }else if(!filter_var($engine_displacement, FILTER_VALIDATE_FLOAT))
    {
        $do_i_proceed = false;
        $message .= "<p>Engine Displacement must be a valid number</p>";
    }else if(!is_numeric($engine_displacement))
    {
        $do_i_proceed = false;
        $message .= "<p>Engine Displacement must be a valid number</p>";
    }

    //validation for turbo charge
    
    $turbo_charge = 0;
    if(isset($_POST['turbocharge'])){
        $turbo_charge = 1;
    }

    //validation for super charge
    $super_charge = 0;
    if(isset($_POST['supercharge'])){
        $super_charge = 1;
    }


    //validation for transmission
    $transmission = filter_var($transmission, FILTER_SANITIZE_STRING);
    if(strlen($transmission) < 2 || strlen($transmission) > 50)
    {
        $do_i_proceed = false;
        $message .= "<p>Transmission must be between 2 to 50 characters</p>";
    }

    //validation for drive train must be selected from the drop down list
    $drivetrain = filter_var($drivetrain, FILTER_SANITIZE_STRING);
    



    //validation for fuel type
    $fuel_type = filter_var($fuel_type, FILTER_SANITIZE_STRING);

   

    //validation for youtube url
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = filter_var($url, FILTER_VALIDATE_URL);
    if($url == false)
    {
        $do_i_proceed = false;
        $message .= "<p>URL must be a valid URL</p>";
    }

   //validation for cost
    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT);
    if($price <= 0)
    {
        $do_i_proceed = false;
        $message .= "<p>Price Cannot be a negative value</p>";
    }else if(!filter_var($price, FILTER_VALIDATE_FLOAT))
    {
        $do_i_proceed = false;
        $message .= "<p>Price must be a valid number</p>";
    }else if(!is_numeric($price))
    {
        $do_i_proceed = false;
        $message .= "<p>Price must be a valid number</p>";
    }


    //validation for image file type must be jpg or png
    $fileType = $_FILES['myfile']['type'];
    if($fileType != "image/jpeg" && $fileType != "image/png"){
        $valid = 0;
        $msg .= "<p>File must be a JPG or PNG</p>";
    }


    echo "<p><b>File Size:</b> " . $_FILES['myfile']['size'] . "</p>";

    if($_FILES['myfile']['size'] > (5 * 1024 * 1024)){ // 5 MB
        $valid = 0;
        $msg .= "<p>File must be less than 5 MB</p>";
    }

    // validation for image
 
    // if ($valid == 1) 
    // {

    //     $uploadedFilePath = "uploadedfiles/" . $_FILES['myfile']['name'];

    //     if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadedFilePath)) {

    //         // make thumbnail copies at 200 px wide
    //         $thisFile = $uploadedFilePath;
    //         $thisFolder = "thumbs200/";
    //         $thisWidth = 200;
    //         createSquareImageCopy($thisFile, $thisFolder, $thisWidth);

    //         // make display copies at 800 px wide
    //         $thisFolder = "display800/";
    //         $thisWidth = 800;
    //         createImageCopy($thisFile, $thisFolder, $thisWidth, 0);

    //         $filename = $_FILES['myfile']['name'];
    
    //         echo "<h3 class='alert alert-success'>Upload Successful</h3>";
    //     } else {
    //         echo "<h3 class='alert alert-danger'>" . $_FILES['myfile']['error'] . "</h3>";
    //     }

    // } 
    //     else 
    //     {
    //         echo "<h3 class='alert alert-danger'>$message</h3>";
    //     }

    //         //submit and add if form is good
    //         if($do_i_proceed == TRUE)
    //         {
    //             //insert method problem
    //             insert_car($make, $model, $year, $body_type, $engine_type, $driving_style, $engine_displacement, $turbocharge, $supercharge, $transmission, $drivetrain, $fuel_type, $price, $features, $url, $filename);
    //             $message .= "<p>Car successfully added in Collection!</p>";
    //             header("Location: admin.php");
    //         }
    //         else
    //         {
    //             $message .= "<p class='alert alert-danger'>Attraction was not added successfully</p>" . $connection->error . "</p>";
            
    //         }

        
            if ($valid == 1) {
                // Generate a unique filename
                $uniqueFilename = uniqid() . "_" . $_FILES['myfile']['name'];
                $uploadedFilePath = "uploadedfiles/" . $uniqueFilename;
            
                if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadedFilePath)) {
            
                    // make thumbnail copies at 200 px wide
                    $thisFile = $uploadedFilePath;
                    $thisFolder = "thumbs200/";
                    $thisWidth = 200;
                    createSquareImageCopy($thisFile, $thisFolder, $thisWidth);
            
                    // make display copies at 800 px wide
                    $thisFolder = "display800/";
                    $thisWidth = 800;
                    createImageCopy($thisFile, $thisFolder, $thisWidth, 0);
            
                    $filename = $uniqueFilename;
            
                    echo "<h3 class='alert alert-success'>Upload Successful</h3>";
                } else {
                    echo "<h3 class='alert alert-danger'>" . $_FILES['myfile']['error'] . "</h3>";
                }
            } else {
                echo "<h3 class='alert alert-danger'>$message</h3>";
            }
            
            //submit and add if form is good
            if ($do_i_proceed == TRUE) {
                //insert method problem
                insert_car($make, $model, $year, $body_type, $engine_type, $driving_style, $engine_displacement, $turbocharge, $supercharge, $transmission, $drivetrain, $fuel_type, $price, $features, $url, $filename);
                $message .= "<p>Car successfully added in Collection!</p>";
                header("Location: admin.php");
            } else {
                $message .= "<p class='alert alert-danger'>Attraction was not added successfully</p>" . $connection->error . "</p>";
            }
            

}

?>
<?php 
//the <title> may change, so let's just have a variable
$title = "Add an Attraction || Administrative Access for Edmonton Attractions";
include("includes/header.php") 
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
                <div>
                    <a href="admin.php" class="btn btn-outline-light">Back to Admin Page</a>
                </div>
            </div>
        </section>

    <section class="container">
        <div class="card mx-auto my-5" style="width: 50%;">
            <div class="card-body shadow p-3 bg-body rounded">
                <h1 class=" mb-3">Add/Upload a Vehicle into our Collection</h1>
                <p class="lead text-muted">Fill out the form below to Add a Car into our collection.</p>
                <form class="text-start" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype = "multipart/form-data">
                        <?php if(isset($message)):?>
                            <div class="message text-danger">
                                <?php echo $message;?>
                            </div>
                        <?php endif;?>
                    <!--select drop down for make-->
                    <div class="mb-3">
                        <label for="make" class="form-label">Make: </label>
                        <select class="form-select" id="make" name="make">
                            <?php
                            $make = array(
                                "0" => "Honda",
                                "1" => "Nissan",
                                "2" => "Toyota",
                                "3" => "Subaru",
                                "4" => "Mazda",
                                "5" => "Mitsubishi",
                                "6" => "Suzuki",
                                "7" => "Lexus",
                            );
                            foreach($make as $key => $value) {
                                $selected = isset($_POST['make']) && $_POST['make'] == $key ? " selected" : " ";
                                echo "<option value =\"$value\"";
                                if(isset($_POST['make']) && $_POST['make'] == $key) echo " selected";
                                echo ">$value</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!--Model input-->
                    <div class="mb-3">
                        <label for="model" class="form-label">Model: </label>
                        <input type="text" class="form-control" id="model" name="model" value="<?php if(isset($_POST['model'])) echo $_POST['model'];?>">
                    </div>
                    <!--Year input-->
                    <div class="mb-3">
                        <label for="year" class="form-label">Year: </label>
                        <input type="number" class="form-control" id="year" name="year" min="1900" max="2021" value="<?php if(isset($_POST['year'])) echo $_POST['year'];?>">
                    </div>
                    <!--body_type input select drop down-->
                    <div class="mb-3">
                        <label for="body_type" class="form-label">Body Type: </label>
                        <select name="body_type" id="body_type" class="form-select form-select-md">
                            <option value="">Select Body Type</option>
                            <?php
                            $body_type = [
                                "Hatchback",
                                "Coupe",
                                "Sedan",
                                "Convertible",
                                "SUV",
                                "Wagon",
                                "Van",
                                "Other"
                            ];
                            foreach($body_type as $bdytype){
                                echo "<option value=\"$bdytype\"";
                                if(isset($_POST['body_type']) && $_POST['body_type'] == $bdytype){
                                    echo "selected";
                                }
                                echo ">$bdytype</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!--engine_type input select dropdown-->
                    <div class="mb-3">
                        <label for="engine_type" class="form-label">Engine Type: </label>
                        <select class="form-select" id="engine_type" name="engine_type">
                        <option value="">Select Engine Type</option>
                            <?php
                            $engine_type = [
                                "Inline4",
                                "Inline6",
                                "V6",
                                "V8",
                                "V10",
                                "V12",
                                "W12",
                                "Rotary",
                                "Other"
                            ];
                            foreach($engine_type as $engtype){
                                echo "<option value=\"$engtype\"";
                                if(isset($_POST['engine_type']) && $_POST['engine_type'] == $engtype){
                                    echo "selected";
                                }
                                echo ">$engtype</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!--driving_style-->
                    <div class="mb-3">
                        <label class="form-check-label" for="cost">Driving Style:</label>
                        <?php
                        $driving_style = ['RHD', 'LHD'];
                        foreach($driving_style as $key => $value){
                            $selected = isset($_POST['driving_style']) && $_POST ['driving_style'] == $value ? 'checked' : '';
                            echo "<div class=\"form-check\">
                            <input class=\"form-check-input\" type=\"radio\" name=\"driving_style\" id=\"driving_style$key\" value=\"$value\" $selected>
                            <label class=\"form-check-label\" for=\"cost$key\">$value</label>
                          </div>";
                        }?>
                    </div>
                    <!--engine_displacement-->
                    <div class="mb-3">
                        <label for="engine_displacement" class="form-label">Engine Displacement: </label>
                        <input type="text" class="form-control" id="engine_displacement" name="engine_displacement" value="<?php if(isset($_POST['engine_displacement'])) echo $_POST['engine_displacement'];?>">
                    </div>
                    <!--turbo charge (checkbox boolean)-->
                    <div class="mb-3">
                        <label for="turbo_charge" class="form-label">Turbo Charge:</label>
                        <input type="checkbox" class="form-check-input mx-2" id="turbo_charge" name="turbo_charge"  value="<?php if(isset($_POST ['turbo_charge'])) echo $_POST['turbo_charge'];?>">
                    </div>
                
                    <!--super charge (checkbox boolean)-->
                    <div class="mb-3">
                        <label for="super_charge" class="form-label">Super Charge:</label>
                        <input type="checkbox" class="form-check-input mx-2" id="super_charge" name="super_charge"  value="<?php if(isset($_POST ['super_charge'])) echo $_POST['super_charge'];?>">
                    </div>
                    <!--transmission select dropdown-->
                    <div class="mb-3">
                        <label for="transmission" class="form-label">Transmission: </label>
                        <select class="form-select" id="transmission" name="transmission">
                        <option value="">Select Transmission</option>
                            <?php
                            $transmissions = array(
                                "0" => "Manual",
                                "1" => "Automatic",
                                "2" => "CVT",
                                "3" => "Semi-Automatic",
                                "4" => "Tiptronic"
                            );
                            // $transmissions = get_transmission();
                            ?>
                            <!--options value-->
                            <?php foreach($transmissions as $key => $value) : ?>
                                <option value="<?php echo $value; ?>" <?php if(isset($_POST['transmission']) && $_POST['transmission'] == $value) echo "selected";?>><?php echo $value; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <!--drive train select dropdown-->
                    <div class="mb-3">
                        <label for="drive_train" class="form-label">Drive Train: </label>
                        <select class="form-select" id="drivetrain" name="drivetrain">
                            <option value="">Select Drivetrain</option>
                            <option value="Front Wheel Drive" <?php if(isset($_POST['drivetrain']) && $_POST['drivetrain'] == "Front Wheel Drive") echo "selected"; ?>>Front Wheel Drive</option>
                            <option value="Rear Wheel Drive" <?php if(isset($_POST['drivetrain']) && $_POST['drivetrain'] == "Rear Wheel Drive") echo "selected"; ?>>Rear Wheel Drive</option>
                            <option value="All Wheel Drive" <?php if(isset($_POST['drivetrain']) && $_POST['drivetrain'] == "All Wheel Drive") echo "selected"; ?>>All Wheel Drive</option>
                            <option value="Four Wheel Drive" <?php if(isset($_POST['drivetrain']) && $_POST['drivetrain'] == "Four Wheel Drive") echo "selected"; ?>>Four Wheel Drive</option>
                        </select>
                    </div>
                    <!--fuel type select dropdown-->
                    <div class="mb-3">
                        <label for="fuel_type" class="form-label">Fuel Type: </label>
                        <select class="form-select" id="fuel_type" name="fuel_type">
                        <option value="">Select Fuel Type</option>
                            <?php
                            $fuel_types = array(
                                "0" => "Gasoline",
                                "1" => "Diesel",
                                "2" => "Electric",
                                "3" => "Hybrid",
                                "4" => "Hydrogen"
                            );
                            // $fuel_types = get_fuel_type();
                            ?>
                            <!--options value-->
                            <?php foreach($fuel_types as $key => $value) : ?>
                                <option value="<?php echo $value; ?>" <?php if(isset($_POST['fuel_type']) && $_POST['fuel_type'] == $value) echo "selected";?>><?php echo $value; ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- price input-->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price: </label>
                        <input type="number" class="form-control" id="price" name="price" min="0" max="1000000" value="<?php if(isset($_POST['price'])) echo $_POST['price'];?>">
                    </div>
                    <!-- features text area-->
                    <div class="mb-3">
                        <label for="features" class="form-label">Features: </label>
                        <textarea class="form-control" id="features" name="features" rows="3"><?php if(isset($_POST['features'])) echo $_POST['features'];?></textarea>
                    </div>
                    <!-- url input-->
                    <div class="mb-3">
                        <label for="url" class="form-label">URL: </label>
                        <input type="url" class="form-control" id="url" name="url" value="<?php if(isset($_POST['url'])) echo $_POST['url'];?>">
                    </div>
                    <!-- image upload file input-->
                    <div class="mb-3">
                        <label for="myfile" class="form-label">Image: </label>
                        <input type="file" class="form-control" id="myfile" name="myfile">
                    </div>
                    <!--Add Attraction button-->
                    <button type="submit" class="btn btn-success" name="addsubmit">Upload Vehicle</button>
                </form>
            </div>
        </div>
    </section>






<?php include("includes/footer.php") ?>