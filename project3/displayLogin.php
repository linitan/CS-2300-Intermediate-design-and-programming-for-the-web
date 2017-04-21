<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Album</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel = "stylesheet"  href = "css/style.css" type = "text/css">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=EB+Garamond">

</head>

<body>
  <?php require 'php/header.php';?>
  <?php
  		$post_username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
  		$post_password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
  		if ( empty( $post_username ) || empty( $post_password ) ) {
  		?>
        <div id="login">
  			<br><h3>Log in</h3>
  			<form action="displayLogin.php" method="post">
  				Username: <input class="loginInput" type="text" name="username"> <br>
  				Password: <input class="loginInput" type="password" name="password"> <br>
  				<input id="loginSubmit" type="submit" value="Submit">
  			</form>
        <div>

  		<?php
  		} else {
  			require_once 'php/config.php';
  			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  			if( $mysqli->connect_errno ) {
  				//uncomment the next line for debugging
  				echo "<p>$mysqli->connect_error<p>";
  				die( "Couldn't connect to database");
  			}
  			$query = "SELECT *
  						FROM users
  						WHERE
  							username = '$post_username'";

  			$result = $mysqli->query($query);

  			//Uncomment the next line for debugging
  			//echo "<pre>" . print_r( $mysqli, true) . "</p>";

  			//Make sure there is exactly one user with this username
  			if ( $result && $result->num_rows == 1) {

  				$row = $result->fetch_assoc();
  				//Debugging
  				//echo "<pre>" . print_r( $row, true) . "</p>";

  				$db_hash_password = $row['hashpassword'];

  				if( password_verify( $post_password, $db_hash_password ) ) {
  					$db_username = $row['username'];
  					$_SESSION['logged_user_by_sql'] = $db_username;
  				}
  			}

  			$mysqli->close();

  			if ( isset($_SESSION['logged_user_by_sql'] ) ) {
  				print("<p>Congratulations, $db_username. You have successfully logged in.<p>");
  			} else {
  				echo '<p>You did not login successfully.</p>';
  				echo '<p>Please <a href="displayLogin.php">try</a> again.</p>';
  			}

  		} //end if isset username and password
  		?>
  	</body>
  </html>


  </body>
</html>
