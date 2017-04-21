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
  <!-- Nar bar -->
  <div id="header">
  <nav id="nav">
    <ul>
      <li><a href="displayAlbum.php">Back</a></li>
    </ul>
  </nav>
  </div>

  <div id="uploadAlbum">
    <form action="" method="post" >
        <br><br><h2>Add an album</h2>
        <br><br>Album Title:
        <input id="albumInput" type="text" name="title"><br><br><br><br>
        <input id ="albumSubmit" type="submit" name="submit" value="create">
        <?php
        if(isset($_POST['submit'])){
            if(!empty($_POST['title'])){
              if(!preg_match("/^[a-zA-Z]*$/", $_POST['title'])){
                print'<div id = "error">Only letters are allowed!</div>';
              }
              else{
                $title = htmlentities($_POST['title']);
                // Establish a new connection to the database
                require_once 'php/config.php';
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $query4 = "INSERT INTO `Albums`(`Title`,`Date_created`,`Date_modified`) VALUES ('".$title."',NOW(),NOW())";
                $update = $mysqli->query($query4);
                echo "<script type='text/javascript'>max = max + 1;</script>";
                // $mysqli2->close();
                if ($update) {
                  echo "<p> new Album was successfully created. </p>";
                }
              }
            }
            else{
              print'<div id = "error">Title cannot be empty!</div>';
            }

        }
        ?>
  </form>
</div>

  </body>
</html>
