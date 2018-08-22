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
if(isset($_POST["change"]) && $_POST["change"] == "Change password")
{
	$conn = connect_db();

	// Validation
	$username = $_SESSION["username"];
	$errors = "";
	$oldpasswd = validate_form_data($conn, $_POST["oldpasswd"]);
	$newpasswd = validate_form_data($conn, $_POST["newpasswd"]);
	$confpasswd = validate_form_data($conn, $_POST["confpasswd"]);

	if(strlen($oldpasswd) == 0)
		$errors = '<p>Old password can not be empty.</p>';
	if(strlen($newpasswd) == 0)
		$errors .= '<p>New password can not be empty.</p>';
	if(strlen($confpasswd) == 0)
		$errors .= '<p>Confirm password can not be empty.</p>';

	if(empty($errors))
	{
		if($newpasswd != $confpasswd)
			$errors .= '<p>New password and Confirm password does not match.</p>';
	}

	// Varifying old password
	// from database
	if(empty($errors))
	{
		$sql = sprintf("SELECT Password FROM login WHERE Username='%s'", $username);
	    $rs = mysqli_query($conn, $sql);
	    if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

		if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
			$hashedpasswd 	= $row["Password"];

		if(!password_verify($oldpasswd, $hashedpasswd))
			$errors = '<p>Invalid old password!.</p>';

		// Freeing up result set
		mysqli_free_result($rs);
	}

	// Changing password
	// after all validations
	if(empty($errors))
	{
		$hashed_newpasswd = password_hash($newpasswd, PASSWORD_DEFAULT);
		$sql = sprintf("UPDATE login set Password='%s' WHERE Username='%s'", $hashed_newpasswd, $username);
		$rs = mysqli_query($conn, $sql);
		if($rs)
			header('Location: settings.php?alert=success');
		else
			die("Query failed - " . mysqli_error($conn));

	}
	// Closing connection
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
render('dashsidebar', array('levelup' => '2', 'orgname' => $_SESSION["orgname"], 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'settings'));
?>


<div class="col-w-10 dash-main">
	<div class="dash-header clearfix">
		<div class="col-w-11 dash-container"><h3 style="line-height: 60px;margin-left: 50px; color: #333;">Dashboard</h3></div>
		<div class="col-w-1"><a href="./logout.php" class="btn btn-logout" style="margin-top: 15px;">Logout</a></div>
	</div>

	<div class="dash-body">
		<div class="row">
			<div class="col-w-8" style="float: none !important; margin: 0 auto;">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4 style="margin-bottom: 10px; color: #000;">Change your account password</h4>
						<form class="form-controls" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<?php
								if(!empty($errors))
									echo '<div class="actNotify-red">' . $errors . '</div>';

								if(isset($_GET["alert"]) && $_GET["alert"] == "success")
								{
									echo '<div class="actNotify-green"><p>Password changed successfull!</p></div>';
								}
							?>
				            <div class="row form-controls-row clearfix">
				                <div class="col-w-5">
				                    <input type="password" name="oldpasswd" class="searchcity" placeholder="Type old password">
				                </div>
							</div>
							<div class="row form-controls-row clearfix">
				                <div class="col-w-5">
				                    <input type="password" name="newpasswd" class="searchcity" placeholder="Type new password">
				                </div>
				                <div class="col-w-5">
				                    <input type="password" name="confpasswd" class="searchcity" placeholder="Re-enter new password">
				                </div>
				            </div>
							<div class="row form-controls-row clearfix">
								<div class="col-w-2">
									<input type="submit" name="change" value="Change password" class="btn accent-primary txt-light" style="padding-top: 10px; padding-bottom: 10px;">
								</div>
							</div>
				        </form>

					</div>
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
