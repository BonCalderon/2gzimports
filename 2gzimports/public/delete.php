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

$id = (isset($_GET['id'])) ? $_GET['id'] : "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} elseif (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $id = "";
}



$message = "";
$update_message = "";

$deletethis_carid = select_car_by_id($id);



if(isset($_POST['deletecar']))
{
    // echo "form submitted"; tested and working
    $do_i_proceed = true;

        // if submit is clicked, delete the attraction from database
            if($do_i_proceed)
            {
                delete_car($id);
                header("Location: admin.php");
            }else
            {
                $message .= "<p>Unable to delete attraction</p>";
            }


}

?>
<?php 
//the <title> may change, so let's just have a variable
$title = "Delete an Attraction || Administrative Access for Edmonton Attractions";
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
    <h1 class="text-center mb-3">Delete A Record</h1>
    <p class="text-muted">To Delete a record in our database, click 'Delete' beside the row you would like to change. Next, a message will pop-up to promtp you to delete the selected Vehicle. Hit OK to Delete Vehicle.</p>
    <section>


        <div class="list">

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

            echo "\n\t<th>Delete</th>";
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
                // clickable link for delete button
                echo "\n\t
                <td class='text-center'>
                <form action='delete.php' method='post' onsubmit=\"return confirm('Are you sure you want to delete this record?');\">
                <button type='submit button' name='deletecar' class='btn btn-danger'>Delete</button>
                <input type='hidden' name='id' value='$id'>
                </form>
                </td>";
                echo "\n\t</tr>";
    
            }
            echo "\n</table>";

        }
        ?>
        </div>


 

    </section>




<?php include("includes/footer.php") ?>