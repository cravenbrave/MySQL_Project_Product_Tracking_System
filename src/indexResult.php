<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<title>Customer information result</title>
<body>

<?php
// Create connection
$conn = new mysqli('localhost', 'root', 'mysql','covid');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//print form 

// define variables and set to empty values
$cusNameErr = $contactNameErr = $contactNoErr = "";

$cusID = $cusName = $contactName = $contactNo = "";
?>


<h2>Customer Information</h2>

<?php
//only run when user enter cusName, contactName and contactNo
if(!empty($_POST["cusName"]) && !empty($_POST["contactName"]) && !empty($_POST["contactNo"])){
    
    //get those info, retrieve the data from sql
     $cusName = test_input($_POST["cusName"]);
     $contactName = test_input($_POST["contactName"]);
     $contactNo = test_input($_POST["contactNo"]);
     
     $sql = "select cusID, cusName,contactName, contactNo from customer where cusName='$cusName' and contactName='$contactName' and contactNo = '$contactNo'";
     $result = mysqli_query($conn, $sql);

     //if there is a cusID already exists
    if (mysqli_num_rows($result) > 0) {
        
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $cusID = $row["cusID"];
        $cusName = $row["cusName"];
        $contactName = $row["contactName"];
        $contactNo = $row["contactNo"];
        
        echo "Customer exists. <br>";
        echo "Customer ID is ".$row["cusID"] ."<br>";
        echo "Customer Name is ".$row["cusName"]."<br>";
        echo "Contact Name is " . $row["contactName"]." <br>";
        echo "Contact Number is " . $row["contactNo"]."<br>";
      } 
      
    } else {
      
        //if this is a new customer: create a new cusID
        $sql2 = "SELECT MAX(cusID) AS maxID FROM customer";
        $result = mysqli_query($conn, $sql2);
        
        while($row = mysqli_fetch_assoc($result)) {
          $cusID = 1+ $row["maxID"];
        }
    
        //and add new customer into the customer table
        $sql3 = "insert into customer values ('$cusID','$cusName','$contactName','$contactNo')";
    
        if ($conn->query($sql3) === TRUE) {
          echo "New customer is added: <br>";
        }else {
          echo "Error creating database: " . $conn->error;
        }
        
        //print the entered info
        echo "Customer ID is " .$cusID ."<br>";
        echo "Customer Name is ". $cusName ."<br>";
        echo "Contact Name is " . $contactName . " <br>";
        echo "Contact Number is " . $contactNo ."<br>";
    }
}

    

  //used for trim unwantted char
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//save cusID for gloal use
  session_start();
  $_SESSION['cusID'] = $cusID;
  
?>

<!-- print options -->
<br><br>
<form method="post" action="index.php"> 
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


<br><br>
Purchased a hardware?
<form method="post" action="hardware.php">  
<input type="submit" name="purHardware" value="yes"> 
</form>


<form method="post" action="app.php">  
<input type="submit" name="notPurHardware" value="no"> 
</form>

<?php
$conn->close();

//if user not enter all reqiured items, redirect to last home page
if(empty($_POST["cusName"]) || empty($_POST["contactName"]) || empty($_POST["contactNo"])){
  header("Location: http://localhost:8080/project-WenyiLiu/src/index.php");
}
?>

</body>
</html>