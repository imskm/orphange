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
// fetching user details
// and other mandatory details
/////////////////////////////////

$userid = $_SESSION["userid"];
$conn = connect_db();
$sql = sprintf("SELECT AdoptId, AdoptedAt, OrgName, gcFName, gcLName, ChId FROM adopt_V WHERE AdoptId=%s", $userid);
$rs = mysqli_query($conn, $sql);
if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

if(mysqli_num_rows($rs) == 0)
	$notice = '<p>You have not adopted any child yet. <a class="close">&#x2716;</a></p>'

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
render('dashsidebar', array('levelup' => '2', 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'adoptions'));
?>


<div class="col-w-10 dash-main">
	<div class="dash-header clearfix">
		<div class="col-w-11 dash-container"><h3 style="line-height: 60px;margin-left: 50px; color: #333;">Dashboard</h3></div>
		<div class="col-w-1"><a href="./logout.php" class="btn btn-logout" style="margin-top: 15px;">Logout</a></div>
	</div>

	<div class="dash-body">
		<div class="row clearfix">
			<div class="col-w-11" style="float: none !important; margin: 0 auto;">
				<h1 style="margin-bottom: 20px; font-family: 'Roboto regular'; font-size: 1.5em;">Adoptions</h1>
				<?php
					if(isset($notice))
						echo '<div class="actNotify-notice">'. $notice .'</div>';
					if(isset($_GET["alert"]) && $_GET["alert"] == "success" && isset($_SESSION["msg"]))
						echo '<div class="actNotify-green">'. $_SESSION["msg"] .'</div>';
					if(isset($_GET["alert"]) && $_GET["alert"] == "notice" && isset($_SESSION["msg"]))
						echo '<div class="actNotify-notice">'. $_SESSION["msg"] .'</div>';
				?>
				<table width="100%" border="1" class="table">
					<?php
						if(mysqli_num_rows($rs) > 0)
						{
							echo '<tr class="tal thead">
								<th>#id</th>
								<th>Adopt date</th>
								<th>Orphanage</th>
								<th>Child adopted</th>
								<th>Status</th>
								<th>View</th>
							</tr>';
							while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
							{
								echo '<tr>';
								echo '<td>'. $row["AdoptId"] .'</td>';
								echo '<td>'. htmlspecialchars(explode(" ", $row["AdoptedAt"])[0]) . '</td>';
								echo '<td>'. htmlspecialchars($row["OrgName"]) . '</td>';
								echo '<td>'. htmlspecialchars($row["gcFName"] . ' ' . $row["gcLName"]) . '</td>';
								echo '<td>Adopted</td>';
								echo '<td class="tac"><a href="childprofile.php?chid='. $row["ChId"] .'" class="btn btn-sm accent-primary"><i class="fa fa-eye" aria-hidden="true"></i></a></td>';
								echo '</tr>';
							}
						}

					?>
				</table>
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
