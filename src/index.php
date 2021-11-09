<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<title>Custormer Information</title>
<body>

<?php
// Create connection
$conn = new mysqli('localhost', 'root', 'mysql','covid');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// define variables and set to empty values
$cusNameErr = $contactNameErr = $contactNoErr = "";

$cusID = $cusName = $contactName = $contactNo = "";

//print error massage for reqiured item
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (empty($_POST["cusName"])) {
    $cusNameErr = "Customer name is required";
  } else {
    $cusName = test_input($_POST["cusName"]);
  }
  
  if (empty($_POST["contactName"])) {
    $contactNameErr = "Contact name is required";
  } else {
    $contactName = test_input($_POST["contactName"]);
  }
    
  if (empty($_POST["contactNo"])) {
    $contactNoErr = "Contact number is reqiured";
  } else {
    $contactNo = test_input($_POST["contactNo"]);
  }
}
  //used for trim unwantted char
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }

  //used to create dropdown list
  $sqlName = "select cusName from customer";
  $resultName = mysqli_query($conn, $sqlName);

  $sqlCName = "select contactName from customer";
  $resultCName = mysqli_query($conn, $sqlCName);

  $sqlCNo = "select contactNo from customer";
  $resultCNo = mysqli_query($conn, $sqlCNo);
?>

<h2>Customer information</h2>
<p><span class="error">* required field</span></p>
<p><span class="error">Only after all required field entered, the page can direct you to the next page. </span></p>
<form method="post" action="indexResult.php">   
  Customer Name: <input type="text" name="cusName">
  <span class="error">* <?php echo $cusNameErr;?></span>
  <br><br>

  Contact Name: <input type="text" name="contactName">
  <span class="error">* <?php echo $contactNameErr;?></span>
  <br><br>
  
  Contact Number: <input type="text" name="contactNo">
  <span class="error">* <?php echo $contactNoErr;?></span>
  <br><br>

  <input type="submit" name="submit" value="Submit"> 
  <input type="reset" name="reset" value="Reset">
</form>

<?php

$conn->close();
?>
</body>
</html>