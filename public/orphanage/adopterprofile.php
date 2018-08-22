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

$conn = connect_db();

if(isset($_GET["aid"]) && isset($_GET["appid"])&& isset($_GET["chid"]))
{
	$isSearch = true;
	$aid = validate_form_data($conn, $_GET["aid"]);
	$appid = validate_form_data($conn, $_GET["appid"]);
	$chid = validate_form_data($conn, $_GET["chid"]);

	$sql = sprintf("SELECT * FROM adopter WHERE AdopId=%s", $aid);
	$sql_2 = sprintf("SELECT * FROM godchild WHERE ChId=%s", $chid);

	$rs = mysqli_query($conn, $sql);
	$rs_2 = mysqli_query($conn, $sql_2);
	if(!$rs) { die("Query failed - " . mysqli_error($conn)); }
	if(!$rs_2) { die("Query failed - " . mysqli_error($conn)); }
	$poi = '';
	$poa = '';
}
else
{
	header('Location: appointments.php');
}
// Closing Connection
mysqli_close($conn);
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
					<h1 class="panel-title">Adopter Profile</h1>
				</div>
				<div class="panel-body">
					<form class="form-controls" action="response.php" method="post">

					<?php
						if(isset($isSearch) && mysqli_num_rows($rs) > 0)
						{
							if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
							{
								echo '<div class="col-w-4">';
								echo '<div class="img-thumbnail" style="background-image: url(\''. htmlspecialchars($row["Photo"]) . '\')"></div>';
								echo '</div>';
								echo '<div class="col-w-8">';
								echo '<table width="100%" border="1" class="table">';

								echo '<tr>';
								echo '<th colspan="4" class="tal">'. htmlspecialchars($row["FName"] . ' ' . $row["LName"]) . '</th>';
								echo '</tr>';
								echo '<tr>';
								echo '<th><i class="fa fa-map-marker" aria-hidden="true"></i></th>';
								if(empty($row["Address2"]))
									echo '<td colspan="3">'. htmlspecialchars($row["Address1"] . ', ' . $row["City"] . ', '. $row["State"]) . '</td>';
								else
									echo '<td colspan="3">'. htmlspecialchars($row["Address1"] . ', ' . $row["Address2"] . ', '. $row["City"] . ', '. $row["State"]) . '</td>';
								echo '</tr>';
								echo '<tr>';
								echo '<th><i class="fa fa-phone" aria-hidden="true"></i></th>';
								echo '<td>'. htmlspecialchars($row["Phone"]) . '</td>';
								echo '<th><i class="fa fa-envelope" aria-hidden="true"></i></th>';
								echo '<td>'. htmlspecialchars($row["Email"]) . '</td>';
								echo '</tr>';
								echo '<tr>';
								echo '<th><i class="fa fa-id-card" aria-hidden="true"></i></th>';
								echo '<td colspan="3">'. htmlspecialchars($row["AadhaarNo"]) . ' (Aadhaar number)</td>';
								echo '</tr>';
								$poi = $row["Poi"];
								$poa = $row["Poa"];

							}
							echo '<tr> <td colspan="7" class="tac">
							<input type="submit" name="cancel" value="Cancel" class="btn txt-light btn-danger">
							<input type="submit" name="accept" value="Accept" class="btn txt-light btn-success">
							<input type="hidden" name="aid" id="aid" value="'. $aid .'"><input type="hidden" name="appid" id="appid" value="'. $appid .'"></td></tr>';
						}
					?>
							</table>
						</div>
						<div class="row form-controls-row clearfix">

						</div>
					</form>

				</div>
			</div>
			<!-- adoption request for child -->
			<div class="panel panel-default">
				<div class="panel-body clearfix">
					<h4 style="margin-bottom: 10px; color: #000;">Adoption request for child</h4>
					<?php
						if(isset($isSearch))
						{
							if(mysqli_num_rows($rs_2) > 0)
							while($row = mysqli_fetch_array($rs_2, MYSQLI_ASSOC))
							{
								echo '<div class="col-w-6">';
								echo '<div class="row top-org" style="margin-bottom: 6px;">';
								echo '<div class="img-thumbnail-sm" style="background-image: url(\''. htmlspecialchars($row["Photo"]) .'\')"></div>';
								echo '<div class="top-org-desc">';
								echo '<h4>'. htmlspecialchars($row["FName"] . ' ' . $row["LName"]) .'</h4>';
								if($row["Gender"] == 1)
									echo '<p class="small-p">Gender : Male</p>';
								else
									echo '<p class="small-p">Gender : Female</p>';
								echo '<p class="small-p">Age : '. htmlspecialchars($row["Age"]) .'</p>';
								echo '<p class="small-p"><input type="button" id="markadopted" class="btn btn-adopt" value="Mark as adopted"><input type="hidden" id="chid" value="'.$row["ChId"].'"></p>';

								echo '</div></div></div>';
							}
						}
						// Freeing up result source
						if(isset($isSearch))
							mysqli_free_result($rs);
					?>


				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-body clearfix">
					<h4 style="margin-bottom: 10px; color: #000;">Documents of adopter</h4>
					<div class="col-w-6">
						<h3 style="margin-bottom: 10px; color: #777;">Proof of identity</h3>
						<div class="img-thumbnail" style="width: 300px !important; height: 350px !important; background-image: url('<?php if(isset($poi) && !empty($poi)) echo $poi; ?>')"></div>
					</div>
					<div class="col-w-6">
						<h3 style="margin-bottom: 10px; color: #777;">Proof of address</h3>
						<div class="img-thumbnail" style="width: 300px !important; height: 350px !important; background-image: url('<?php if(isset($poa) && !empty($poa)) echo $poa; ?>')"></div>
					</div>


				</div>
			</div>

		</div>
	</div>
</div>

<div id="ajaxResponse"></div>
<script type="text/javascript">
function mark_adopted()
{
	//var oid = document.getElementById('oid');
	var chid = document.getElementById('chid').value;
	var aid = <?= $aid ?>;
	//console.log(this);
	//console.log(aid);
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
			//console.log(xhr.responseText);
		}
	}

	xhr.send("aid=" + aid + "&chid=" + chid);
}

var button = document.getElementById('markadopted');
button.addEventListener("click", mark_adopted);

</script>



</div>
<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer', array('levelup' => '2'))
?>
