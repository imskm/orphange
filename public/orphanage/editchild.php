<?php
session_start();
/*************************************
* Including helpers.php file
* It has render function
* to render the header and footer
* file.
**************************************/
//Error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once('../../includes/helpers.php');
require_once('../../includes/modules.php');

// Redirecting if user is not logged in
if (!isset($_SESSION["username"])) {
    header('Location: http://' . htmlspecialchars($_SERVER["HTTP_HOST"]));
    exit;
}
// Redirecting if user child id is not given
if (!isset($_GET["chid"])) {
    header('Location: addchild.php');
    exit;
}

?>

<?php
///////////////////////////////////
// Fetching child details
///////////////////////////////////
$conn = connect_db();
$chid = $_GET["chid"];
$sql = sprintf("SELECT ChId, FName, LName, Dob, Gender, Colour, RegOn, Photo FROM godchild WHERE ChId=%s",
		mysqli_real_escape_string($conn, $chid));

$rs = mysqli_query($conn, $sql);
if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

if(mysqli_num_rows($rs) > 0)
{
	if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
	{
		$_SESSION["chid"] = $row["ChId"];
		$fname = $row["FName"];
		$lname = $row["LName"];
		$dob = $row["Dob"];
		$gender = $row["Gender"];
		$colour = $row["Colour"];
		$oldphoto = $row["Photo"];

	}
}
else
{
	$_SESSION["msg"] = '<p>No child found for the given child id. <a class="close">&#x2716;</a></p>';
	header('Location: godschild.php?alert=notice');
	exit;
}

if(isset($_POST["updatechild"]) && $_POST["updatechild"] == "Update")
{
	///////////////////////////////////
	// STEP 1: Validating form data
	///////////////////////////////////
	$errors = "";
    if(!isset($_POST["fname"]) || empty($_POST["fname"])) { $errors = '<p><span class="mandatory">*</span> marked fields are mandatory.</p>'; }
    if(!isset($_POST["lname"]) || empty($_POST["lname"])) { $errors = '<p><span class="mandatory">*</span> marked fields are mandatory.</p>'; }
    if(!isset($_POST["dob"]) || empty($_POST["dob"])) { $errors = '<p><span class="mandatory">*</span> marked fields are mandatory.</p>'; }

	// Validating photo field
	if(isset($_FILES["photo"]) && !empty($_FILES["photo"]["name"]))
	{
		if($_FILES["photo"]["type"] != "image/jpeg")
			if($_FILES["photo"]["type"] != "image/png")
				$errors = '<p>Please upload a jpeg or png file.</p>';

		if(intval($_FILES["photo"]["size"]) > 51200)
			$errors .= '<p>Image size is large, please upload an image below 50kb.</p>';
	}


	if(empty($errors))
	{
		$conn = connect_db();

		$chid		= validate_form_data($conn, $_POST["chid"]);
		$fname		= validate_form_data($conn, $_POST["fname"]);
		$lname		= validate_form_data($conn, $_POST["lname"]);
		$dob		= validate_form_data($conn, $_POST["dob"]);
		$age		= date_diff_year(date('Ymd'), $dob);
		$gender		= validate_form_data($conn, $_POST["gender"]);

		// not mandatory field
		if(isset($_POST["colour"]) && $_POST["colour"] != "") { $colour = validate_form_data($conn, $_POST["colour"]); } else { $colour = ""; }

		// Casing user details
		$fname = ucwords(strtolower($fname));
		$lname = ucwords(strtolower($lname));

		///////////////////////////////////
		// Step 1: Uploading image
		//		if new image is uploaded
		///////////////////////////////////
		if(isset($_FILES["photo"]["name"]) && !empty($_FILES["photo"]["name"]))
		{
			$fName = "photo";	// file input element name sent from browser
			$upfName = date("Ymdhis") . '_' . time();
			$fPath = "../assets/img/godschild/";
			if($_FILES["photo"]["type"] == "image/jpeg")
				$ext = "jpg";
			if($_FILES["photo"]["type"] == "image/png")
				$ext = "png";

			$photo = "/assets/img/godschild/" . $upfName . "." . $ext;	// name of the uploaded file
			$isUploaded = upload_file($fName, $upfName, $fPath, $ext);
		}

		///////////////////////////////////
		// Step 2: Inserting user
		//   child info in table
		///////////////////////////////////

		//print_r($_FILES["photo"]);
		//exit;
		// Case 1: if image is not updated
		if(isset($_FILES["photo"]["name"]) && empty($_FILES["photo"]["name"]))
		{
			$sql = sprintf("UPDATE godchild SET FName='%s', LName='%s', Dob='%s', Gender=%s, Age=%s, Colour='%s' WHERE ChId=%s",
				$fname, $lname, $dob, $gender, $age, $colour, $chid);
		}
		else if(isset($isUploaded) && $isUploaded)
		{
			// if new image is uploaded then update photo field also else skip it
			$sql = sprintf("UPDATE godchild SET FName='%s', LName='%s', Dob='%s', Gender=%s, Age=%s, Colour='%s', Photo='%s' WHERE ChId=%s",
				$fname, $lname, $dob, $gender, $age, $colour, $photo, $chid);
		}
		else if(isset($isUploaded) && !$isUploaded)
		{
			$errors = '<p>Sorry! Image upload failed. Please try again.</p>';
		}

		if(empty($errors))
		{
			$rs = mysqli_query($conn, $sql);
	    	if(!$rs) { die("Query failed - " . mysqli_error($conn)); }
			else
			{
				$_SESSION["msg"] = '<p>Child updated successfully!</p>';
				header('Location: godschild.php?alert=success');
			}
		}

		// Closing Connection
		mysqli_close($conn);
	}
}

