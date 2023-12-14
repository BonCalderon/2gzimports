<?php

//security: only authenticated users aer allowed here
// If not authenticated, redirect to login
session_start();
if (!isset($_SESSION['username123321'])) {
    echo "You are not authenticated";
    header("Location: login.php");
} else {
    // echo "<h1>Welcome to the secure site</h1>";
}

//establish server connection using root of the server
require_once("/home/bcalderon2/data/connect.php");

require_once("../private/prepared.php"); // get access to all functions in prepared.php

$id = (isset($_GET['id'])) ? $_GET['id'] : "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $id = "";
}

//edit form input
$editmake = (isset($_POST['make'])) ? $_POST['make'] : "";
$editmodel = (isset($_POST['model'])) ? $_POST['model'] : "";
$edityear = (isset($_POST['year'])) ? $_POST['year'] : "";
$editbody_type = (isset($_POST['body_type'])) ? $_POST['body_type'] : "";
$editengine_type = (isset($_POST['engine_type'])) ? $_POST['engine_type'] : "";
$editdriving_style = (isset($_POST['driving_style'])) ? $_POST['driving_style'] : "";
$editengine_displacement = (isset($_POST['engine_displacement'])) ? $_POST['engine_displacement'] : "";
$editturbocharge = (isset($_POST['turbocharge'])) ? trim($_POST['turbocharge']) : "";
$editsupercharge =  (isset($_POST['supercharge'])) ? trim($_POST['supercharge']) : "";
$edittransmission = (isset($_POST['transmission'])) ? $_POST['transmission'] : "";
$editdrivetrain = (isset($_POST['drivetrain'])) ? $_POST['drivetrain'] : "";
$editfuel_type = (isset($_POST['fuel_type'])) ? $_POST['fuel_type'] : "";
$editprice = (isset($_POST['price'])) ? $_POST['price'] : "";
$editfeatures = (isset($_POST['features'])) ? $_POST['features'] : "";
$editurl = (isset($_POST['url'])) ? $_POST['url'] : "";

$message = "";
$update_message = "";

$existing_model = "";
$existing_make = "";
$existing_year = "";
$existing_body_type = "";
$existing_engine_type = "";
$existing_drivingstyle = "";
$existing_engine_displacement = "";
$existing_turbocharge = "";
$existing_supercharge = "";
$existing_transmission = "";
$existing_drivetrain = "";
$existing_fuel_type = "";
$existing_price = "";
$existing_features = "";
$existing_url = "";

if (isset($id)) {
    if (is_numeric($id) && $id > 0) {

        $car = select_car_by_id($id);
        extract($car);
        if ($car) {
            $existing_make = $car['make'];
            $existing_model = $car['model'];
            $existing_year = $car['year'];
            $existing_body_type = $car['body_type'];
            $existing_engine_type = $car['engine_type'];
            $existing_drivingstyle = $car['driving_style'];
            $existing_engine_displacement = $car['engine_displacement'];
            $existing_turbocharge = $car['turbocharge'];
            $existing_supercharge = $car['supercharge'];
            $existing_transmission = $car['transmission'];
            $existing_drivetrain = $car['drivetrain'];
            $existing_fuel_type = $car['fuel_type'];
            $existing_price = $car['price'];
            $existing_features = $car['features'];
            $existing_url = $car['url'];
        } else {
            $message .= "<p>Car not found</p>";
        }
    }
}

