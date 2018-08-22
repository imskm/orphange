<?php
session_start();

require_once('../../includes/helpers.php');

// Page processing code
//////////////////////////////////
// On Page Load process
// fetching user details
// and other mandatory details
/////////////////////////////////

$username = $_SESSION["username"];
$userid = $_SESSION["userid"];
$usertype = $_SESSION["usertype"];


$sql = sprintf("SELECT FName, LName, Photo FROM adopter WHERE AdopId=%s", $userid);

$conn = connect_db();
if(!$conn) { die("Connetion failed - " . mysqli_connect_error($conn)); }

$rs = mysqli_query($conn, $sql);
if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

if(mysqli_num_rows($rs) > 0)
{
	if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
	{
		$fname = $row["FName"];
		$lname = $row["LName"];
		$_SESSION["photo"] = $row["Photo"];
	}
}
else
{
	header('Location: /login.php');
	exit;
}

$_SESSION["fullname"] = $fname . " " . $lname;
$_SESSION["fname"] = $fname;

header('Location: ./');

?>
