<?php
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
$name = $surname = $email = $text ="";
$name_err = $surname_err = $email_err = $text_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
     // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";
    } 
	else{
        // Prepare a select statement
        $sql = "SELECT ID_poruke FROM poruke WHERE Ime = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "This name is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
	
	
	     // Validate surname
    if(empty(trim($_POST["surname"]))){
        $surname_err = "Please enter your surname.";
    }
	else{
        // Prepare a select statement
        $sql = "SELECT ID_poruke FROM poruke WHERE Prezime = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_surname);
            
            // Set parameters
            $param_surname = trim($_POST["surname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                 if(mysqli_stmt_num_rows($stmt) == 1){
                    $surname_err = "This surname is already taken.";
                } else{
                    $surname = trim($_POST["surname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
	
	// Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } /*elseif {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
		}*/
	else{
        // Prepare a select statement
        $sql = "SELECT ID_poruke FROM poruke WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                 if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        
         
        // Close statement
        mysqli_stmt_close($stmt);
		}
    }
	
	
    // Validate text
    if(empty(trim($_POST["text"]))){
        $text_err = "Please, enter your question.";
    } else{
        // Prepare a select statement
        $sql = "SELECT ID_poruke FROM poruke WHERE Poruka = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_text);
            
            // Set parameters
            $param_text = trim($_POST["text"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $text_err = "This text is already taken.";
                } else{
                    $text = trim($_POST["text"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($surname_err) && empty($email_err) && empty($text_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO poruke (Ime, Prezime, email, Poruka) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 'ssss', $param_name, $param_surname, $param_email, $param_text);
            
            // Set parameters
			$param_name = $name;
			$param_surname = $surname;
			$param_email = $email;
            $param_text = $text;
            
			
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to info page
				
				echo '<script>
				alert ("Your message has been sent");
				window.location = "infoENG_logged.php";
				</script>';
				
				//header("location: info.php");
            }else{
                echo "Something went wrong. Please try again later.";
            }
        
		
        // Close statement
        mysqli_stmt_close($stmt);
		}
		
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Apartmani Jelena</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.container {
  position: relative;
  text-align: center;
  color: white;
}

.top-left {
  position: absolute;
  top: 8px;
  left: 16px;
}

.topnav {
  overflow: hidden;
  background-color: #00CCFF;
}

.topnav a {
  float: left;
  display: block;
  color: #000000;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #CCFFFF;
  color: black;
}

.topnav a.active {
  background-color: #00CCCC;
  color: white;
}

.topnav .icon {
  display: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 17px;  
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 120px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: center;
}

.dropdown-content a:hover {
  background-color: #CCFFFF;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.topnav-right{
	float: right;
}

#jezik{
	height: 40px;
	width: 60px;
	align: right;
	
}

#jezik1{
	float: right;
}

#login{
	float: right;
}

.mySlides {
	text-align: center;
	height: 200px;
}

.mySlides img{
	width: 100%;
	max-height: 100%;
	object-fit: cover;
}

/* Slideshow container */
.slideshow-container {
  max-width: 100%;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 5px;
  width: 5px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }

.cover {object-fit: cover;}




</style>
</head>
<body style="background-image:url('pozadina3.jpg'); background-size:cover;">

<div class="topnav" id="myTopnav">
  <a href="heheheENG_logged.html">Home</a>
  <a href="lokacijaENG_logged.html">Location</a>
   <div class="dropdown">
    <button class="dropbtn">Accommodation
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="mala_sobaENG_logged.html">Small room</a>
      <a href="velika_sobaENG_logged.html">Large room</a>
      <a href="apartmanENG_logged.html">An apartment</a>
    </div>
  </div> 
  <a href="kontaktiENG_logged.html">Contacts</a>
  <a href="infoENG_logged.php"  class="active">Information</a>
  <div class="topnav-right">
	  <div class="dropdown">
		<button class="dropbtn" id="jezik1" style="float:right">Language
		  <i class="fa fa-caret-down"></i>
		</button>
		<div class="dropdown-content" id="jezik">
		  <a href="hehehe_logged.html">ENG</a>
		</div>
	  </div> 
	  <a href="loginENG.php">Sign in</a>
  </div>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>

<!---<div class="container">
  <img class="cover" id ="more" src="more.jpg" width="100%" height="250"> 
  <div class="top-left"><h2>Apartmani Jelena</h2></div>  
</div>--->

<div class="slideshow-container">

	<div class="mySlides fade">
	  <div class="numbertext">1 / 3</div>
	  <img src="naslovna1.png" style="width:100%">
	  
	</div>

	<div class="mySlides fade">
	  <div class="numbertext">2 / 3</div>
	  <img src="naslovna2.png" style="width:100%">
	  
	</div>

	<div class="mySlides fade">
	  <div class="numbertext">3 / 3</div>
	  <img src="naslovna3.png" style="width:100%">
	  
	</div>

	<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
	<a class="next" onclick="plusSlides(1)">&#10095;</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>

<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>

<center><div style="background:rgba(255,255,255,0.7); border-radius:25px; width:700px">
	<h1 style="text-align:center; font-family:Decorative;"><i><b>Additional questions? Feel free to send them to us!</b></i></h1>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="align:center">
		<div <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
			<input type="text" name="name" size="54.85" placeholder="Name" value="<?php echo $name; ?>" style="border-radius:15px;" required>
			<span><?php echo $name_err; ?></span>
		</div> 
		<br>
		<div <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>">
			<input type="text" name="surname" size="54.85" placeholder="Surname" value="<?php echo $surname; ?>" style="border-radius:15px;" required>
			<span><?php echo $surname_err; ?></span>
		</div> 
		<br>
		<div <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
			<input type="text" name="email" size="54.85" placeholder="E-mail" value="<?php echo $email; ?>" style="border-radius:15px;" required>
			<span><?php echo $email_err; ?></span>
		</div> 
		<br>
		<div <?php echo (!empty($text_err)) ? 'has-error' : ''; ?>">
			<textarea  name ="text" rows="25" cols="50" placeholder="Your message" value="<?php echo $text; ?>" style="border-radius:15px;" required></textarea>
			<span><?php echo $text_err; ?></span>
		</div> 
		<br>
		<!---<input type="text" name="firstname" size="54.85" placeholder="Ime" required><br/>
		<input type="text" name="lastname" size="54.85" placeholder="Prezime" required><br/>
		<input type="text" name="email" size="54.85" placeholder="E-mail" required><br/>
		<textarea rows="25" cols="50" placeholder="Vaša poruka" required></textarea><br/>--->
		<div>
			<input type="submit" name="submit" value="Send" style="height:50px; width:100px; border-radius:10px; background-color:#00CCCC; color:black; font-weight:bold;" onClick="poruka_uspjeca">
		</div>
		<!---<input type="submit" name="submit" value="Pošalji" style="height:50px; width:100px" >--->
	</form>
</div></center>



<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>




</body>
</html>