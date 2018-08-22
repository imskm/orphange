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
// fetching orphanage details
// and other mandatory details
/////////////////////////////////

$conn = connect_db();

if(isset($_GET["oid"]))
{
	$isSearch = true;
	$oid = validate_form_data($conn, $_GET["oid"]);

	$sql = sprintf("SELECT * FROM orphanage_children_V WHERE OId=%s", $oid);

	$rs = mysqli_query($conn, $sql);
	if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

	/////////////////////////////////////
	// Fetching Children details
	// of the oid.
	/////////////////////////////////////
	$sql_2 = sprintf("SELECT * FROM adopt_child_V WHERE OId=%s", $oid);

	$rs_2 = mysqli_query($conn, $sql_2);
	if(!$rs_2) { die("Query failed - " . mysqli_error($conn)); }
}
// Closing Connection
mysqli_close($conn);
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
render('dashsidebar', array('levelup' => '2', 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'home'));
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
					<div class="panel-head">
						<h1 class="panel-title">Profile</h1>
					</div>
					<div class="panel-body">
						<form class="form-controls" action="search.php" method="post">

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
									echo '<th colspan="4" class="tal">'. htmlspecialchars($row["OrgName"]) . '</th>';
									echo '</tr>';
									echo '<tr>';
									echo '<tr>';
									echo '<th><i class="fa fa-user" aria-hidden="true"></i></th>';
									echo '<td colspan="3">'. htmlspecialchars($row["FName"] . ' ' . $row["LName"]) . ' (Person incharge)</td>';
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
									if(!empty($row["Website"]))
									{
										echo '<tr>';
										echo '<th><i class="fa fa-globe" aria-hidden="true"></i></th>';
										echo '<td colspan="3"><a target="_new" href="http://'. htmlspecialchars($row["Website"]) . '">'. htmlspecialchars($row["Website"]) . '</a></td>';
										echo '</tr>';
									}
									if(empty($row["Children"]))
									{
										echo '<tr>';
										echo '<th><i class="fa fa-child" aria-hidden="true"></i></th>';
										echo '<td>'. htmlspecialchars($row["Children"]) . ' Childrens</td>';
										echo '<td colspan="2">'. htmlspecialchars($row["Male"]) . ' Male, '. htmlspecialchars($row["Female"]) . ' Female</td>';
										echo '</tr>';
									}
									else
									{
										echo '<tr>';
										echo '<th><i class="fa fa-child" aria-hidden="true"></i></th>';
										echo '<td>'. htmlspecialchars($row["Children"]) . ' Childrens</td>';
										echo '<td colspan="2">'. htmlspecialchars($row["Male"]) . ' Male, '. htmlspecialchars($row["Female"]) . ' Female</td>';
										echo '</tr>';
									}
								}
								echo '<tr> <td colspan="7" class="tac"><a class="btn btn-donate" href="donate.php?action=donate&oid='. $oid .'"><i class="fa fa-heart" aria-hidden="true"></i> Donate</a>
								<input type="hidden" id="oid" value="'. $oid .'"></td></tr>';
							}
						?>
								</table>
							</div>
				            <div class="row form-controls-row clearfix">

				            </div>
				        </form>

					</div>
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<div class="col-w-8" style="float: none !important; margin: 0 auto;">
				<div class="panel panel-default">
					<div class="panel-body clearfix">
						<h4 style="margin-bottom: 20px; color: #000;">All children of this orphanage centre - Adopt a child</h4>
						<?php
							if(isset($isSearch))
							{
								if(mysqli_num_rows($rs_2) > 0)
								while($row = mysqli_fetch_array($rs_2, MYSQLI_ASSOC))
								{
									echo '<div class="col-w-6">';
									echo '<div class="row top-org" style="margin-bottom: 6px; border-bottom: 1px solid #eaeaea;">';
									echo '<div class="img-thumbnail-sm" style="background-image: url(\''. htmlspecialchars($row["Photo"]) .'\')"></div>';
									echo '<div class="top-org-desc">';
									echo '<h4>'. htmlspecialchars($row["FName"] . ' ' . $row["LName"]) .'</h4>';
									if($row["Gender"] == 1)
										echo '<p class="small-p">Gender : Male</p>';
									else
										echo '<p class="small-p">Gender : Female</p>';
									echo '<p class="small-p">Age : '. htmlspecialchars($row["Age"]) .'</p>';
									if(empty($row["AdoptId"]))
										echo '<p class="small-p"><input type="button" class="btn btn-adopt" value="Adopt me!"><input type="hidden" value="'.$row["ChId"].'"></p>';
									else
										echo '<p class="small-p"><input type="button" class="btn btn-adopt accent-desabled" value="I\'m Adopted!" style="pointer-events: none;"><input type="hidden" value="'.$row["ChId"].'"></p>';

									echo '</div></div></div>';
								}
								else
								{
									echo '<p>No children found in this orphanage.</p>';
								}
							}
							// Freeing up result source
							if(isset($isSearch))
								mysqli_free_result($rs);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="ajaxResponse"></div>
<script type="text/javascript">

function adopt_me()
{
	//var oid = document.getElementById('oid');
	var chid = this.nextElementSibling.value;
	//console.log(this);
	//console.log(chid);
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

	xhr.send("oid=" + oid.value + "&chid=" + chid);
}

var btnAdoptme = document.getElementsByClassName('btn-adopt');
for(var i = 0; i < btnAdoptme.length; ++i)
{
	btnAdoptme.item(i).addEventListener("click", adopt_me);
}

</script>


</div>
<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer', array('levelup' => '2'))
?>
