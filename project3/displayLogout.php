<?php
	//Need to start a session in order to access it to be able to end it
	session_start();

	if (isset($_SESSION['logged_user_by_sql'])) {
		$olduser = $_SESSION['logged_user_by_sql'];
		unset($_SESSION['logged_user_by_sql']);
	} else {
		$olduser = false;
	}
?>
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
			//echo '<pre>' . print_r( $_SESSION, true ) . '</pre>';
			if ( $olduser ) {
				print("<p>Thanks for using our page, $olduser!</p>");
				print("<p>Return to our <a href='displayLogin.php'>login page</a></p>");
			} else {
				print("<p>You haven't logged in.</p>");
				print("<p>Go to our <a href='displayLogin.php'>login page</a></p>");
			}
		?>
	</body>
</html>
