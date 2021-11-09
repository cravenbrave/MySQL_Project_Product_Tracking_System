<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<title>App information</title>
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
$appPurDate = $appsd = "";
$cusID = "";

//used to print dropdonw list
$sqlName = "select appName from app";
$resultName = mysqli_query($conn, $sqlName);

$sqlRel = "select Rel from app";
$resultRel = mysqli_query($conn, $sqlRel);
?>

<!-- print form -->
<h2>Application Order</h2>

<p><span class="error">* required field</span></p>
<p><span class="error">Only after all required field entered, the page can direct you to the next page. </span></p>

<form method="post" action="appResult.php">   
  App Name: 
  <select name="appName">
  <?php
    if (mysqli_num_rows($resultName) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultName)) { ?>
      <option value="<?= $row['appName']; ?>"><?= $row['appName']; ?></option>
    <?php }
    }
  ?>
  </select>
  <span class="error">* <?php echo $appNameErr;?></span>
  <br><br>

  App Release version:
  <select name="appRel">
  <?php
    if (mysqli_num_rows($resultRel) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($resultRel)) { ?>
      <option value="<?= $row['Rel']; ?>"><?= $row['Rel']; ?></option>
    <?php }
    }
  ?>
  </select>
  <span class="error">* <?php echo $appRelErr;?></span>
  <br><br>

  EOL: <input type="text" name="AEOL">
  <br><br>

  Purchase date: <input type="date" name="appPurDate">
   <span class="error">* <?php echo $appNameErr;?></span>
   <br><br>

  Support: <input type="date" name="asdl">
   <br><br>
  
  <input type="submit" name="submit" value="Submit"> 
  <input type="reset" name="reset" value="Reset">
</form>

<?php
$conn->close();
?>
</body>
</html>