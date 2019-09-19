<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HNG_Landing_Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel = "stylesheet" type = "text/css" href = "welcome.css">
</head>
<body>

<div class="navbars">
    <a ><i class="fa fa-fw fa-user"></i>Welcome</a>
    <div class="header">
      <a> <?php echo htmlspecialchars($_SESSION["username"]); ?></a>
    </div>
    <div class="logout">
      <a  href = "logout.php"> Logout</a>
    </div>
          </div>

                </div>



  <div class = "wording">
      <h1>Welcome To Our Blog</h1>
  </div>


</body>
</html>
