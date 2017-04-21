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

<?php
$album_id = filter_input( INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT );
require_once 'php/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$albums = $mysqli->query('SELECT * FROM Albums WHERE AlbumID ='.$album_id.';');
print'
<div id="uploadAlbum">
  <form action="" method="post" >
      <br><br><h2>Update album</h2>
      <br><br>Album Title:';
      while ($album = $albums->fetch_assoc()) {
      $title = $album['Title'];
      print'
      <input id="albumInput" type="text" name="title" value = "'.$title.'"><br>';
      print'Image you want to remove: <br>';
    }
    $images = $mysqli->query('SELECT * FROM Images INNER JOIN ImageWhere ON Images.ImageID = ImageWhere.ImageID WHERE AlbumID ='.$album_id.';');
    while ($image = $images->fetch_assoc()) {
      $imageTitle = $image['Title'];
    print'<input type="radio" name="ImageRemove" value="'.$imageTitle.'">'.$imageTitle.'<br>';
    }
    $images2 = $mysqli->query('SELECT DISTINCT Title FROM Images LEFT JOIN ImageWhere ON Images.ImageID = ImageWhere.ImageID WHERE ImageWhere.ImageID NOT IN (SELECT ImageID FROM ImageWhere WHERE AlbumID ='.$album_id.');');
    print'<br><br>Image you want to add:  <br>';
    while ($image2 = $images2->fetch_assoc()) {
      $imageTitle2 = $image2['Title'];
    print'<input type="radio" name="ImageAdd" value="'.$imageTitle2.'">'.$imageTitle2.'<br>';
    }
    print'<br><br>Album delete:  <br>';
    print'<input type="radio" name="ImageRemove" value="delete">Delete this album<br>';
    print'<input id ="albumSubmit" type="submit" name="submit" value="update">';

      if(isset($_POST['submit'])){
        if(!empty($_POST['ImageRemove'])){
        $remove = $_POST['ImageRemove'];
        if ($remove === "delete"){
          $delete = $mysqli->query('DELETE FROM ImageWhere WHERE AlbumID = "' . $album_id . '";');
          $delete2 = $mysqli->query('DELETE FROM Albums WHERE AlbumID = "' . $album_id . '";');
          echo '<script>window.location.href = "deleteSuccessfully.php";</script>';
        }
        $delete = $mysqli->query('DELETE FROM ImageWhere WHERE (SELECT ImageID FROM Images WHERE Title = "' . $remove . '") = ImageID AND AlbumID = "' . $album_id . '";');}
        if(!empty($_POST['ImageAdd'])){
        $add = $_POST['ImageAdd'];
        $imgIDs = $mysqli->query('SELECT ImageID FROM Images WHERE Title = "' . $add . '";');
        while ($image3 = $imgIDs->fetch_assoc()) {
          $imgID = $image3['ImageID'];}
        $groups = $mysqli->query("INSERT INTO ImageWhere ( ImageID, AlbumID ) VALUES ( $imgID , $album_id );");}
        // $addImage = $mysqli->query('DELETE FROM ImageWhere WHERE (SELECT ImageID FROM Images WHERE Title = "' . $add . '") = ImageID AND AlbumID = "' . $album_id . '";');}
        // if (isset($_POST['delete'])) {
        //   //update DB
        //   $delete = $mysqli->query('DELETE FROM ImageWhere WHERE Title = "' . $ . '";');
          if(!empty($_POST['title'])){
            if(!preg_match("/^[a-zA-Z]*$/", $_POST['title'])){
              print'<div id = "error">Only letters are allowed!</div>';
            }
            else{
              $title = htmlentities($_POST['title']);
              // Establish a new connection to the database
              $update = $mysqli->query('UPDATE Albums SET Title = "' . $title . '" WHERE AlbumID = "' . $album_id . '";');
              // $query4 = "UPDATE Albums SET Title = $title WHERE AlbumID = $album_id";
              // $update = $mysqli->query($query4);
              $update2 = $mysqli->query("UPDATE Albums SET Date_modified = CURRENT_TIMESTAMP WHERE AlbumID = $album_id");
              // echo "<script type='text/javascript'>max = max + 1;</script>";
              // $mysqli2->close();

              if ($update2 && $update) {

                echo '<script>window.location.href = "editAlbum.php?album_id='.$album_id.'";</script>';
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
