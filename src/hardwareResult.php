<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<title>Hardware information result</title>
<body>

<?php
// Create connection
$conn = new mysqli('localhost', 'root', 'mysql','covid');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// define variables and set to empty values
$mfErr = $modelErr = "";
$hardwarePurDateErr = $OSErr = "";

$cusID = "";
$machineID = $mf = $model = $vendor = $HEOL = $hardwarePurDate = "";

$sysNo =  $OS = $webServer = $javaV = $phpV = "";
$esd = NULL;
$purHardware ="no";

//print error massage when reqiured items are empty
if (empty($_POST["mf"])) {
$mfErr = "Manufacturer is reqiured";
} else {
$mf = test_input($_POST["mf"]);
}
if (empty($_POST["hardwarePurDate"])) {
$hardwarePurDateErr = "Hardware purchase date is required";
} else {
$hardwarePurDate = $_POST["hardwarePurDate"];
}
if (empty($_POST["OS"])) {
$OSErr = "OS is required";
} else {
$OS = test_input($_POST["OS"]);
}

if (empty($_POST["model"])) {
$modelErr = "Model is required";
} else {
$model = test_input($_POST["model"]);
}

if (empty($_POST["HEOL"])) {
$HEOL = NULL;
} else {
$HEOL = test_input($_POST["HEOL"]);
}

if (empty($_POST["vendor"])) {
$vendor = NULL;
} else {
$vendor = test_input($_POST["vendor"]);
}

if (empty($_POST["webServer"])) {
$webServer = NULL;
} else {
$webServer = test_input($_POST["webServer"]);
}

if (empty($_POST["javaV"])) {
$javaV = NULL;
} else {
$javaV = test_input($_POST["javaV"]);
}

if (empty($_POST["phpV"])) {
$phpV = NULL;
} else {
$phpV = test_input($_POST["phpV"]);
}
    

 //if cant't find machine ID, directs to error page
 if(!empty($_POST["mf"]) && !empty($_POST["model"])){
   $mf = $_POST["mf"];
   $model = $_POST["model"];
    $sql = "select machineID from hardware where manufacturer ='$mf' and model='$model'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $machineID = $row["machineID"];
      }
    } else {
        //if cant't find machine ID, directs to error page
        header('Location: http://localhost:8080/project-WenyiLiu/src/errorHardware.php');
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
<h2>Hardware Order information</h2>
<?php

//call indexResult.php cusID
session_start();
$cusID = $_SESSION['cusID'];

//show result only when reqiured item is not empty
if(!empty($_POST["mf"]) && !empty($_POST["model"]) && !empty($_POST["OS"]) && !empty($_POST["hardwarePurDate"]) && !empty($_POST["OS"])){

  //first get machineID
  $sql = "select machineID from hardware where manufacturer ='$mf' and model='$model'";
  $result = mysqli_query($conn, $sql);

  //if there is macineID
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      //get the machineID
      $machineID = $row["machineID"];
      echo "Machine ID is ".$row["machineID"] ."<br>";
    }

    //find max sysNo in cusenv
    $sql2 = "select Max(sysNo) as sm from cusenv where cusID = '$cusID'  group by cusID";
    $result2 = mysqli_query($conn, $sql2);
    
    //if there is a max sysNo and no same tuple exists: use OS to distinguish
    $sql3 = "select sysNo from cusenv where cusID = '$cusID' and machineID = '$machineID' and OS ='$OS'";
    $result3 = mysqli_query($conn, $sql3);  
    
    if (mysqli_num_rows($result2) > 0 && mysqli_num_rows($result3) == 0 ) {
        // create a new sysNo
        while($row2 = mysqli_fetch_assoc($result2)) {
          $sysNo = $row2["sm"];
          $sysNo ++;
        }

        //insert new customer env
        
        //if support date is null
        if (empty($_POST["esd"])) {
          //add null at support 
          $sql4 = "insert into cusenv values ('$cusID', '$sysNo','$machineID', '$hardwarePurDate', NULL, '$OS', '$webServer', '$javaV', '$phpV')";
        } else {
          //if support date is not null
          $esd = test_input($_POST["esd"]);
    
          //insert the date
          $sql4 = "insert into cusenv values ('$cusID', '$sysNo','$machineID', '$hardwarePurDate', '$esd', '$OS', '$webServer', '$javaV', '$phpV')";
        }
          
        //if inserted: report inserted
      if ($conn->query($sql4) === TRUE) {
          echo "New customer's server(s) information is added. <br>";
        }else {
          echo "Error creating database: " . $conn->error;
        }
        
    //if there is a max sysNo. and OS is already in the table, show error:
    } else if(mysqli_num_rows($result2) > 0 && mysqli_num_rows($result2) > 0 ){

      //if there is a max sysNo. and OS is already in the table, show error:
      echo "This record already exists, fails to add a new record.";
      
    //if there is a new customer  
    } else if(mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0 ){
      
      //if this is a new customer, insert new customer env
      //if support date is null
      if (empty($_POST["esd"])) {
        //add null at support 
        $sql4 = "insert into cusenv values ('$cusID', 1,'$machineID', '$hardwarePurDate', NULL, '$OS', '$webServer', '$javaV', '$phpV')";
      } else {
        //if support date is not null
        $esd = test_input($_POST["esd"]);

        //insert into cusenv
        $sql4 = "insert into cusenv values ('$cusID', 1,'$machineID', '$hardwarePurDate', '$esd', '$OS', '$webServer', '$javaV', '$phpV')";
      }

      //if inserted: report inserted
      if ($conn->query($sql4) === TRUE) {
          echo "New customer's server(s) information is added. <br>";
      }else {
          echo "Error creating database: " . $conn->error;
      }
    }
  }
}else{
  //if any reqiured item empty, head back to hardware.php 
  header("Location: http://localhost:8080/project-WenyiLiu/src/hardware.php");
}

?>

<!-- print options -->
<br><br>
 <form method="post" action="hardware.php"> 
  Back to last page for modification:
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

<form method="post" action="app.php"> 
  Add application purchase order: 
  <input type="submit" name="back" value="next"> 
</form>
<br>


<form method="post" action="index.php"> 
  Return to the Homepage:
  <input type="submit" name="back" value="back"> 
</form>


<?php
$conn->close();
?>
</body>
</html>