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
$mfErr = $modelErr = "";
$appNameErr = $appRelErr = "";
$appPurDateErr = $hardwarePurDateErr = $OSErr = "";

$cusID = $cusName = $contactName = $contactNo = "";
$machineID = $mf = $model = $vendor = $HEOL = $hardwarePurDate = "";
$appID = $appName = $appRel = $AEOL = "";
$sysNo = $envSupportDate = $OS = $webServer = $javaV = $phpV = "";

$purHardware ="no";

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
  Customer Name: 
  <select name="cusName">
  <?php
    if (mysqli_num_rows($resultName) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultName)) { ?>
      <option value="<?= $row['cusName']; ?>"><?= $row['cusName']; ?></option>
    <?php }
    }
  ?>
  <!-- true, I don't know how to add a new, I just try to make it feels like add a new lol -->
  <option value="New">New</option>
  </select>
  <span class="error">* <?php echo $cusNameErr;?></span>
  <br><br>

  Contact Name:
  <select name="contactName">
  <?php
    if (mysqli_num_rows($resultCName) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultCName)) { ?>
      <option value="<?= $row['contactName']; ?>"><?= $row['contactName']; ?></option>
    <?php }
    }
  ?>
  <option value="New">New</option>
  </select>
  <span class="error">* <?php echo $contactNameErr;?></span>
  <br><br>
  
  Contact Number:
  <select name="contactNo">
  <?php
    if (mysqli_num_rows($resultCNo) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultCNo)) { ?>
      <option value="<?= $row['contactNo']; ?>"><?= $row['contactNo']; ?></option>
    <?php }
    }
  ?>
   <option value="New">New</option>
  </select>
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