if(isset($_POST["delconfirm"]) && $_POST["delconfirm"] == "Yes! Delete")
{
	$conn = connect_db();
	$chid = mysqli_real_escape_string($conn, $_POST["chid"]);
	$sql = sprintf("DELETE FROM godchild WHERE ChId=%s", $chid);
	if(mysqli_query($conn, $sql))
	{
		$_SESSION["msg"] = '<p>Child deleted successfully</p>';
		header('Location: godschild.php?alert=success');
	}
	else
	{
		$errors .= '<p>Child can not be delted! try again.</p>';
	}

}


?>


<?php
/*************************************
* Render Dashboard header
* @param array $data
**************************************/
render('dashheader', array('title' => $_SESSION["orgname"], 'levelup' => '2'));

?>

<div class="row dashboard clearfix">

<?php
/*************************************
* Render Dashboard Sidebar
* @param array $data
**************************************/
render('dashsidebar', array('levelup' => '2', 'orgname' => $_SESSION["orgname"], 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'godschild'));
?>


<div class="col-w-10 dash-main">
	<div class="dash-header clearfix">
		<div class="col-w-11 dash-container"><h3 style="line-height: 60px;margin-left: 50px; color: #333;">Dashboard</h3></div>
		<div class="col-w-1"><a href="./logout.php" class="btn btn-logout" style="margin-top: 15px;">Logout</a></div>
	</div>

	<div class="dash-body">
		<div class="row">
			<div class="col-w-8" style="float: none !important; margin: 0 auto;">
				<h1 style="font-family: 'Roboto regular'; font-size: 1.5em;">Update Child</h1>
				<div class="row">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?chid=' . $_SESSION["chid"]; ?>" method="POST" class="form-controls" enctype="multipart/form-data">
					<br>
					<?php
						// Notice
						if(!empty($errors))
							echo '<div class="actNotify-red">' . $errors . '</div>';

						if(isset($_GET["alert"]) && $_GET["alert"] == "success")
						{
							echo '<div class="actNotify-green"><p>Child added successfull!</p></div>';
						}
						if(isset($_POST["delete"]) && $_POST["delete"] == "Delete")
						{
							echo '<div class="actNotify-red btn-danger">
								<p>Are you sure you want to delete?</p>
								<p><input type="submit" name="delconfirm" value="Yes! Delete" class="btn txt-light btn-danger"> <a href="" class="btn btn-sm accent-primary">Oops! No</a></p>
							</div>';
						}
					?>
						<div class="row form-controls-row">
							<p style="font-family: 'Roboto light'; font-size: 12px; color: #dd0000;"><em>Note</em> : <span class="mandatory">*</span> marked fields are mandatory.</p>
						</div>
						<br />

						<div class="row form-controls-row">
							<label for="fname">Enter name: <span class="mandatory">*</span></label>
							<input type="text" id="fname" name="fname" placeholder="Your first name" value="<?php if(isset($fname)) echo htmlspecialchars($fname); ?>" style="width: 172px !important;">
							<input type="text" id="lname" name="lname" placeholder="Your last name" value="<?php if(isset($lname)) echo htmlspecialchars($lname); ?>" style="width: 172px !important;">

							<input type="hidden" name="chid" value="<?php if(isset($_SESSION["chid"])) echo htmlspecialchars($_SESSION["chid"]); ?>">
						</div>

						<div class="row form-controls-row">
							<label for="dob">Date of birth: <span class="mandatory">*</span></label>
							<input type="text" id="dob" name="dob" placeholder="Date of birth (e.g. yyyy-mm-dd)" value="<?php if(isset($dob)) echo htmlspecialchars($dob); ?>">
						</div>
						<div class="row form-controls-row">
							<label for="gender">Gender: <span class="mandatory">*</span></label>
							<?php
								if(isset($gender) && $gender == 1)
								{
									echo '<input type="radio" id="male" name="gender" value="1" checked="checked"> <sapn class="txt-dark">Male </span>';
									echo '<input type="radio" id="female" name="gender" value="2"> <sapn class="txt-dark">Female</span>';

								}
								else if(isset($gender) && $gender == 2)
								{
									echo '<input type="radio" id="male" name="gender" value="1"> <sapn class="txt-dark">Male </span>';
									echo '<input type="radio" id="female" name="gender" value="2" checked="checked"> <sapn class="txt-dark">Female</span>';

								}
							?>
						</div>
						<div class="row form-controls-row">
							<label for="colour">Enter Colour:</label>
							<input type="text" id="colour" name="colour" placeholder="Colour of child (e.g. fair)" value="<?php if(isset($colour)) echo htmlspecialchars($colour); ?>">
						</div>

						<br />
						<div class="row form-controls-row">
							<label>Image of child:<span class="mandatory">*</span></label>
							<div class="upload-img img-thumbnail" style="background-image: url('<?php if(isset($oldphoto)) echo htmlspecialchars($oldphoto); ?>'); width: 150px;"></div>
						</div>
						<br />
						<div class="row form-controls-row">
							<label>Upload new image of child:</label>
							<input type="file" id="photo" name="photo" value="">
						</div>

						<br />
						<div class="row form-controls-btnrow clearfix">
							<input type="submit" name="delete" value="Delete" class="btn txt-light btn-danger" style="float: left">
							<a href="godschild.php"><input type="button" value="Cancel" class="btn txt-dark" style="float: right;"></a>
							<input type="submit" name="updatechild" value="Update" class="btn txt-light btn-success" style="float: right; margin-right: 10px;">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>




</div>
<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer', array('levelup' => '2'))
?>
