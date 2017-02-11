<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Share you feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=EB+Garamond">

</head>

<body>
  <!-- Nar bar -->
  <div id="header">
  <nav id="nav">
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="la.html">Los Angeles</a></li>
      <li><a href="sd.html">San Deigo</a></li>
      <li><a href="carmel.html">Carmel</a></li>
      <li>Feedback</li>
    </ul>
  </nav>
  </div>

<?php
// define variables and set to empty values
  $nameErr = $commentErr = "";
  $name = $comment = $place = "";

//array:likeMost display everyone's favourite place.
  $likeMost = array();

//Conditional Clause
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
      $nameErr = "I want to know your name";
    } else {
      $name = inputJudge($_POST["name"]);
    // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
        }
    }
    if (empty($_POST["comment"])) {
      $commentErr = "Please give me some feedback";
    } else {
      $comment = inputJudge($_POST["comment"]);
    }

    $place = inputJudge($_POST["place"]);
    $likeMost[$name] = $place;
  }

//function
  function inputJudge($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<div id="container">
  <div id="title">
    <h2>GIVE ME SOME FEEDBACKS</h2>
    <img id="top_image" src="images/p5.png" alt="California NO.1 Road"><!-- p5.jpg are photoed by myself (Lini Tan)-->
    <p> My Journey come to the end. Thanks my friend Jack, Angela, Qiongyi and Cheng, It is you that make this journey more interesting.
    <p> If you like my introduction or want to share your road trip experience, please leave some words to me. Your message will be displayed in the following Message Board.</p>
  </div>
  <h2> Fill this form to leave some feedbacks</h2>

  <form method="post">
    <p>What is your name:       <input type="text" name="name" value="<?php echo $name;?>"></p>
    <?php echo $nameErr;?>
    <p>Which place you like most?
    <select name="place">
      <option value="Los Angeles">Los Angeles</option>
      <option value="San Deigo">San Deigo</option>
      <option value="carmel">Carmel</option>
    </select></p>
    <p>Please share something:<br> <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea></P>
    <?php echo $commentErr;?>
    <br>
    <input type="submit" name="submit" value="Submit">
  </form>


  <?php
//print the input
  echo "\t<h2>\n";
  echo "Message Board";
  echo "\t</h2>\n";;

// loop
  echo "<p>";
  foreach ($likeMost as $name=> $place) {
    echo "$name likes $place";
  }
  echo "<br>";
  echo $comment;
  echo "</p>";
  ?>

  </div><!-- div end of container-->
  <script src="scripts/image_cycle.js"></script>
  </body>
</html>
