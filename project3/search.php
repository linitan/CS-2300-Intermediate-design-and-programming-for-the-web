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
  <div id = "albumDisplay">
  <?php require 'php/header.php';?>

  <?php
require_once 'php/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//get search terms from GET
if (!empty($_GET['search'])) {
  if(!preg_match("/^[a-zA-Z]*$/", $_GET['search'])){
    print'<p>Only letters are allowed!</p>';
  }
  else{
    $search = htmlentities($_GET['search']);
    $result1 = $mysqli->query('SELECT * FROM Albums WHERE Title LIKE "%' . $search . '%" ');
    print '<br><h3>Albums Search Result:</h3>';
    //display albums
    while($row = $result1->fetch_assoc()){
      print '<div id = "AlbumDisplay">';
      //Build the URL for modifying the row
      $album_id = $row['AlbumID'];
      $href = "displayImage.php?album_id=$album_id";
      print "<button id = 'album' >"."<a href='$href' title='$href'>".$row['Title']."</a>"."</button>";
      print '<br><div id = "caption">Modified:  '.$row['Date_modified'].'</div>';
      print '</div>';
  }
   	$result2 = $mysqli->query('SELECT * FROM Images WHERE Title LIKE "%' . $search . '%" OR Caption LIKE "%' . $search . '%" OR Credit LIKE "%' . $search . '%"');
    print '<h3>Images Search Result:(If title or caption or credit satifiy the searching input)</h3>';
    print '<div id="container">';
    print '<div class="wrap">';
    while($row = $result2->fetch_assoc()){
      $image_id = $row['ImageID'];
      print '<div class="box">';
      print '<div class="boxInner">';
      print ('<img alt="" src="' . $row['File_path'] . '" style="width:400px;height:300px;" onclick="location.href = \'imageDetail.php?image_id='.$image_id.'\';">');
      print '<div class="titleBox">'.$row['Title'].'</div>';
      print '</div>';
      print '</div>';
    }
    print '</div>';
    print '</div>';
}
}
else{
  print'<p>Please enter what do you want to search!</p>';
}
?>
</div>
  </body>
</html>
