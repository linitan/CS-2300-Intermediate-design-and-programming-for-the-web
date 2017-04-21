<?php session_start(); ?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Images</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel = "stylesheet"  href = "css/style.css" type = "text/css">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=EB+Garamond">

</head>

<body>
  <?php require 'php/header.php';?>
<?php
  require_once 'php/config.php';
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if ($mysqli->errno) {
    //The page isn't worth much without a db connection so display the error and quit
    print($mysqli->error);
    exit();
  }
  print'<p>if you want to edit the photo, please login.</p>';
  print '<br><h3>Images not in any album:</h3>';
  $result = $mysqli->query("SELECT * FROM Images WHERE ImageID NOT IN (SELECT ImageID FROM ImageWhere)");
  print '<div id="container">';
  print '<div class="wrap">';
  while($row = $result->fetch_assoc()){
    $image_id = $row['ImageID'];
    // if (isset($_SESSION['logged_user_by_sql'])) {
    //   print '<div id = "edit"><a href="editAlbum.php?album_id='.$album_id.'">Edit</a></div><br>';
    // }
    print '<div class="box">';
    print '<div class="boxInner">';
    print ('<img alt="" src="' . $row['File_path'] . '" style="width:400px;height:300px;" onclick="location.href = \'imageDetail.php?image_id='.$image_id.'\';">');
    if (isset($_SESSION['logged_user_by_sql'])) {
      print '<div class = "titleBox2"><a id="haha" href="editImage.php?image_id='.$image_id.'">Edit</a></div><br>';
    }
    // print ('<img alt="" src="' . $row['File_path'] . '" style="width:400px;height:300px;" onclick="location.href = \'imageDetail.php?image_id='.$image_id.'&album_id='.$album_id.'\';">');
    print '<div class="titleBox">'.$row['Title'].'</div>';
    print '</div>';
    print '</div>';
    // if (isset($_SESSION['logged_user_by_sql'])) {
    //   print '<div id = "edit"><a href="editAlbum.php?album_id='.$album_id.'">Edit</a></div>';
    // }
  }
  print '</div>';
  print '</div>';
  print '<br><br><h3>Images in album:</h3>';
  $result = $mysqli->query("SELECT * FROM Images WHERE ImageID IN (SELECT ImageID FROM ImageWhere)");
  print '<div id="container">';
  print '<div class="wrap">';
  while($row = $result->fetch_assoc()){
    $image_id = $row['ImageID'];
    // if (isset($_SESSION['logged_user_by_sql'])) {
    //   print '<div id = "edit"><a href="editAlbum.php?album_id='.$album_id.'">Edit</a></div><br>';
    // }
    print '<div class="box">';
    print '<div class="boxInner">';
    print ('<img alt="" src="' . $row['File_path'] . '" style="width:400px;height:300px;" onclick="location.href = \'imageDetail.php?image_id='.$image_id.'\';">');
    if (isset($_SESSION['logged_user_by_sql'])) {
      print '<div class = "titleBox2"><a id="haha" href="editImage.php?image_id='.$image_id.'">Edit</a></div><br>';
    }
    // print ('<img alt="" src="' . $row['File_path'] . '" style="width:400px;height:300px;" onclick="location.href = \'imageDetail.php?image_id='.$image_id.'&album_id='.$album_id.'\';">');
    print '<div class="titleBox">'.$row['Title'].'</div>';
    print '</div>';
    print '</div>';
    // if (isset($_SESSION['logged_user_by_sql'])) {
    //   print '<div id = "edit"><a href="editAlbum.php?album_id='.$album_id.'">Edit</a></div>';
    // }
  }
  print '</div>';
  print '</div>';
?>
  </body>
</html>