if (isset($_POST['submit'])) {

    extract($_POST);

    $do_i_proceed = true;


    //validation for attraction name if select dropdown is empty
    if (empty($editmake)) {
        $do_i_proceed = false;
        $message .= "<p>Make is required</p>";
    }

    //validation for model if empty
    $editmodel = filter_var($editmodel, FILTER_SANITIZE_STRING);
    $editmodel = mysqli_real_escape_string($connection, $editmodel);
    if (strlen($editmodel) < 2 || strlen($editmodel) > 50) {
        $do_i_proceed = false;
        $message .= "<p>Model must be between 2 to 50 characters</p>";
    }

    //validation for year
    $edityear = filter_var($edityear, FILTER_SANITIZE_NUMBER_INT);
    if ($edityear < 1900 || $edityear > 2025) {
        $do_i_proceed = false;
        $message .= "<p>Collection only have years between 1975 to Present</p>";
    } else if (!filter_var($edityear, FILTER_VALIDATE_INT)) {
        $do_i_proceed = false;
        $message .= "<p>Year must be a valid number</p>";
    } else if (!is_numeric($edityear)) {
        $do_i_proceed = false;
        $message .= "<p>Year must be a valid number</p>";
    }

    //validation for body type
    $editbody_type = filter_var($editbody_type, FILTER_SANITIZE_STRING);
    $editbody_type = mysqli_real_escape_string($connection, $editbody_type);
    if (strlen($editbody_type) < 2 || strlen($editbody_type) > 50) {
        $do_i_proceed = false;
        $message .= "<p>Body Type must be between 2 to 50 characters</p>";
    }

    //validation for engine type
    $editengine_type = filter_var($editengine_type, FILTER_SANITIZE_STRING);
    $editbody_type = mysqli_real_escape_string($connection, $editbody_type);
    if (strlen($editengine_type) < 2 || strlen($editengine_type) > 50) {
        $do_i_proceed = false;
        $message .= "<p>Engine Type must be between 2 to 50 characters</p>";
    }
    //validation for driving style
    $editdriving_style = filter_var($editdriving_style, FILTER_SANITIZE_STRING);
    $editdriving_style = mysqli_real_escape_string($connection, $editdriving_style);


    //validation for engine displacement
    $editengine_displacement = filter_var($editengine_displacement, FILTER_SANITIZE_NUMBER_FLOAT);
    $editengine_displacement = mysqli_real_escape_string($connection, $editengine_displacement);
    if ($editengine_displacement <= 0) {
        $do_i_proceed = false;
        $message .= "<p>Engine Displacement Cannot be a negative value</p>";
    } else if (!filter_var($editengine_displacement, FILTER_VALIDATE_FLOAT)) {
        $do_i_proceed = false;
        $message .= "<p>Engine Displacement must be a valid number</p>";
    } else if (!is_numeric($editengine_displacement)) {
        $do_i_proceed = false;
        $message .= "<p>Engine Displacement must be a valid number</p>";
    }
 
    //validation for turbo charge
        
    $editturbocharge = 0;
    if(isset($_POST['turbocharge'])){
        $editturbocharge = 1;
    }

    //validation for super charge
    $editsupercharge = 0;
    if(isset($_POST['supercharge'])){
        $editsupercharge = 1;
    }

    //validation for transmission
    $edittransmission = filter_var($edittransmission, FILTER_SANITIZE_STRING);
    $edittransmission = mysqli_real_escape_string($connection, $edittransmission);
    if (strlen($edittransmission) < 2 || strlen($edittransmission) > 50) {
        $do_i_proceed = false;
        $message .= "<p>Transmission must be between 2 to 50 characters</p>";
    }

    //validation for drive train
    $editdrivetrain = filter_var($editdrivetrain, FILTER_SANITIZE_STRING);
    $editdrivetrain = mysqli_real_escape_string($connection, $editdrivetrain);

    //validation for fuel type
    $editfuel_type = filter_var($editfuel_type, FILTER_SANITIZE_STRING);
    $editfuel_type = mysqli_real_escape_string($connection, $editfuel_type);



    //validation for youtube url
    $editurl = filter_var($editurl, FILTER_SANITIZE_URL);
    $editurl = mysqli_real_escape_string($connection, $editurl);
    if (strlen($editurl) < 6 || strlen($editurl) > 50) {
        $do_i_proceed = false;
        $message .= "<p>Tell us what is the website link for everyone to watch!</p>";
    } else if (!filter_var($editurl, FILTER_VALIDATE_URL)) {
        $do_i_proceed = false;
        $message .= "<p>Website must be a valid URL</p>";
    }
    //validation for cost
    $editprice = filter_var($editprice, FILTER_SANITIZE_NUMBER_FLOAT);
    $editprice = mysqli_real_escape_string($connection, $editprice);
    if ($editprice <= 0) {
        $do_i_proceed = false;
        $message .= "<p>Price Cannot be a negative value</p>";
    } else if (!filter_var($editprice, FILTER_VALIDATE_FLOAT)) {
        $do_i_proceed = false;
        $message .= "<p>Price must be a valid number</p>";
    } else if (!is_numeric($editprice)) {
        $do_i_proceed = false;
        $message .= "<p>Price must be a valid number</p>";
    }


    //if validation passed , then lets do an update
    if ($do_i_proceed == TRUE) {
        //update the car
        update_car($editmake, $editmodel, $edityear, $editbody_type, $editengine_type, $editdriving_style, $editengine_displacement, $editturbocharge, $editsupercharge, $edittransmission, $editdrivetrain, $editfuel_type, $editprice, $editfeatures, $editurl, $id);
        $message .= "<p>Vehicle updated successfully</p>";
        $car_id = "";
        header("Location: admin.php");
    } else {
        $message .= "<p>Vehicle not updated, Required fields must be filled up!</p>";
    }
}

?>
<?php
//the <title> may change, so let's just have a variable
$title = "Edit a Vehicle Record";
include("includes/header.php")
?>

<!--display the car make and model to edit by car_id-->

<h1 class="text-center mb-3">Edit <?php echo $existing_make . ' ' . $existing_model; ?></h1>


