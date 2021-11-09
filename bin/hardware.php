<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<title>My first PHP</title>
<body>
<?php

//call indexResult.php cusID
  session_start();
  $cusID = $_SESSION['cusID'];

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
$sysNo = $envSupportDate = $OS = $webServer = $javaV = $phpV = "";


$sqlMf = "select manufacturer as mf from hardware";
$resultMf = mysqli_query($conn, $sqlMf);

$sqlMo = "select model from hardware";
$resultMo = mysqli_query($conn, $sqlMo);
?>

<h2>Hardware Order</h2>
<p><span class="error">* required field</span></p>
<p><span class="error">Only after all required field entered, the page can direct you to the next page. </span></p>
<form method="post" action="hardwareResult.php">   
  Manufacturer: 
  <select name="mf">
  <?php
    if (mysqli_num_rows($resultMf) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultMf)) { ?>
      <option value="<?= $row['mf']; ?>"><?= $row['mf']; ?></option>
    <?php }
    }
  ?>
  </select>
   <span class="error">*<?php echo $mfErr;?></span>
   <br><br>

  Model: 
  <select name="model">
  <?php
    if (mysqli_num_rows($resultMo) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultMo)) { ?>
      <option value="<?= $row['model']; ?>"><?= $row['model']; ?></option>
    <?php }
    }
  ?>
  </select>
   <span class="error">*<?php echo $modelErr;?></span>
   <br><br>

  Vendor: <input type="text" name="vendor">
  <br><br>

  EOL: <input type="text" name="HEOL">
  <br><br>
  
  Purchase Date: <input type="date" name="hardwarePurDate">
   <span class="error">*<?php echo $hardwarePurDateErr;?></span>
   <br><br>

  Support: <input type="date" name="esd">
  <br><br>

  OS: <input type="text" name="OS">
   <span class="error">*<?php echo $OSErr;?></span>
   <br><br>
 
  Web: <input type="text" name="webServer">
  <br><br>

  Jave version: <input type="text" name="javaV">
  <br><br>

  PHP version: <input type="text" name="phpV">
  <br><br>

  <input type="submit" name="submit" value="Submit"> 
  <input type="reset" name="reset" value="Reset">
</form>


<?php

$conn->close();
?>

</body>
</html>