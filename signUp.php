<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";

    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";





        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) ){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

        }

        // Close statement
        mysqli_stmt_close($stmt);
      }



    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signUp.css">
</head>

<body>
<div class="bg">
    <body>

        <div class="wrapper">
            <div class="wrapper-contents">
                <div class="top-design"></div>
                <button onclick="#" id="with-Google">Sign up with Google</button>
                <button onclick="#" id="with-Facebook">Sign up with Facebook</button>


                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="fields">
                  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <input type="text" name="username" placeholder="Username or email" id="Password" class="form-control" value="<?php echo $username; ?>">
                 <span class="help-block"><?php echo $username_err; ?></span>
             </div>

        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

      <input type="password" name="password"  placeholder="Password" class="form-control" id="Password" value="<?php echo $password; ?>">
      <span class="help-block"><?php echo $password_err; ?></span>
  </div>
  <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

      <input type="password" name="confirm_password" placeholder="Confirm Password" id="Password" class="form-control" value="<?php echo $confirm_password; ?>">
      <span class="help-block"><?php echo $confirm_password_err; ?></span>
  </div>
                    <button id="sign-up" value="Submit">Sign up</button>
                </div>


                <div class="bottom-case">
                    <a id="login-here" href="index.php">Already have an account? Login here</a>
                </div>

            </div>
        </div>
        </div>
    </body>
</body>

</html>
