<?php
//set all prepared statements
/*
Make, Year, model, body_type, engine_type, driving_style, engine_displacement, turbocharge, supercharge, transmission, drivetrain, fuel_type, price, features, url, img */
//select statement
$select_statement = $connection->prepare("SELECT * FROM jdm_catalogue");

//insert statement
$insert_statement = $connection->prepare("INSERT INTO jdm_catalogue (make, model, year, body_type, engine_type, driving_style, engine_displacement, turbocharge, supercharge, transmission, drivetrain, fuel_type, price, features, url, filename ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

//edit statement
$edit_statement = $connection->prepare("UPDATE jdm_catalogue SET make = ?, model = ?, year = ?, body_type = ?, engine_type = ?, driving_style = ?, engine_displacement = ?, turbocharge = ?, supercharge = ?, transmission = ?, drivetrain = ?, fuel_type = ?, price = ?, features = ?, url = ? WHERE id = ?");

// select statement for make 
$select_make_statement = $connection->prepare("SELECT * FROM jdm_catalogue WHERE make = ?");

//select by id statement
$select_byid_statement = $connection->prepare("SELECT * FROM jdm_catalogue WHERE id = ?");

//delete statement
$delete_statement = $connection->prepare("DELETE FROM jdm_catalogue WHERE id = ?");

$select_random_statement = $connection->prepare("SELECT * FROM jdm_catalogue ORDER BY RAND() LIMIT 1");

function get_all_cars()
{
    global $connection;
    global $select_statement;

    if (!$select_statement->execute()) {
        handle_database_error("Error grabbing all cars from database");
    }

    $result = $select_statement->get_result();

    $cars = [];
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
    return $cars;
}
function get_car_by_make($selectedmake)
{
    global $connection;
    global $select_make_statement;

    $select_make_statement->bind_param("s", $make);
    if (!$select_make_statement->execute()) {
        handle_database_error("Error grabbing all car Make from database");
    }

    $result = $select_make_statement->get_result();

    $make = [];
    while ($row = $result->fetch_assoc()) {
        $make[] = $row;
    }
    return $make;
}

function select_car_by_id($id)
{
    global $connection;
    global $select_byid_statement, $connection;
    $select_byid_statement->bind_param("i", $id);

    if (!$select_byid_statement->execute()) {
        handle_database_error("Error grabbing Car by Id from database");
    }
    $result = $select_byid_statement->get_result(); // getmysqli result

    $selectedcar = $result->fetch_assoc(); // get associative array
    return $selectedcar;
}
function update_car($editmake, $editmodel, $edityear, $editbody_type, $editengine_type, $editdriving_style, $editengine_displacement, $editturbocharge, $editsupercharge, $edittransmission, $editdrivetrain, $editfuel_type, $editprice, $editfeatures, $editurl, $car_id)
{
    global $connection;
    global $edit_statement;

    $edit_statement->bind_param("ssisssdiisssdssi", $editmake, $editmodel, $edityear, $editbody_type, $editengine_type, $editdriving_style, $editengine_displacement, $editturbocharge, $editsupercharge, $edittransmission, $editdrivetrain, $editfuel_type, $editprice, $editfeatures, $editurl, $car_id);
    $edit_statement->execute();
}
function insert_car($make, $model, $year, $body_type, $engine_type, $driving_style, $engine_displacement, $turbocharge, $supercharge, $transmission, $drivetrain, $fuel_type, $price, $features, $url, $filename)
{
    global $connection;
    global $insert_statement;
    $insert_statement->bind_param("ssisssdiisssdsss", $make, $model, $year, $body_type, $engine_type, $driving_style, $engine_displacement, $turbocharge, $supercharge, $transmission, $drivetrain, $fuel_type, $price, $features, $url, $filename);

    if (!$insert_statement->execute()) {
        handle_database_error("Inserting Car.");
    }
}
function delete_car($id)
{
    global $connection;
    global $delete_statement;
    $delete_statement->bind_param("i", $id);
    $delete_statement->execute();
}
function createImageCopy($file, $folder, $newWidth, $showThumb = 1){
    list($width, $height, $type) = getimagesize($file);
    $imgRatio = $width / $height;

    $newHeight = $newWidth / $imgRatio;

    $thumb = imagecreatetruecolor($newWidth, $newHeight);

    if ($type == IMAGETYPE_JPEG) {
        $source = imagecreatefromjpeg($file);
    } elseif ($type == IMAGETYPE_PNG) {
        $source = imagecreatefrompng($file);
    } else {
        // Handle other image types if needed
        return false;
    }

    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    $fileName = $folder . basename($file);
    imagejpeg($thumb, $fileName, 80); // 80 here is the JPEG quality

    imagedestroy($thumb);
    imagedestroy($source);

    // if($showThumb == 1){// just so we only show the thumbnail image once.
    //     echo "<img src=\"thumbs200/". basename($file) ."\">";
    // }
}
function createSquareImageCopy($file, $folder, $newWidth){
    list($width, $height, $type) = getimagesize($file);

    $thumb_width = $newWidth;
    $thumb_height = $newWidth;// tweak this for ratio

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    if($original_aspect >= $thumb_aspect) {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
    } else {
        // If the thumbnail is wider than the image
        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
    }

    if ($type == IMAGETYPE_JPEG) {
        $source = imagecreatefromjpeg($file);
    } elseif ($type == IMAGETYPE_PNG) {
        $source = imagecreatefrompng($file);
    } else {
        // Handle other image types if needed
        return false;
    }

    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

    // Resize and crop
    imagecopyresampled($thumb,
        $source, 0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
        0 - ($new_height - $thumb_height) / 2, // Center the image vertically
        0, 0,
        $new_width, $new_height,
        $width, $height);

    $newFileName = $folder . "/" . basename($file);
    imagejpeg($thumb, $newFileName, 80);

    //echo "<img src=\"thumbs200/". basename($file) ."\">";
}
function random_car() {
    global $connection;
    global $select_random_statement;
 
    if (!$select_random_statement->execute()) {
        handle_database_error("Error selecting random car book from database.");
    }
    $result = $select_random_statement->get_result();
    $random_car = $result->fetch_assoc();
    return $random_car;
}
function sanitize_input($input) {
    return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
}
