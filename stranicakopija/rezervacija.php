<?php
	// Initialize the session
	session_start();
	 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: loginrez.php");
		exit;
	}
?>


<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script language="javascript" type="text/javascript">
    function dynamicdropdown(listindex)
    {
        switch (listindex)
        {
        case "Velika soba" :
            document.getElementById("status").options[0]=new Option("Broj gostiju","");
            document.getElementById("status").options[1]=new Option("1","1");
            document.getElementById("status").options[2]=new Option("2","2");
			document.getElementById("status").options[3]=new Option("3","3");
            break;
        case "Mala soba" :
            document.getElementById("status").options[0]=new Option("Broj gostiju","");
            document.getElementById("status").options[1]=new Option("1","1");
            document.getElementById("status").options[2]=new Option("2","2");
			document.getElementById("status").options[3]=new Option("3","3");
			break;
		case "Apartman" :
            document.getElementById("status").options[0]=new Option("Broj gostiju","");
            document.getElementById("status").options[1]=new Option("1","1");
            document.getElementById("status").options[2]=new Option("2","2");
			document.getElementById("status").options[3]=new Option("3","3");
			document.getElementById("status").options[4]=new Option("4","4");
			document.getElementById("status").options[5]=new Option("5","5");
			document.getElementById("status").options[6]=new Option("6","6");
			document.getElementById("status").options[7]=new Option("7","7");
			document.getElementById("status").options[8]=new Option("8","8");
			break;
        }
        return true;
    }
	</script>
	
	<style>
		select:hover{
			color:blue;
		}
		#status{
			width: 158px !important; 
			border-radius:5px !important;
		}
		#natrag{
			opacity: 0.6;
			transition: 0.3s;
		}
		#natrag:hover {
			opacity: 1;
		}
		
		.raise:hover,
		.raise:focus {
			box-shadow: 0 0.5em 0.5em -0.4em var(--hover);
			transform: translateY(-0.25em);
		}
	</style>
	
</head>

<body style="background-image:url('Haus3.jpg'); background-size:cover;">

<center><div style="background:rgba(0,0,0,0.6); border-radius:25px; width:300px; height:540px; color:white;">
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method ="post">
		<div style="margin-top:70px; font-size:25px;">
		<br>
		  <div>
				Korisničko ime:<input type="text" name="username" placeholder="Korisničko ime" autocomplete="off" style="border-radius:5px;">
		  </div>
		  <br>
		  <div class="category_div" id="category_div">Smještaj:<br>
				<select id="source" name="source" onchange="javascript: dynamicdropdown(this.options[this.selectedIndex].value);" style="width:158px; border-radius:5px;">
				<option value="">Odabir smještaja</option>
				<option value="Velika soba">Velika soba</option>
				<option value="Mala soba">Mala soba</option>
				<option value="Apartman">Apartman</option>
				</select>
			</div>
			<br>
			<div class="sub_category_div" id="sub_category_div">Broj gostiju:<br>
				<script type="text/javascript" language="JavaScript">
				document.write('<select name="status" id="status"><option value="">Broj gostiju</option></select>')
				</script>
				<noscript>
				<select id="status" name="status">
					<option value="1" >1</option>
					<option value="2">2</option>
					<option value="3">3</option>
				</select>
				</noscript>
			</div>
			<br>
			
			<div style="font-size:25px;">
				
				Datum dolaska:<input type="date" id="date1" name="dolazak" style="width:158px; border-radius:5px;"><br/>
				<br>
				Datum odlaska:<input type="date" id="date2" name="odlazak" style="width:158px; border-radius:5px;"><br/>
				<br>
				<input type="submit" id="naprijed" class="raise" value="Rezerviraj" style="width:120px; height:40px; font-size:15px; font-weight:bold; background-color:#3AEC58; border-radius:10px; ">
				<input type="button" id="natrag" onclick=" window.location.href='hehehe_logged.html';" value="Odustani" style="width:90px; height:40px; font-size:15px; font-weight:bold; background-color:#EC3A3A; border-radius:10px;"/>
			</div>
		</div>
	</form>
</div></center>

</body>