<section class="container">

    <?php if ($message != "") : ?>
        <div class="alert alert-danger">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- EDIT FORM -->
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) . '?id=' . $id; ?>" method="post">

        <?php if (isset($update_message)) : ?>
            <div class="message text-danger">
                <?php echo $update_message; ?>
            </div>
        <?php endif; ?>

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
                    $selected = ($editmake == $value || $existing_make == $value) ? 'selected' : '';
                    echo "<option value=\"$value\" $selected>$value</option>";
                }
                ?>
            </select>
        </div>

        
        

        <!--Model input-->
        <div class="mb-3">
            <label for="model" class="form-label">Model: </label>
            <input type="text" class="form-control" id="model" name="model" value="<?php echo $existing_model;?>">
        </div>

        <!--Year input-->
        <div class="mb-3">
            <label for="year" class="form-label">Year: </label>
            <input type="number" class="form-control" id="year" name="year" min="1900" max="2021" value="<?php echo $existing_year;?>">
        </div>

        <!--body_type input select drop down-->
        <div class="mb-3">
            <label for="body_type" class="form-label">Body Type: </label>
            <select name="body_type" id="body_type" class="form-select form-select-md">

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
                foreach ($body_type as $bdytype) {
                    $selected = (isset($_POST['body_type']) && $_POST['body_type'] == $bdytype) ? 'selected' : '';
                    echo "<option value=\"$bdytype\" $selected>$bdytype</option>";
                }
                
                ?>
            </select>
        </div>

        <!--engine_type input select dropdown-->
        <div class="mb-3">
            <label for="engine_type" class="form-label">Engine Type: </label>
            <select class="form-select" id="engine_type" name="engine_type">
                <?php
                $engine_type = [
                    "Inline4",
                    "Inline6",
                    "V6",
                    "V8",
                    "V10",
                    "V12",
                    "W12",
                    "Other"
                ];
                foreach ($engine_type as $engtype) {
                    $selected = (isset($_POST['engine_type']) && $_POST['engine_type'] == $engtype) ? 'selected' : '';
                    echo "<option value=\"$engtype\" $selected>$engtype</option>";
                }
                ?>
            </select>
        </div>
        <!--driving_style-->
        <div class="mb-3">
            <label class="form-check-label" for="cost">Driving Style:</label>
            <?php
            $rating = ['RHD', 'LHD'];
            foreach ($rating as $rating) {
                $checked = (isset($_POST['driving_style']) && $_POST['driving_style'] == $rating) ? 'checked' : '';
                echo "<div class=\"form-check form-check-inline\">";
                echo "<input class=\"form-check-input\" type=\"radio\" name=\"driving_style\" id=\"driving_style\" value=\"$rating\" $checked>";
                echo "<label class=\"form-check-label\" for=\"driving_style\">$rating</label>";
                echo "</div>";
            }
            ?>
        </div>
        <!--engine_displacement-->
        <div class="mb-3">
            <label for="engine_displacement" class="form-label">Engine Displacement: </label>
            <input type="text" class="form-control" id="engine_displacement" name="engine_displacement" value="<?php echo $existing_engine_displacement;?>">
        </div>



        <!--turbo charge (checkbox boolean)-->
        <div class="mb-3">
            <label for="turbo_charge" class="form-label">Turbo Charge:</label>
            <input type="checkbox" class="form-check-input" id="turbo_charge" name="turbo_charge" value="1" <?php if($editturbocharge == 1) echo "checked"; ?>>
        </div>

        <!--super charge (checkbox boolean)-->
        <div class="mb-3">
            <label for="super_charge" class="form-label">Super Charge:</label>
            <input type="checkbox" class="form-check-input" id="super_charge" name="super_charge" value="1"  <?php if($editsupercharge == 1) echo "checked"; ?>>
        </div>


        <!--transmission select dropdown-->
        <div class="mb-3">
            <label for="transmission" class="form-label">Transmission: </label>
            <select class="form-select" id="transmission" name="transmission">
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
                <?php
                $drivetrains = array(
                    "0" => "FWD",
                    "1" => "RWD",
                    "2" => "AWD",
                    "3" => "4WD"
                );
                ?>
                <!--options value-->
                <?php foreach($drivetrains as $key => $value) : ?>
                    <option value="<?php echo $value; ?>" <?php if(isset($_POST['drivetrain']) && $_POST['drivetrain'] == $value) echo "selected";?>><?php echo $value; ?></option>
                    <?php endforeach; ?>
            </select>

        </div>
        <!--fuel type select dropdown-->
        <div class="mb-3">
            <label for="fuel_type" class="form-label">Fuel Type: </label>
            <select class="form-select" id="fuel_type" name="fuel_type">
                <?php
                $fuel_types = array(
                    "0" => "Gasoline",
                    "1" => "Diesel",
                    "2" => "Electric",
                    "3" => "Hybrid",
                    "4" => "Hydrogen"
                );
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
            <input type="number" class="form-control" id="price" name="price" min="0" max="1000000" value="<?php echo $existing_price?>">
        </div>
        <!-- features text area-->
        <div class="mb-3">
            <label for="features" class="form-label">Features: </label>
            <textarea class="form-control" id="features" name="features" rows="3"><?php echo $existing_features ?></textarea>
        </div>
        <!-- url input-->
        <div class="mb-3">
            <label for="url" class="form-label">URL: </label>
            <input type="url" class="form-control" id="url" name="url" value="<?php echo $existing_url;?>">
        </div>


        <!--mowdal submit-->
        <button type="submit" class="btn btn-success" name="submit">Edit Vehicle</button>

    </form>


</section>




<?php include("includes/footer.php") ?>