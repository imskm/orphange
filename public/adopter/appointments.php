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

///////////////////////////////
// Fetching appointments
///////////////////////////////
$userid = $_SESSION["userid"];
$conn = connect_db();
$sql = sprintf("SELECT AppId, RequestedOn, Status, OId, OrgName, ChId, gcFName, gcLName  FROM appointment_V WHERE AdopId=%s", $userid);

$rs = mysqli_query($conn, $sql);
if(!$rs) { die("Query failed - " . myslqi_error($conn)); }

if(mysqli_num_rows($rs) == 0)
	$notice = '<p>You have not made any appointement request or appointment is empty! <a class="close">x</a></p>';

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
render('dashsidebar', array('levelup' => '2', 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'appointments'));
?>


<div class="col-w-10 dash-main">
	<div class="dash-header clearfix">
		<div class="col-w-11 dash-container"><h3 style="line-height: 60px;margin-left: 50px; color: #333;">Dashboard</h3></div>
		<div class="col-w-1"><a href="./logout.php" class="btn btn-logout" style="margin-top: 15px;">Logout</a></div>
	</div>

	<div class="dash-body">
		<div class="row">
			<div class="col-w-11" style="float: none !important; margin: 0 auto;">
				<h1 style="margin-bottom: 20px; font-family: 'Roboto regular'; font-size: 1.5em;">Appointments</h1>
				<?php
					if(isset($notice))
						echo '<div class="actNotify-notice">'. $notice .'</div>';
					if(isset($_GET["alert"]) && $_GET["alert"] == "success" && isset($_SESSION["msg"]))
						echo '<div class="actNotify-green">'. $_SESSION["msg"] .'</div>';
					if(isset($_GET["alert"]) && $_GET["alert"] == "notice" && isset($_SESSION["msg"]))
						echo '<div class="actNotify-notice">'. $_SESSION["msg"] .'</div>';
				?>
				<table width="100%" border="1" class="table">
					<tr class="tal thead">
						<th>#id</th>
						<th>Request date</th>
						<th>Description</th>
						<th>Status</th>

					</tr>
					<?php
						if(mysqli_num_rows($rs) > 0)
						{
							while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
							{
								echo '<tr>';
								echo '<td>'. $row["AppId"] .'<input type="hidden" id="appid" name="appid" value="'. $row["AppId"] .'"></td>';
								echo '<td>'. htmlspecialchars(explode(" ", $row["RequestedOn"])[0]) . '</td>';
								if(empty($row["ChId"]))
									echo '<td>Your request has been sent to '. htmlspecialchars($row["OrgName"]) .'</td>';
								else
									echo '<td>Your request has been sent to '. htmlspecialchars($row["OrgName"]) .' for child '. $row["gcFName"] . ' ' . $row["gcLName"] . '.</td>';
								if($row["Status"] == 1)
									echo '<td>Reques made</td>';
									else if($row["Status"] == 2)
									{
										echo '<td style="color: #0A0;">';
										echo 'Request accepted!';
										echo '<a id="view" data-action="accept" class="btn btn-sm accent-primary" style="position: relative;left: 25px;" title="View appointment date / time"><i class="fa fa-eye" aria-hidden="true"></i></a>';
										echo '</td>';

									}
									else if($row["Status"] == 3)
									{
										echo '<td style="color: #A00;">';
										echo 'Request canceled!';
										echo '<a id="view" data-action="cancel" class="btn btn-sm accent-primary" style="position: relative;left: 25px;" title="View reason for cancellation of appointment"><i class="fa fa-eye" aria-hidden="true"></i></a>';
										echo '</td>';

									}

								echo '</tr>';
							}
						}

					?>
				</table>
			</div>
		</div>
	</div>
</div>
<div id="ajaxResponse"></div>
<script type="text/javascript">

function appointment()
{
	//var oid = document.getElementById('oid');
	var action = this.getAttribute('data-action');
	var appid = document.getElementById('appid').value;
	//console.log(action);
	//return;
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "processrqst.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && xhr.status == 200)
		{
			var target = document.getElementById("ajaxResponse");
			target.innerHTML = xhr.responseText;
			//console.log(xhr.responseText);
		}
	}

	xhr.send("appid=" + appid + "&action=" + action);
}

var button = document.getElementById('view');
button.addEventListener("click", appointment);

</script>



</div>
<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer', array('levelup' => '2'))
?>