</html>

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
	$username = $smjestaj = $br_gostiju = $datum_dolaska = $datum_odlaska = $enes ="";
	$username_err = $smestaj_err = $br_gostiju_err = $datum_dolaska_err = $datum_odlaska_err ="";
	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		    // Validate username
		if(empty(trim($_POST["username"]))){
			$username_err = "Please enter a username.";
		} else{
			// Prepare a select statement
			$sql = "SELECT ID_Rezervacija FROM `rezervacija` WHERE Username = ?";
			
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				
				// Set parameters
				$param_username = trim($_POST["username"]);
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);
					$username = trim($_POST["username"]);
					/*if(mysqli_stmt_num_rows($stmt) == 1){
						$username_err = "This username is already taken.";
					} else{
						$username = trim($_POST["username"]);
					}*/
				} else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
	 								
		 // Validate smjestaj
		if(empty(trim($_POST["source"]))){
			$smjestaj_err = "Please enter a type of smjestaj.";
		} 
		else{
			// Prepare a select statement
			$sql = "SELECT ID_Rezervacija FROM rezervacija WHERE Smještaj = ?";
			
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_smjestaj);
				
				// Set parameters
				$param_smjestaj = trim($_POST["source"]);
				
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);
					$smjestaj = trim($_POST["source"]);
					/*if(mysqli_stmt_num_rows($stmt) == 1){
						$smjestaj_err = "This smjestaj is already taken.";
					}else{
						$smjestaj = trim($_POST["source"]);
					}*/
				}else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		
			 // Validate br_gost
		if(empty(trim($_POST["status"]))){
			$br_gostiju_err = "Please enter number of guests.";
		}
		else{
			// Prepare a select statement
			$sql = "SELECT ID_Rezervacija FROM rezervacija WHERE Broj_gosti = ?";
			
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "i", $param_br_gostiju);
				
				// Set parameters
				$param_br_gostiju = trim($_POST["status"]);
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);
					$br_gostiju = trim($_POST["status"]);
					/* if(mysqli_stmt_num_rows($stmt) == 1){
						$br_gostiju_err = "This number is already taken.";
					}else{
						$br_gostiju = trim($_POST["status"]);
					}*/
				}else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
			 // Validate datum dolaska
		if(empty(trim($_POST["dolazak"]))){
			$datum_dolaska_err = "Please enter date.";
		}
		else{
			// Prepare a select statement
			$sql = "SELECT ID_Rezervacija FROM rezervacija WHERE ( ? BETWEEN Datum_dolaska AND Datum_odlaska) AND (Smještaj = ?)";
			
			if($stmt = mysqli_prepare($link, $sql)){
				
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "ss", $param_datum_dolaska, $param_smjestaj);
				
				// Set parameters
				$param_datum_dolaska = trim($_POST["dolazak"]);
				//$param_smjestaj = trim($_POST["source"]);
				
				
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);
					$num_rows = mysqli_stmt_num_rows($stmt);
					
					
					if($num_rows > 0){
						
							$sql = "SELECT Datum_dolaska, Datum_odlaska FROM rezervacija WHERE Smještaj = ?";
							$stmt = $link->prepare($sql);
							$stmt->bind_param('s', $_POST["source"]);
							$stmt->execute();
							$result = $stmt->get_result();
						//  Provjera ima li rezultata
						if ($result->num_rows > 0) {
							echo '<div style="background:rgba(255,0,0,0.8); border-radius:15px; width:420px; color:white; font-size:18px; margin-right:50px; margin-bottom:50px; float:right;">';
							echo "<b>Vaši datumi za odabrani smještaj su zauzeti.<br> Molim Vas odaberite nove datume koji se ne nalaze među sljedećima:</b>";
							echo "<br /><br />";
							echo"<table >";
							// Printanje rezultata
							while($row = $result->fetch_assoc()) {
								echo "<tr>";
								echo "<td>" ."Datum dolaska:".$row["Datum_dolaska"]. "</td>";
								echo "<td>"."</td>";
								echo "<td>" . "Datum odlaska:".$row["Datum_odlaska"]. "</td>";
								echo "</tr>";
							}
							echo"</table>";
							echo'</div>';
							$enes = 1;
						} else {
							echo "Nema rezultata";
						}
						
						
						
						
						/*$ispis="SELECT Datum_dolaska, Datum_odlaska FROM rezervacija WHERE Smještaj = ?";
						if($stmt1 = mysqli_prepare($link, $ispis)){
							mysqli_stmt_bind_param($stmt1, 's', $param_smjestaj);
						}
						if(mysqli_stmt_execute($stmt1)){
							//mysqli_stmt_store_result($stmt1);
							$result1 = $stmt1->get_result();
						}
						if($resutl1->num_rows > 0){
							while($row = $result1->fetch_assoc()){
								/*echo '<script>;
								alert ("Ovi datumi su zauzeti za ovaj smještaj. Datum dolaska:"+"{$row['Datum_dolaska']}"+"Datum odlaska:"+"{$row['Datum_odlaska']}");
								window.location = "rezervacija.php";
								</script>';
								
								echo "Zauzeti datumi dolaska:".$row['Datum_dolaska']."zauzeti datumi odlaska:".$row['Datumi_odlaska'];
							}
						}*/
						
						
						$datum_dolaska_err = "This date of arrival is already taken.";
					}else{
						$datum_dolaska = trim($_POST["dolazak"]);
					}
				}else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		
			 // Validate datum odlaska
		if(empty(trim($_POST["odlazak"]))){
			$datum_odlaska_err = "Please enter date.";
		}
		else{
			// Prepare a select statement
		   $sql = "SELECT ID_Rezervacija FROM rezervacija WHERE (? BETWEEN Datum_dolaska AND Datum_odlaska) AND (Smještaj = ?)";
			
			if($stmt = mysqli_prepare($link, $sql)){
			
				
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "ss", $param_datum_odlaska, $param_smjestaj);
				// Set parameters
				$param_datum_odlaska = trim($_POST["odlazak"]);
				//$param_smjestaj = trim($_POST["source"]);
			
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);
					
						if(mysqli_stmt_num_rows($stmt) > 0){
							if(!$enes){
								 $sql = "SELECT Datum_dolaska, Datum_odlaska FROM rezervacija WHERE Smještaj = ?";
									$stmt = $link->prepare($sql);
									$stmt->bind_param('s', $_POST["source"]);
									$stmt->execute();
									$result = $stmt->get_result();
								//  Provjera ima li rezultata
								if ($result->num_rows > 0) {
									echo '<div style="background:rgba(255,0,0,0.8); border-radius:15px; width:420px; color:white; font-size:18px; margin-right:50px; margin-bottom:50px; float:right;">';
									echo "<b>Vaši datumi za odabrani smještaj su zauzeti.<br> Molim Vas odaberite nove datume koji se ne nalaze među sljedećima:</b>";
									echo "<br /><br />";
									echo"<table>";
									// Printanje rezultata
									while($row = $result->fetch_assoc()) {
										echo "<tr>";
										echo "<td>" ."Datum dolaska:".$row["Datum_dolaska"]. "</td>";
										echo "<td>"."</td>";
										echo "<td>" . "Datum odlaska:".$row["Datum_odlaska"]. "</td>";
										echo "</tr>";
									}
									echo"</table>";
									echo'</div>';
								} else {
									echo "Nema rezultata";
								}
							}
					
						$datum_odlaska_err = "This date of departure is already taken.";
					}else{
						$datum_odlaska = trim($_POST["odlazak"]);
					}
				}else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			 
			// Close statement
			mysqli_stmt_close($stmt);
		}
		
		
		// Check input errors before inserting in database
		if(empty($username_err) && empty($smjestaj_err) && empty($br_gostiju_err) && empty($datum_dolaska_err) && empty($datum_odlaska_err)){
			
		
			
			// Prepare an insert statement
			$sql = "INSERT INTO `rezervacija` (Username, Smještaj, Broj_gosti, Datum_dolaska, Datum_odlaska) VALUES (?,?,?,?,?)";
			
			 
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, 'ssiss',$param_username, $param_smjestaj, $param_br_gostiju, $param_datum_dolaska, $param_datum_odlaska);
				
				
				// Set parameters
				$param_username = $username;
				$param_smjestaj = $smjestaj;
				$param_br_gostiju = $br_gostiju;
				$param_datum_dolaska = $datum_dolaska;
				$param_datum_odlaska = $datum_odlaska; 
				
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					// Redirect to login page
					echo '<script>
					alert ("Vaša rezervacija je zaprimljena");
					window.location = "rezervacija.php";
					</script>';
					//header("location: rezervacija.php");
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



