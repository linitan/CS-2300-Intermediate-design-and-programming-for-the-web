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
  <?php require 'php/header.php' ?>
  <?php require_once 'php/config.php';
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  $albums = $mysqli->query('SELECT Title FROM Albums;'); ?>
  <?php
  if (isset($_SESSION['logged_user_by_sql'])) {
    print'
    <div id="uploadPhoto">
        <form action="" method="post" enctype="multipart/form-data">
        <br><br><br><br><h2>Photo upload</h2>
        Title: <input class="photoInput" type="text" name="title"><br><br>
        Caption: <input class="photoInput" type="text" name="caption"><br><br>
        Credit: <input class="photoInput" type="text" name="credit"><br><br>
        Photo:
        <input id="new-photo" type="file" name="newphoto"><br><br>
        Choose the album which you want to put in (leave it blank if you don\'t want to put in any of it):';
            while ($album = $albums->fetch_assoc()) {
  		      $title = $album['Title'];
  		    echo '<div class="checkbox"><input type="checkbox" name="albums[]" value="' . $album['Title'] . '"> ' . $title . '<div>';
  	     }
         print'
        <input id="photoSubmit" type="submit" name="submit">';
  } else {
    print "<p>You haven't logged in.</p>";
    print "<p>Go to our <a href='displayLogin.php'>login page</a></p>";
  }
  ?>


  <?php
      /* For simplicity's sake, this PHP code ignores many elements you'll need to take into consideration
       * for your final version of Project 3.
       */
      if(isset($_POST['submit'])){
        if(!empty($_POST['title'])){
          if(!preg_match("/^[a-zA-Z]*$/", $_POST['title'])){
            print'<div id = "error">Only letters are allowed!</div>';
          }
          else{
            if(!empty($_POST['caption'])){
              if(!empty($_POST['credit'])){
                if(!preg_match("/^[a-zA-Z\s]+$/", $_POST['credit'])){
                  print'<div id = "error">Only letters are allowed!</div>';
                }
                else{
                  if ( ! empty( $_FILES['newphoto'] ) ) {
                        $caption = htmlentities($_POST['caption']);
                        $credit = htmlentities($_POST['credit']);
                        $title = htmlentities($_POST['title']);
				                $newPhoto = $_FILES['newphoto'];
				                $originalName = $newPhoto['name'];
                        $path = "images/".$originalName;
				                if ( $newPhoto['error'] == 0 ) {
					              $tempName = $newPhoto['tmp_name'];
					               move_uploaded_file( $tempName, "images/$originalName");
					               $_SESSION['photos'][] = $originalName;
					                print("<p>The file $originalName was uploaded successfully.</p>");

                          require_once 'php/config.php';
                          $mysqli2 = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                          $query4 = "INSERT INTO `Images`(`Title`,`Caption`,`File_path`,`Credit`) VALUES ('".$title."','".$caption."','".$path."','".$credit."')";
                          $mysqli2->query($query4);
                          echo "<script type='text/javascript'>max = max + 1;</script>";
                          $mysqli2->close();

                          $query = $mysqli->query("SELECT MAX(ImageID) FROM Images");
				                  $results = $query->fetch_row();
				                  $imgID = $results[0];

                          if (!empty($_POST['albums'])){
                            $albums = $_POST['albums'];
                            // Insert album_id and photo_id into PhotoInAlbum
                            foreach ($albums as $album) {
                              $query = $mysqli->query('SELECT AlbumID FROM Albums WHERE Title = "' . $album . '";');
                              $albumID = $query->fetch_row();
                              $albumID = $albumID[0];
                              $update = $mysqli->query("UPDATE Albums SET Date_modified = CURRENT_TIMESTAMP WHERE AlbumID = $albumID");
                              if ($update) {
                                echo "<p> Album $albumID successfully updated. </p>";
                              }
                              $groups = $mysqli->query("INSERT INTO ImageWhere ( ImageID, AlbumID ) VALUES ( $imgID , $albumID );");
                            }
                          }

				                   } else {
					                        print("<p>Error: The file $originalName was not uploaded.</p>");
				                            }
			                     }
                  }
                }
              else{
                  print '<div id = "error">Please enter who should be credit to</div>';
              }
            }
            else {
              print '<div id = "error">Please leave some happy captions^_^</div>';
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
