<?php
session_start();
require_once('../../includes/helpers.php');

if(!is_ajax_request()) { exit; }

//echo $_POST["oid"];
if(isset($_POST["oid"]))
{
	$conn = connect_db();
	$userid = $_SESSION["userid"];
	$oid = validate_form_data($conn, $_POST["oid"]);
	$chid = isset($_POST["chid"]) ? validate_form_data($conn, $_POST["chid"]) : '';

	//////////////////////////////////
	// STEP 1: Validating
	//  No adopter is allowed to make
	//  new request if he/she already
	//  adopted 2 childs.
	//////////////////////////////////
	$sql = sprintf("SELECT count(AdopId) Adopted FROM adopt WHERE AdopId=%s GROUP BY AdopId", $userid);
	$sql_2 = sprintf("SELECT OrgName FROM orphanage WHERE OId=%s", $oid);

	$rs = mysqli_query($conn, $sql);
	$rs_2 = mysqli_query($conn, $sql_2);
	if(!$rs) { die('Query failed - ' . mysqli_error($conn)); }
	if(!$rs_2) { die('Query failed - ' . mysqli_error($conn)); }
	if(mysqli_num_rows($rs) > 0)
	{
		if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
			$child_adopted = $row["Adopted"];
	}
	else
		$child_adopted = 0;

	// Fetching org name for showing in the popup box
	if(mysqli_num_rows($rs_2) > 0)
	{
		if($row = mysqli_fetch_array($rs_2, MYSQLI_ASSOC))
			$orgname = $row["OrgName"];
	}

	// Freeing up result set
	mysqli_free_result($rs);
	mysqli_free_result($rs_2);

	//////////////////////////////////
	// STEP 2: Inserting new request
	//  Storing appointment request
	//  in the database.
	//////////////////////////////////

	$sql = sprintf("INSERT INTO appointment(Status, AdopId, OId, ChId) VALUES(1, %s, %s, %s)", $userid, $oid, $chid);

	if($child_adopted < 2)
	{
		$rs = mysqli_query($conn, $sql);
		if(!$rs) { die('Query failed - ' . mysqli_error($conn)); }
	}
	else
	{
		$errors = '<p>You have already adopted 2 child. Therefor you are not allowed to make new request.</p>';
	}
}

// Fetching Accept or Cancel info from appointment
if(isset($_POST["appid"]) && isset($_POST["action"]))
{
	$conn = connect_db();
	$appid = validate_form_data($conn, $_POST["appid"]);

	if($_POST["action"] == "accept")
	{
		$sql = sprintf("SELECT AppTimestamp FROM appointment WHERE AppId=%s", $appid);
		$html = 'Your appointment date and time';
		$pretxt = 'Please note down the date and time : <br>Please visit Organisation on : ';
	}

	if($_POST["action"] == "cancel")
	{
		$sql = sprintf("SELECT Description FROM appointment WHERE AppId=%s", $appid);
		$html = 'Reason for cancellation of appointment';
		$pretxt = '';
	}

	$rs = mysqli_query($conn, $sql);
	if(!$rs) { die('Query failed - ' . mysqli_error($conn)); }
	if(mysqli_num_rows($rs) > 0)
	{
		if($row = mysqli_fetch_array($rs, MYSQLI_NUM))
			$data = $pretxt . $row[0];
	}

	// Freeing up result set
	mysqli_free_result($rs);

}

?>
<?php if(!isset($_POST["action"])): ?>
<div class="overlay clearfix" id="overlay-popup">
	<div class="panel panel-default" style="display: block; width: 450px; margin: 10% auto 0 auto;">
		<div class="panel-head">
			<?php
				if(isset($errors))
					echo '<h3 class="panel-title btn-danger">ERROR : Restriction violation.</h1>';
				else
					echo '<h3 class="panel-title" style="color: #0A0;">Appointment request made successfully!</h1>';
			?>
		</div>
		<div class="panel-body">
			<?php if(isset($errors)): ?>
				<p>Sorry! we can not process your request because you already have made max request (i.e. 2 request).</p>
			<?php else: ?>
				<p>We have sent an appointment request to the <strong><?= $orgname ?></strong></p>
			<?php endif ?>
			<br/>
			<p class="tac"><a class="btn btn-sm accent-primary" id="close-ok">Ok</a></p>
		</div>
	</div>
</div>
<?php endif ?>

<?php if(isset($_POST["action"])): ?>
<div class="overlay clearfix" id="overlay-popup">
	<div class="panel panel-default" style="display: block; width: 450px; margin: 10% auto 0 auto;">
		<div class="panel-head">
			<h3><?php echo $html; ?></h3>
		</div>
		<div class="panel-body">
				<p><?php echo $data; ?></p>
			<br/>
			<p class="tac"><a class="btn btn-sm accent-primary" id="close-ok">Ok</a></p>
		</div>
	</div>
</div>
<?php endif ?>
