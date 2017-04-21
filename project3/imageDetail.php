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
  <<?php
  //Try to get the movie_id from a URL parameter
  $image_id = filter_input( INPUT_GET, 'image_id', FILTER_SANITIZE_NUMBER_INT );
  ?>
  <!-- Nar bar -->
  <?php require 'php/header.php';?>
  <<?php
  require_once 'php/config.php';
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if ($mysqli->errno) {
    //The page isn't worth much without a db connection so display the error and quit
    print($mysqli->error);
    exit();
  }
  $result = $mysqli->query("SELECT * FROM Images WHERE ImageID = $image_id");
  $result2 = $mysqli->query("SELECT * FROM Albums INNER JOIN ImageWhere ON Albums.AlbumID = ImageWhere.AlbumId WHERE ImageID = $image_id");
  // print $result2;
  if ($result2->num_rows > 0){
  print '<div id="imageDetail">';
  // $album_id = filter_input( INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT );
  // print '<br><br><a href="displayImage.php?album_id='.$album_id.'">Back</a>';
  while($row1 = $result2->fetch_assoc()){
    $album_id = $row1['AlbumID'];
    print '<h3>This image is in Album <a href="displayImage.php?album_id='.$album_id.'">'.$row1['Title'].'.</a></h3>';
  }
  while($row = $result->fetch_assoc()){
    print '<h3>Title: '.$row['Title'].'</h3>';
    print '<h3>Caption: '.$row['Caption'].'</h3>';
    print '<h3>Credit: '.$row['Credit'].'</h3>';
    print ('<img alt="" src="' . $row['File_path'] . '">');
  }
  print '</div>';
}
else{
  print '<h3>This image is not in any album.</h3>';
  while($row = $result->fetch_assoc()){
    print '<h3>Title: '.$row['Title'].'</h3>';
    print '<h3>Caption: '.$row['Caption'].'</h3>';
    print '<h3>Credit: '.$row['Credit'].'</h3>';
    print ('<img alt="" src="' . $row['File_path'] . '">');
  }
  print '</div>';
}

   ?>
  </body>
</html>
