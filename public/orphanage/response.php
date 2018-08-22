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

// Redirecting if user is not logged in
if (!isset($_SESSION["username"])) {
    header('Location: http://' . htmlspecialchars($_SERVER["HTTP_HOST"]));
    exit;
}

?>

<?php
// Page processing code
//////////////////////////////////
// On Page Load process
// fetching adopter details
// and other mandatory details
/////////////////////////////////

// Redirecting the user if page is not accessed properly
//if(!isset($_POST["aid"]) || !isset($_POST["appid"]))
//{
//	if(isset($_SERVER["HTTP_REFERER"]))
//		header('Location: ' . htmlspecialchars($_SERVER["HTTP_REFERER"]));
//	else
//		header('Location: appointments.php');
//}


// If Accept button is clicked
if(isset($_POST["accept"]) && $_POST["accept"] == "Submit")
{
	$conn = connect_db();
	$isSearch = true;

	// Input sanitization
	$aid = validate_form_data($conn, $_POST["aid"]);
	$appid = validate_form_data($conn, $_POST["appid"]);
	$doa = validate_form_data($conn, $_POST["doa"]);
	$toa = validate_form_data($conn, $_POST["toa"]);

	// Validation
	$errors = "";
	if(strlen($doa) == 0)
		$errors = '<p>Please provide a valid date of appointment.</p>';
	if(strlen($toa) == 0)
		$errors .= '<p>Please provide a valid time of appointment.</p>';

	if(empty($errors))
	{
		$apptimestamp = $doa . ' ' . $toa . ':00';
		$sql = sprintf("UPDATE appointment set AppTimestamp='%s', Status=2 WHERE AppId=%s", $apptimestamp, $appid);

		$rs = mysqli_query($conn, $sql);
		if(!$rs) { die("Query failed - " . mysqli_error($conn)); }
		else
		{
			$_SESSION["msg"] = '<p>Appointment successful!</p>';
			$_SESSION["msg"] .= '<a href="appointments.php" title="Go back to appointments" class="btn btn-sm">Go back</a>';
			header('Location: response.php?alert=success');
		}
	}
	// Closing Connection
	mysqli_close($conn);
}

// If Accept button is clicked
if(isset($_POST["cancel"]) && $_POST["cancel"] == "Submit")
{
	$conn = connect_db();
	$isSearch = true;

	// Input sanitization
	$aid = validate_form_data($conn, $_POST["aid"]);
	$appid = validate_form_data($conn, $_POST["appid"]);
	$desc = validate_form_data($conn, $_POST["msg"]);

	// Validation
	$errors = "";
	if(strlen($desc) == 0)
		$errors = '<p>Please write reason for cencellation of appointment, so that adopter can know why his appointment is canceled.</p>';

	if(empty($errors))
	{
		$sql = sprintf("UPDATE appointment set Description='%s', Status=3 WHERE AppId=%s", $desc, $appid);

		$rs = mysqli_query($conn, $sql);
		if(!$rs) { die("Query failed - " . mysqli_error($conn)); }
		else
		{
			$_SESSION["msg"] = '<p>Appointment cancelled!</p>';
			header('Location: response.php?alert=success');
		}
	}
	// Closing Connection
	mysqli_close($conn);
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
render('dashsidebar', array('levelup' => '2', 'orgname' => $_SESSION["orgname"], 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'appointments'));
?>


<div class="col-w-10 dash-main">
	<div class="dash-header clearfix">
		<div class="col-w-11 dash-container"><h3 style="line-height: 60px;margin-left: 50px; color: #333;">Dashboard</h3></div>
		<div class="col-w-1"><a href="./logout.php" class="btn btn-logout" style="margin-top: 15px;">Logout</a></div>
	</div>

	<div class="dash-body">
		<div class="col-w-8" style="float: none !important; margin: 0 auto;">
			<div class="panel panel-default">
				<div class="panel-head">
					<h1 class="panel-title">Reponse to Adopter</h1>
				</div>
				<div class="panel-body">
					<?php
						if(isset($_GET["alert"]) && $_GET["alert"] == "success")
						{
							echo '<div class="actNotify-green">' . $_SESSION["msg"] . '</div>';
						}
					?>
					<form class="form-controls" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<?php if(isset($_POST["cancel"]) && $_POST["cancel"] == "Cancel"): ?>
						<p>Write Reason of cancellation</p>
						<div class="form-controls-row">
							<textarea  spellingcheck="true" maxlength="250" minlength="10" style="width: 100%" id="msg" name="msg" placeholder="Write your message.." rows="6"><?php if(isset($_POST["msg"])) echo htmlspecialchars($_POST["msg"]); ?></textarea>
						</div>
						<div class="form-controls-btnrow">
							<input type="submit" name="cancel" value="Submit" class="txt-light accent-primary">
						</div>
					<?php endif; ?>

					<?php if(isset($_POST["accept"]) && $_POST["accept"] == "Accept"): ?>
						<p>Please mention date and time of appointment</p>
						<div class="form-controls-row">
							<input type="text" name="doa" value="<?php if(isset($_POST["doa"])) echo htmlspecialchars($_POST["doa"]); ?>" placeholder="yyyy-mm-dd" maxlength="10">
							<input type="text" name="toa" value="<?php if(isset($_POST["toa"])) echo htmlspecialchars($_POST["toa"]); ?>" placeholder="hh:mm (24 hour format)" maxlength="5">
						</div>
						<div class="form-controls-btnrow">
							<input type="submit" name="accept" value="Submit" class="txt-light accent-primary">
						</div>
					<?php endif; ?>
					<input type="hidden" name="aid" id="aid" value="<?php if(isset($_POST["aid"])) echo $_POST["aid"]; ?>">
					<input type="hidden" name="appid" id="appid" value="<?php if(isset($_POST["appid"])) echo $_POST["appid"]; ?>">
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
