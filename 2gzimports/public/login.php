<!-- //create a bs5 login form. then if isset submit (has the user clocked the button), and grab/initiate the vars for user/password -->
<?php 
include ("/home/bcalderon2/data/jdmlogindata.php");
?>
<?php session_start(); ?>
<?php $title = "Log In || Edmonton Attraction";?>
<?php include "includes/header.php"; ?>
<?php
//initialize email variable
$username = isset($_POST['username']) ? trim($_POST['username']) : "";

//initialize password variable
$password = isset($_POST['password']) ? trim($_POST['password']) : "";
$msg = "";


if(isset($_POST['mysubmit']))
{
    
    //echo "form submitted";
    if(($username == $username_good) && (password_verify($password, $pw_encription)))
    {
        $msg = "login successful <br> WELCOME $username";
        $msg = "<div class=\"alert alert-success\" role=\"alert\">Login successful!! WELCOME $username</div>";
       
        $_SESSION['username123321'] = session_id();
        header("Location: admin.php");
    }
    else
    {
        if(($username != "" && $password != ""))
        {
            $msg = "<div class=\"alert alert-danger\" role=\"alert\">Login failed, Invalid Username and/or Password</div>";
        }
        else
        {
            $msg = "<div class=\"alert alert-danger\" role=\"alert\">Please Enter a Username and Password</div>";
        }
    }
}
?>    
<?php include "includes/header.php"; ?>

    <?php
        if($msg)
        {
            echo "<div class=\"container w-50 mt-5 text-center \">$msg</div>";
        }
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
<div class="my-5 pt-5">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-center mb-4">Login for more Horse Power</h4>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method ="post" >
                    <div class="mb-3">
                        <label for="username" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter your email" name="username" value="<?php echo $username;?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" value="<?php echo $password;?>">
                    </div>
                            <button type="submit" class="btn btn-outline-dark" name="mysubmit">Login</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include "includes/footer.php"; ?>