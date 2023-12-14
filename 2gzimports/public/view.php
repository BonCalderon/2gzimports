
<?php
require_once("/home/bcalderon2/data/connect.php");
require_once("../private/prepared.php")
?>

<?php

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

$id = (isset($_GET['id'])) ? $_GET['id'] : "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $id = "";
}

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


$title = "More Details";
include('includes/header.php');


?>

<?php 
$id = $_GET['id'];

$result  = mysqli_query($connection, "SELECT * FROM jdm_catalogue WHERE id = $id") or die(mysqli_error($connection));

while($row = mysqli_fetch_array($result)): ?>

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
<main class="container flex-column d-flex align-items-center">
    <div class="card col-md-10 col-lg-8 col-xxl-6">
    <h2 class="text-center mb-3"><?php echo $existing_make . ' ' . $existing_model; ?></h1>
        <img src='display800/<?php echo $row['filename']; ?>' class='card-img-top' alt='<?php echo $row['filename']; ?>'>
        <div class="card-body">
            <p class="card-text"><b>Year:</b> <?php echo $row['year']; ?></p>
            <p class="card-text"><b>Body:</b> <?php echo $row['body_type']; ?></p>
            <p class="card-text"><b>Engine Type:</b> <?php echo $row['engine_type']; ?></p>
            <p class="card-text"><b>Driving Style:</b> <?php echo $row['driving_style']; ?></p>
            <p class="card-text"><b>Engine Displacement:</b> <?php echo number_format($row['engine_displacement'], 1); ?></p>
            <p class="card-text"><b>Turbocharged?:</b> <?php echo ($row['turbocharge'] == 1) ? 'Yes' : 'No'; ?></p>
            <p class="card-text"><b>Supercharged?:</b> <?php echo ($row['supercharge'] == 1) ? 'Yes' : 'No'; ?></p>
            <p class="card-text"><b>Transmission:</b> <?php echo $row['transmission']; ?></p>
            <p class="card-text"><b>Drivetrain:</b> <?php echo $row['drivetrain']; ?></p>
            <p class="card-text"><b>Fuel:</b> <?php echo $row['fuel_type']; ?></p>
            <p class="card-text"><b>Price:</b> <?php echo $row['price']; ?></p>
            <p class="card-text"><b>Features:</b> <?php echo $row['features']; ?></p>
            <p class="card-text"><b>Watch a Montage!  </b><a href="<?php echo $row['url'];?>" target='_blank' class='btn btn-outline-dark'>YouTube</a></p>
            <a href="index.php" class="btn btn-dark">Home</a>
        </div>

    </div>
</main>

<?php endwhile; ?>


<?php
include('includes/footer.php');
?>