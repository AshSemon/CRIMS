<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "jcrms";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection Error!!!!");
}
$caseid= $_POST['caseid'];
$casetype= $_POST['casetype'];
$accuser= $_POST['accuser'];
$defendent= $_POST['defendent'];
$accusation= $_POST['accusation'];
$detective= $_POST['detective'];
$archive= $_POST['archive'];
$added_on=date('Y-m-d h:i:s');

$sql = "insert into cases(caseid, casetype, accuser, defendent, accusation, investigated, assigned, status, added_on) values ('$caseid', '$casetype', '$accuser', '$defendent', '$accusation', '$detective', '$archive', 1, '$added_on',)";
$insert= mysqli_query($conn,$sql);
if(!$insert){
    echo "There is error!!";
}else{
    echo "data inserted!!";
}

?>