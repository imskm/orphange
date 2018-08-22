<?php
session_start();
require_once('../../includes/helpers.php');

if(!is_ajax_request()) { exit; }

//echo $_POST["oid"];
if(isset($_POST["aid"]) && isset($_POST["chid"]))
{
	$conn = connect_db();
	$oid = $_SESSION["userid"];
	$aid = validate_form_data($conn, $_POST["aid"]);
	$chid = validate_form_data($conn, $_POST["chid"]);

	$sql = sprintf("INSERT INTO adopt(AdopId, OId, ChId) VALUES(%s, %s, %s)", $aid, $oid, $chid);
	$rs = mysqli_query($conn, $sql);
	if(!$rs)
		{ die('Query failed - ' . mysqli_error($conn)); }
	else
	{
		$responsehead = '<h3 class="panel-title" style="color: #0A0;">Congrats!</h3>';
		$responsetxt = 'Congrats! We have marked this child as adopted.';
	}

}


// Processing donation received click button
if(isset($_POST["action"]) && $_POST["action"] == "donation_rcvd")
{
	if(isset($_POST["did"]) && !empty($_POST["did"]))
	{
		$conn = connect_db();
		$did = validate_form_data($conn, $_POST["did"]);

		$sql = sprintf("UPDATE donation set Status=2 WHERE DId=%s", $did);
		$rs = mysqli_query($conn, $sql);
		if(!$rs)
			{ die('Query failed - ' . mysqli_error($conn)); }
		else
		{
			$responsehead = '<p>Donation received.</p>';
			$responsetxt = 'A notification is sent to donor that you have recieved his Demand Draft.';
		}

	}
}

?>
<div class="overlay clearfix" id="overlay-popup">
	<div class="panel panel-default" style="display: block; width: 450px; margin: 10% auto 0 auto;">
		<div class="panel-head">
			<?php
				if(isset($responsehead))
					echo $responsehead;

			?>
		</div>
		<div class="panel-body">
			<?php if(isset($responsetxt)): ?>
				<p><?php echo $responsetxt; ?></p>
			<?php endif ?>
			<br/>
			<p class="tac"><a class="btn btn-sm accent-primary" id="close-ok">Ok</a></p>
		</div>
	</div>
</div>
