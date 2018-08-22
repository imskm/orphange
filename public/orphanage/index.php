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
// STEP 1 : Adoption details
//   Fetching adoption statistics
//   from adopt table
/////////////////////////////////
$conn = connect_db();
$userid = $_SESSION["userid"];
$sql = sprintf("SELECT COUNT(AdoptId) Adopted FROM adopt WHERE OId=%s GROUP BY OId", $userid);
$rs = mysqli_query($conn, $sql);
if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

if(mysqli_num_rows($rs) > 0)
{
	if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
		$adopted_child = $row["Adopted"];
}
else
	$adopted_child = 0;

// Freein up result set
mysqli_free_result($rs);

//////////////////////////////////
// STEP 2 : Total children
//   Fetching children statistics
//   from godchild table
/////////////////////////////////
$sql = sprintf("SELECT Children, Male, Female FROM children_stats_V WHERE OId=%s", $userid);
$rs = mysqli_query($conn, $sql);
if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

if(mysqli_num_rows($rs) > 0)
{
	if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
	{
		$children = $row["Children"];
		$male = $row["Male"];
		$female = $row["Female"];
	}
}
else
{
	$children = 0;
	$male = 0;
	$female = 0;

}
// Freein up result set
mysqli_free_result($rs);

//////////////////////////////////
// STEP 3 : Appointment requests
//   Fetching appointment statistics
//   from appointment table
/////////////////////////////////
$sql = sprintf("SELECT COUNT(AppId) Apps FROM appointment WHERE OId=%s GROUP BY OId", $userid);
$rs = mysqli_query($conn, $sql);
if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

if(mysqli_num_rows($rs) > 0)
{
	if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
	{
		$apps = $row["Apps"];
	}
}
else
{
	$apps = 0;
}
// Freein up result set
mysqli_free_result($rs);

// Closing connection
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
render('dashsidebar', array('levelup' => '2', 'orgname' => $_SESSION["orgname"], 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'home'));
?>


<div class="col-w-10 dash-main">
	<div class="dash-header clearfix">
		<div class="col-w-11 dash-container"><h3 style="line-height: 60px;margin-left: 50px; color: #333;">Dashboard</h3></div>
		<div class="col-w-1"><a href="./logout.php" class="btn btn-logout" style="margin-top: 15px;">Logout</a></div>
	</div>

	<div class="dash-body">
		<div class="row clearfix">
			<h1 style="font-family: 'Roboto regular'; font-size: 1.5em; width: 50%; margin: 0 auto 20px auto;">Most Recent activities and statistics</h1>
			<div class="col-w-12" style="float: none !important; margin: 0 auto;">
				<div class="col-w-4">
					<div class="dash-container">
						<div class="panel panel-default">
							<div class="panel-body">
								<h3 style="margin-bottom: 30px;">Adoption statistics</h3>
									<p style="display: inline-block; vertical-align: top;">Children adopted</p>
									<h1 style="display: inline-block; font-size:3em; margin-left: 50px;"><?= $adopted_child ?></h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col-w-4">
					<div class="dash-container">
						<div class="panel panel-default">
							<div class="panel-body">
								<h3 style="margin-bottom: 30px;">Total children</h3>
								<p style="display: inline-block; vertical-align: top;">Total Children</p>
								<h1 style="display: inline-block; font-size:3em; margin-left: 50px;"><?= $children ?></h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col-w-4">
					<div class="dash-container">
						<div class="panel panel-default">
							<div class="panel-body">
								<h3 style="margin-bottom: 30px;">Recent appointment requests</h3>
								<p style="display: inline-block; vertical-align: top;">Total appointment</p>
								<h1 style="display: inline-block; font-size:3em; margin-left: 50px;"><?= $apps ?></h1>
							</div>
						</div>
					</div>
				</div>



			</div>

		</div>
		<div class="row" style="padding-top: 50px;">
			<div class="col-w-11" style="float: none !important; margin: 0 auto;">
				<div class="panel panel-default">
					<div class="panel-head">
						<h3 class="panel-title">Recent Appointment Requests</h3>
					</div>
					<div class="panel-body">
						<p>Panel content goes here..</p>
						<p>Panel content goes here..</p>
						<p>Panel content goes here..</p>
						<p>Panel content goes here..</p>
						<p>Panel content goes here..</p>
						<p>Panel content goes here..</p>
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
