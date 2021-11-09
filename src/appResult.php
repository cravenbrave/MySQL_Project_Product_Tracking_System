<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<title>App information result</title>
<body>

<?php
// Create connection
$conn = new mysqli('localhost', 'root', 'mysql','covid');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// define variables and set to empty values
$appNameErr = $appRelErr = "";

$appID = $appName = $appRel = $AEOL = "";
$appPurDate = $asd = "";
$cusID = "";

//print error massage for reqiured item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST["appName"])) {
    $appNameErr = "Application name is required";
  } else {
    $appName = test_input($_POST["appName"]);
  }

  if (empty($_POST["appRel"])) {
    $appRelErr = "Application release version is required";
  } else {
    $appRel = $_POST["appRel"];
  }
  
  if (empty($_POST["appPurDate"])) {
    $appPurDateErr = "Application purchase date is reqiured";
  } else {
    $appPurDate = $_POST["appPurDate"];
  }

  if (empty($_POST["AEOL"])) {
    $AEOL = NULL;
  } else {
    $AEOL = test_input($_POST["AEOL"]);
  }

    if (empty($_POST["asd"])) {
    $asd = NULL;
  } else {
    $asd = $_POST["asd"];
  }

}

 //if cant't find app ID, directs to error page
 if(!empty($_POST["appName"]) && !empty($_POST["appRel"])){
   $appName = $_POST["appName"];
   $appRel = $_POST["appRel"];

   $sql = "select appID from app where appName ='$appName' and Rel ='$appRel'";
   $result = mysqli_query($conn, $sql);
   if (mysqli_num_rows($result) > 0) {
     // output data of each row
     while($row = mysqli_fetch_assoc($result)) {
       $appID = $row["appID"];
    }
   } else {
      //if cant't find app ID, directs to error page
      header('Location: http://localhost:8080/project-WenyiLiu/src/errorApp.php');
   }
 }

  //used for trim unwantted char
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<!-- print result -->
<h2>Application Order Information</h2>

<?php
//call indexResult.php cusID
session_start();
$cusID = $_SESSION['cusID'];

//only run when all reqiured item entered
if(!empty($_POST["appName"]) && !empty($_POST["appRel"]) && !empty($_POST["appPurDate"])){
    
    //first use cusID and appID to identify a tuple
    $sql2 = "select support from cusapp where cusID='$cusID' and appID='$appID'";
    $result2 = mysqli_query($conn, $sql2);

    //if the order exists, report error
    if (mysqli_num_rows($result2) > 0) {
      echo "This record already exists, fails to add a new record.";
      
    } else {
        //if the order not exists, insert new customer app info
        //if support date is null
        if (empty($_POST["asd"])) {
          //add null at support 
          $sql3 = "insert into cusapp values ('$cusID', '$appID', '$appPurDate',NULL)";
        } else {
          //if support date is not null
          $asd = test_input($_POST["asd"]);
          $sql3 = "insert into cusapp values ('$cusID', '$appID', '$appPurDate','$asd')";
        }
      
        //if inserted, report inserted 
        if ($conn->query($sql3) === TRUE) {
          echo "New customer's application purchased information is added. <br>";
        }else {
          //if there is a error, report error
          echo "Error creating database: " . $conn->error;
        }
    }

//if any reqiured items are empty, redirect to last page
}else{
    
  header('Location: http://localhost:8080/project-WenyiLiu/src/app.php');
}

$conn->close();
?>

<!-- print options -->

<br><br>
<form method="post" action="app.php"> 
  Back to App page for modification or add a new order information:
  <input type="submit" name="back" value="back">
  <span class="error">
  <br>
  Note: if you successfully added a new record to the database, return will NOT delete
  that record. 
  <br>
  If there is a error, back to next page for modification, the wrong record is not added. 
  </span>
</form>


<br>
<form method="post" action="index.php"> 
  Return to the Homepage:
  <input type="submit" name="back" value="back"> 
</form>
</body>
</html>