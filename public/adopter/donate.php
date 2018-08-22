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
if(!isset($_GET["oid"]))
{
	if(isset($_SERVER["HTTP_REFERER"]))
		header('Location: ' . htmlspecialchars($_SERVER["HTTP_REFERER"]));
	else
		header('Location: orphanageprofile.php');
}

// Orphanage detail
if(is_num($_GET["oid"]))
{
	$conn = connect_db();

	if(!isset($_GET["oid"]))
	{
		$errors = '<p>Orphange id is not set.</p>';
	}

	if(empty($errors))
	{
		// Input sanitization
		$oid = validate_form_data($conn, $_GET["oid"]);

		$sql = sprintf("SELECT OrgName, Photo from orphanage WHERE OId=%s", $oid);

		$rs = mysqli_query($conn, $sql);
		if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

		if(mysqli_num_rows($rs) > 0)
		{
			if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
			{
				$orgname = $row["OrgName"];
				$photo = $row["Photo"];
				//echo $photo;
			}
		}
		else
		{
			$errors = '<p>Orphange not found.</p>';
		}
	}
	// Closing Connection
	mysqli_close($conn);
}

// If Donate button is clicked
if(isset($_POST["donate"]))
{
	$conn = connect_db();

	// Validation
	$errors = "";
	if(!isset($_POST["bank"]) || $_POST["bank"] == "") { $errors = '<p><span class="mandatory">*</span> marked fields are mandatory.</p>'; }
	// Input sanitization
	$amount = validate_form_data($conn, $_POST["amount"]);
	$ddno = validate_form_data($conn, $_POST["ddno"]);
	$msg = validate_form_data($conn, $_POST["msg"]);
	$oid = validate_form_data($conn, $_POST["oid"]);

	if(!is_num($amount))
		$errors .= '<p>Please provide positive integer in amount field.</p>';
	if(intval($amount) < 999)
		$errors .= '<p>Please donate atleast minimum amount (i.e. 1,000).</p>';
	if(strlen($ddno) == 0)
		$errors .= '<p>Please provide a valid demand draft number.</p>';

	if(empty($errors))
	{
		$aid = $_SESSION["userid"];
		$bank = validate_form_data($conn, $_POST["bank"]);
		$sql = sprintf("INSERT INTO donation(Amount, Bank, DdNo, AdopId, OId, Msg, Status)
				VALUES(%s, '%s', '%s', %s, %s, '%s', 1)", $amount, $bank, $ddno, $aid, $oid, $msg);

		$rs = mysqli_query($conn, $sql);
		if(!$rs) { die("Query failed - " . mysqli_error($conn)); }
		else
		{
			$_SESSION["msg"] = '<p>Donation successful!</p>';
			$_SESSION["msg"] .= '<p>We have sent your donation to '. $orgname .'. You will shortly be notified by the organisation that they have received your donation message.</p>';
			$_SESSION["msg"] .= '<p>Now you must send the Demand Draft by post to the org.</p>';
			header('Location: donate.php?alert=success&oid=' . $oid);
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
render('dashheader', array('title' => $_SESSION["fname"], 'levelup' => '2'));
?>

<div class="row dashboard clearfix">

<?php
/*************************************
* Render Dashboard Sidebar
* @param array $data
**************************************/
render('dashsidebar', array('levelup' => '2', 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'donation'));
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
					<h1 class="panel-title">Donation form</h1>
				</div>
				<div class="panel-body">
					<?php
						if(isset($errors) && !empty($errors))
						{
							echo '<div class="actNotify-red">' . $errors . '</div>';
						}
						if(isset($_GET["alert"]) && $_GET["alert"] == "success")
						{
							echo '<div class="actNotify-green">' . $_SESSION["msg"] . '</div>';
						}
					?>
					<form class="form-controls" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?action=donate&oid=<?= $_GET['oid'] ?>" method="post">
						<div class="row form-controls-row">
							<h3>Donate to - <?php echo $orgname; ?></h3>
							<div class="img-thumbnail" style="background-image: url('<?php echo htmlspecialchars($photo) ?>')"></div>
						</div>
						<hr style="border: none; border-top: 1px solid #ddd; margin-bottom: 20px;">
						<div class="row form-controls-row">
							<div style="display: inline-block">
								<label for="amount" style="display: block">Enter amount: <span class="mandatory">*</span></label>
								<input type="text" id="amount" name="amount" placeholder="must be > 999" value="<?php if(isset($_POST["amount"])) echo $_POST["amount"]; ?>" style="width: 100% !important;">
							</div>
							<div style="display: inline-block">
								<label for="ddno" style="display: block">Enter DD Number: <span class="mandatory">*</span></label>
								<input type="text" id="ddno" name="ddno" placeholder="DD Number" value="<?php if(isset($_POST["ddno"])) echo $_POST["ddno"]; ?>" style="width: 100% !important;">
							</div>
						</div>

						<div class="form-controls-row">
							<label for="bank">Select bank: <span class="mandatory">*</span></label>
							<select name="bank">
								<option disabled="disabled" selected="selected">Select bank</option>
								<option value="Allahabad Bank">Allahabad Bank</option> <option value="Andhra Bank">Andhra Bank</option> <option value="Bank of India">Bank of India</option> <option value="Bank of Baroda">Bank of Baroda</option> <option value="Bank of Maharashtra">Bank of Maharashtra</option> <option value="Canara Bank">Canara Bank</option> <option value="Central Bank of India">Central Bank of India</option> <option value="Corporation Bank">Corporation Bank</option> <option value="Dena Bank">Dena Bank</option> <option value="Indian Bank">Indian Bank</option> <option value="Indian Overseas Bank">Indian Overseas Bank</option> <option value="IDBI Bank">IDBI Bank</option> <option value="Oriental Bank of Commerce">Oriental Bank of Commerce</option> <option value="Punjab &amp; Sindh Bank">Punjab &amp; Sindh Bank</option> <option value="Punjab National Bank">Punjab National Bank</option> <option value="Syndicate Bank">Syndicate Bank</option> <option value="UCO Bank">UCO Bank</option> <option value="Union Bank of India">Union Bank of India</option> <option value="United Bank of India">United Bank of India</option> <option value="Vijaya Bank">Vijaya Bank</option> <option value="State Bank of India">State Bank of India</option>
							</select>
						</div>

						<div class="form-controls-row">
							<label for="msg" style="display: block">Write message:</label>
							<textarea  spellingcheck="true" maxlength="250" minlength="10" style="width: 100%" id="msg" name="msg" placeholder="Write your message.." rows="6"><?php if(isset($_POST["msg"])) echo htmlspecialchars($_POST["msg"]); ?></textarea>
						</div>
						<div class="form-controls-btnrow">
							<input type="submit" name="donate" value="&#xf004; Donate" class="btn btn-donate">
						</div>
						<input type="hidden" name="oid" id="oid" value="<?php if(isset($_GET["oid"])) echo $_GET["oid"]; ?>">
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
