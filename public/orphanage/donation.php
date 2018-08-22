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

// Fetching Donation details from donation table
$conn = connect_db();
$sql = sprintf("SELECT * FROM donation WHERE OId=%s", $_SESSION["userid"]);
$rs = mysqli_query($conn, $sql);
if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

if(mysqli_num_rows($rs) == 0)
{
	$notice = '<p>Donation database for your organisation is empty. <a class="close">&#x2716;</a></p>';
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
render('dashsidebar', array('levelup' => '2', 'orgname' => $_SESSION["orgname"], 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'donation'));
?>


<div class="col-w-10 dash-main">
	<div class="dash-header clearfix">
		<div class="col-w-11 dash-container"><h3 style="line-height: 60px;margin-left: 50px; color: #333;">Dashboard</h3></div>
		<div class="col-w-1"><a href="./logout.php" class="btn btn-logout" style="margin-top: 15px;">Logout</a></div>
	</div>

	<div class="dash-body">
		<div class="row">
			<div class="col-w-11" style="float: none !important; margin: 0 auto;">
				<h1 style="margin-bottom: 20px; font-family: 'Roboto regular'; font-size: 1.5em;">Donations</h1>
				<?php
					if(isset($notice))
						echo '<div class="actNotify-notice">'. $notice .'</div>';
					if(isset($_GET["alert"]) && $_GET["alert"] == "success" && isset($_SESSION["msg"]))
						echo '<div class="actNotify-green">'. $_SESSION["msg"] .'</div>';
					if(isset($_GET["alert"]) && $_GET["alert"] == "notice" && isset($_SESSION["msg"]))
						echo '<div class="actNotify-notice">'. $_SESSION["msg"] .'</div>';
				?>
					<?php
						if(mysqli_num_rows($rs) > 0)
						{
							echo '<table width="100%" border="1" class="table">
								<tr class="tal thead">
									<th>#id</th>
									<th>Donation date</th>
									<th>DD Number</th>
									<th>Bank</th>
									<th>Message</th>
									<th>Amount</th>
									<th>Status</th>
									<th>DD Received?</th>

								</tr>';
							while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
							{
								echo '<tr>';
								echo '<td>'. $row["DId"] .'</td>';
								echo '<td>'. htmlspecialchars(explode(" ", $row["DDate"])[0]) . '</td>';
								echo '<td>'. $row["DdNo"] .'</td>';
								echo '<td>'. $row["Bank"] .'</td>';
								echo '<td>'. $row["Msg"] .'</td>';
								echo '<td>'. $row["Amount"] .'</td>';

								if($row["Status"] == 1)
								{
									echo '<td>Donation made</td>';
									echo '<td class="tac"><a class="btn btn-sm accent-primary" id="ddrcvd" title="Yes, received."><i class="fa fa-check-square-o" aria-hidden="true"></i></a><input type="hidden" id="did" name="did" value="'. $row["DId"] .'"></td>';

								}
								else if($row["Status"] == 2)
								{
									echo '<td style="color: #0A0;">';
									echo 'Donation accepted!';
									echo '</td>';
									echo '<td class="tac"><a class="btn btn-sm accent-desabled" id="ddrcvd" style="pointer-events: none;"><i class="fa fa-check-square-o" aria-hidden="true"></i></a></td>';

								}
								else if($row["Status"] == 3)
								{
									echo '<td style="color: #A00;">';
									echo 'Request canceled!';
									echo '</td>';
									echo '<td class="tac"><a class="btn btn-sm accent-desabled" id="ddrcvd" style="pointer-events: none;"><i class="fa fa-check-square-o" aria-hidden="true"></i></a></td>';
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
function rqst_rcvd()
{
	//var oid = document.getElementById('oid');
	//var did = document.getElementById('did').value;
	var did = this.nextElementSibling.value;
	//console.log(this);
	console.log(did);

	var xhr = new XMLHttpRequest();
	xhr.open("POST", "proccesajax.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && xhr.status == 200)
		{
			var target = document.getElementById("ajaxResponse");
			target.innerHTML = xhr.responseText;
			console.log(xhr.responseText);
		}
	}

	xhr.send("did=" + did + "&action=donation_rcvd");
}

var button = document.getElementsByClassName('btn-sm');
for(var i = 0; i < button.length; i++)
	button[i].addEventListener("click", rqst_rcvd);

</script>



</div>
<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer', array('levelup' => '2'))
?>
