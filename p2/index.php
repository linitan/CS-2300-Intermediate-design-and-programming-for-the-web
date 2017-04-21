<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Favourite Movie Catalog</title>
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

        <script>
    			function toggle(){
    				var addForm = document.getElementById("add");
    				if (addForm.style.display == "none")
    					addForm.style.display = "block";
    				else
    					addForm.style.display = "none";
    			}
          function toggle1(){
            var addForm = document.getElementById("check");
            if (addForm.style.display == "none")
              addForm.style.display = "block";
            else
              addForm.style.display = "none";
          }
    		</script>

    </head>

    <?php // check the vaild of input
       $titleErr = $typeErr = $directorErr = $reviewErr = "";
      if(isset($_POST["submit"])) {
        $title1 = $_POST['title'];
        $director1 = $_POST['director'];
        $type1 = $_POST['type'];
        $review1 = $_POST['review'];
        if(isset($title1) && preg_match("/^[a-zA-Z ]*$/", $title1)) {
            $title = $title1;
          }
            else {
                $titleErr= "Please enter a valid title";
              }
        }
        if(isset($director1) && preg_match("/^[a-zA-Z ]*$/", $director1)) {
                # Uncomment the below line when ready, and add the new player to the $players array
            $director = $director1;
          }
          else {
                $directorErr= "Please enter a valid director name";
              }

        if(isset($type1)) {
            $type = $type1;
          }
          else {
                $typeErr= "Please select a type";
              }
        if(isset($review1)) {
              $review= $review1;
                }
        else {
              $reviewErr= "Please leave some comment";
                }

      function inputJudge($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

      // put the form input into data file
      $delimiter = '-'; //set this in one place, don't hardcode it everywhere!

      if(isset($_POST['submit'])){
        $rawdata = file("data.txt");
        $duplicate="";
        foreach ($rawdata as $movie){
          $info = explode($delimiter, $movie);
          if((!empty($title))&&$title == $info[0] && $director == $info[1] && $type == $info[2]){
            $duplicate = "true";
          }else{$duplicate = "false";}
        }
          $file = fopen("data.txt", "a+");

          if (!$file) {
              die("There was a problem opening the data.txt file");
          }elseif($duplicate == "true"){echo "The same movie is already existed.";
          }elseif((empty($titleErr))&&(empty($directorErr))&&(empty($typeErr))&&(empty($reviewErr))&&($duplicate == "false")){
          fputs($file, "$title$delimiter$director$delimiter$type$delimiter$review\n");

          fclose($file);
        }
      }
    ?>

<body>
    <h1>My Favourite Movie Catalog</h1>

    <div id = "dropdown">
      <button id= "addmovie" onclick = "toggle()"><span>Add a movie</span></button>
      <button id = "sort" onclick = "toggle1()"><span>Search movie</span></button>
      <button onclick="sortTable()"><span>Sort table</span></button>
    </div>

    <!-- add movie form-->
    <form id = "add" style = "display: none" action="index.php" method="post">
      <p>Movie's title:       <input type="text" name="title" value=""></p>
      <?php echo $titleErr;?>
      <p>Director:       <input type="text" name="director" value=""></p>
      <?php echo $directorErr;?>
      <p>Type:
      <select class = "selectbox" name="type">
        <option value="Horror">Horror</option>
        <option value="Romance">Romance</option>
        <option value="Animation">Animation</option>
        <option value="Action">Action</option>
        <option value="science">Science Fiction</option>
        <option value="fiction">Fiction</option>
      </select></p>

      <p>Review:<br> <textarea name="review" rows="5" cols="40"></textarea></P>
      <?php echo $reviewErr;?>
      <br>
      <input type="submit" name="submit" value="Submit">
    </form>

    <!-- check movie form-->
    <form id = "check" style = "display: none" action = "index.php" method="post">
      <input type="submit" name="search" value="back to whole catalog"><br>
      <p>Movie's title:   <input type="text" name="titlecheck" value=""></p>
      <p>Director:       <input type="text" name="directorcheck" value=""></p>
      <p>Type:<br>
      <input type="checkbox" name="typecheck[]" value="Horror">Horror<br>
      <input type="checkbox" name="typecheck[]" value="Romance">Romance<br>
      <input type="checkbox" name="typecheck[]" value="Animation">Aninmation<br>
      <input type="checkbox" name="typecheck[]" value="Action">Action<br>
      <input type="checkbox" name="typecheck[]" value="science">Science Fiction<br>
      <input type="checkbox" name="typecheck[]" value="fiction">Fiction<br>
    </p>
      <br>
      <input type="submit" name="search" value="Search">
    </form>

    <!-- display data in this table-->
    <table id="display">
      <tr>
        <th>Title</th>
        <th>Director</th>
        <th>Type</th>
        <th>Review</th>
      </tr>
        <?php
        $titlecheck = $directorycheck = $typecheck = "";
        if(isset($_POST['search'])){
        $titlecheck = $_POST['titlecheck'];
        $directorycheck = $_POST['directorcheck'];
        if (isset($_POST['typecheck'])){
        $typecheck = $_POST['typecheck'];
      }
        }
        $titlecheck = inputJudge($titlecheck);
        $directorycheck = inputJudge($directorycheck);


      	$rawdata = file("data.txt");

      	foreach ($rawdata as $movie){
      		$info = explode($delimiter, $movie);
      		 if (isset($_POST['search'])){
             if ((empty($titlecheck))) {
               if((empty($directorycheck))){
                 if((empty($typecheck))){
              print"<tr>";
          	 	print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
              print"</tr>";
            }else{
              for ($i=0; $i<count($typecheck); $i++){
              if ($info[2] == $typecheck[$i]){
                print"<tr>";
            	 	print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
                print"</tr>";
              }
            }
            }
          }else{
            if((empty($typecheck))){
              if ($info[1] == $directorycheck){
                print"<tr>";
                print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
                print"</tr>";
              }
            } else {
              for ($i=0; $i<count($typecheck); $i++){
              if ($info[2] == $typecheck[$i] && $info[1] == $directorycheck){
                print"<tr>";
                print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
                print"</tr>";
              }
            }
            }
          }
        } else{
          if((empty($directorycheck))){
            if((empty($typecheck))){
              if($info[0] == $titlecheck){
                  print"<tr>";
                  print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
                  print"</tr>";
       }
       }else{
         for ($i=0; $i<count($typecheck); $i++){
           if ($info[2] == $typecheck[$i] && $info[0] == $titlecheck){
             print"<tr>";
             print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
             print"</tr>";
         }
       }
       }
     }else{
       if((empty($typecheck))){
         if ($info[1] == $directorycheck && $info[0] == $titlecheck){
           print"<tr>";
           print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
           print"</tr>";
         }
       } else {
         for ($i=0; $i<count($typecheck); $i++){
         if ($info[2] == $typecheck[$i] && $info[1] == $directorycheck && $info[0] == $titlecheck){
           print"<tr>";
           print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
           print"</tr>";
         }
       }
       }
     }
        }
      }else{
          print"<tr>";
      		print "<td>$info[0]</td><td>$info[1]</td><td>$info[2]</td><td>$info[3]</td>";
          print"</tr>";
        }
      	}
        ?>
    </table>


<script>
/*WOW element:sort table*/
  function sortTable() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("display");
    switching = true;
    while (switching) {
    switching = false;
    rows = table.getElementsByTagName("TR");
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        shouldSwitch= true;
        break;
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}
</script>

</body>
</html>
