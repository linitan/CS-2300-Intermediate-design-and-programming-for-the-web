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

  <p>To add a new album, you must <a href='displayLogin.php'>log in</a> first.<br> The album coverpage
is credit to https://www.dreamstime.com/royalty-free-stock-images-cover-page-baby-album-image11956659</p>



  <!-- Initialize database connection -->
  <?php
  	require_once 'php/config.php';
  	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = $mysqli->query("SELECT * FROM Albums");
    while($row = $result->fetch_assoc()){
      print '<div id = "AlbumDisplay">';
      //Build the URL for modifying the row
      $album_id = $row['AlbumID'];
      $href = "displayImage.php?album_id=$album_id";
      print "<button id = 'album' >"."<a href='$href' title='$href'>".$row['Title']."</a>"."</button>";
      print '<br><div id = "caption">Modified:  '.$row['Date_modified'].'</div>';
      if (isset($_SESSION['logged_user_by_sql'])) {
        print '<div id = "edit"><a href="editAlbum.php?album_id='.$album_id.'">Edit</a></div>';
      }
      print '</div>';
    }
  ?>

  <?php
  if (isset($_SESSION['logged_user_by_sql'])) {
    print '<br>
    <button id="addAlbum" onclick="location.href = \'addAlbum.php\';">Add Album</button>';
  }

   ?>

  </body>
</html>
