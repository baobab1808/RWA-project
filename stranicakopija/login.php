<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to goodbye page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: goodbye.php");
    exit;
}

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'korisnici');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "<h3 style='color:white;'>Please enter your password.</h3>";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT ID, Username, Lozinka FROM korisnici WHERE Username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
					//$hashed_password = "SELECT Lozinka WHERE Username = ?";
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
							
                          // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username; 
							
							if($username == 'admin'){
								header("location: hehehe_admin.html");
							}else{
								header("location: hehehe_logged.html");
							}
                            
                            // Redirect user to welcome page
                            
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "<h3 style='color:white;'>The password you entered was not valid.</h3>";
							
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "<h3 style='color:white;'>No account found with that username.</h3>";
					
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif;
			  background-image: url('Haus4.jpg');
			  background-size: cover;
			}
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
 <center>   <div class="wrapper" style="background:rgba(0,0,0,0.4); margin-top:200px; border-radius:25px; color:white;">
        <h2>Login</h2>
        <p>Molim Vas ispunite sljedeća polja.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Korisničko ime</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" >
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Lozinka</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login" style="background-color:#00CCCC">
				<a class="btn btn-link" href="hehehe.html" style="color:#00CCCC">Odustani</a>
            </div>
            <p>Nemate račun? <a href="signup.php" style="color:#00CCCC">Registrirajte se</a>.</p>
			<!---<p>Forgot password? <a href="reset1.php">Reset here</a>.</p>--->
        </form>
    </div> </center>   
</body>
</html>