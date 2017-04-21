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
  <!-- <div id="header">
  <nav id="nav">
    <ul>
      <li><a href="displayImage.php">Back</a></li>
    </ul>
  </nav>
  </div> -->
  <?php require 'php/header.php';?>

<?php
$image_id = filter_input( INPUT_GET, 'image_id', FILTER_SANITIZE_NUMBER_INT );
require_once 'php/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$images = $mysqli->query('SELECT * FROM Images WHERE ImageID ='.$image_id.';');
print'
<div id="uploadAlbum">
  <form action="" method="post" >
      <br><br><h2>Update Photo</h2>
      <br>Image Title:';
      while ($image = $images->fetch_assoc()) {
      $title = $image['Title'];
      $caption = $image['Caption'];
      $credit = $image['Credit'];
      print'
      <input id="albumInput" type="text" name="title" value = "'.$title.'"><br>';
      print'<br>Image Caption:';
      print'
      <input id="albumInput" type="text" name="caption" value = "'.$caption.'"><br>';
      print'<br>Image Credit:';
      print'
      <input id="albumInput" type="text" name="credit" value = "'.$credit.'"><br>';
    }
    $albums = $mysqli->query('SELECT DISTINCT Title FROM Albums INNER JOIN ImageWhere ON Albums.AlbumID = ImageWhere.AlbumID WHERE ImageID ='.$image_id.';');
    print'<br>Remove image from album: <br>';
    while ($album = $albums->fetch_assoc()) {
      $albumTitle = $album['Title'];
    print'<input type="radio" name="ImageRemove" value="'.$albumTitle.'">'.$albumTitle.'<br>';
    }
    print'<input type="radio" name="ImageRemove" value="delete">complete delete<br>';
    $images2 = $mysqli->query('SELECT DISTINCT * FROM Albums WHERE AlbumID NOT IN (SELECT AlbumID FROM ImageWhere WHERE ImageID ='.$image_id.');');
    print'<br>Add image to album:  <br>';
    while ($image2 = $images2->fetch_assoc()) {
      $imageTitle2 = $image2['Title'];
    echo '<div class="checkbox"><input type="checkbox" name="albums[]" value="' . $imageTitle2 . '"> ' . $imageTitle2 . '<div>';
    }
    print'<input id ="albumSubmit" type="submit" name="submit" value="update">';

    if(isset($_POST['submit'])){
      if(!empty($_POST['title'])){
        if(!preg_match("/^[a-zA-Z\s]+$/", $_POST['title'])){
          print'<div id = "error">Only letters are allowed in title!</div>';
        }
        else{
          if(!empty($_POST['caption'])){
            if(!empty($_POST['credit'])){
              if(!preg_match("/^[a-zA-Z\s]+$/", $_POST['credit'])){
                print'<div id = "error">Only letters are allowed in credit!</div>';
              }
              else{
                      $caption = htmlentities($_POST['caption']);
                      $credit = htmlentities($_POST['credit']);
                      $title = htmlentities($_POST['title']);
                      $updateTitle = $mysqli->query('UPDATE Images SET Title = "' . $title . '" WHERE ImageID = "' . $image_id . '";');
                      $updateCredit = $mysqli->query('UPDATE Images SET Credit = "' . $credit . '" WHERE ImageID = "' . $image_id . '";');
                      $updateCaption = $mysqli->query('UPDATE Images SET Caption = "' . $caption. '" WHERE ImageID = "' . $image_id . '";');
                      if(!empty($_POST['ImageRemove'])){
                        $remove = $_POST['ImageRemove'];
                        if ($remove === "delete"){
                          $delete = $mysqli->query('DELETE FROM ImageWhere WHERE ImageID = "' . $image_id . '";');
                          $delete2 = $mysqli->query('DELETE FROM Images WHERE ImageID = "' . $image_id . '";');
                          echo '<script>window.location.href = "deleteSuccessfully.php";</script>';
                        }else{
                          $delete = $mysqli->query('DELETE FROM ImageWhere WHERE (SELECT AlbumID FROM Albums WHERE Title = "' . $remove . '") = AlbumID AND ImageID = "' . $image_id . '";');
                        }
                        }
                        if (!empty($_POST['albums'])){
                          $albums = $_POST['albums'];
                          // Insert album_id and photo_id into PhotoInAlbum
                          foreach ($albums as $album) {
                            $query = $mysqli->query('SELECT AlbumID FROM Albums WHERE Title = "' . $album . '";');
                            $albumID = $query->fetch_row();
                            $albumID = $albumID[0];
                            $update = $mysqli->query("UPDATE Albums SET Date_modified = CURRENT_TIMESTAMP WHERE AlbumID = $albumID");
                            $groups = $mysqli->query("INSERT INTO ImageWhere ( ImageID, AlbumID ) VALUES ( $image_id , $albumID );");
                          }
                        }
                        echo '<script>window.location.href = "editImage.php?image_id='.$image_id.'";</script>';
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
