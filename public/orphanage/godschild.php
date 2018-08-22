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

$userid = $_SESSION["userid"];
//echo $userid;

$sql = sprintf("SELECT ChId, FName, LName, Dob, Gender, Age, Colour FROM godchild WHERE OId=%s", $userid);
$conn = connect_db();
$rs = mysqli_query($conn, $sql);

if(mysqli_num_rows($rs) === 0)
	$notice = '<p>No child in the database! <a class="close">&#x2716;</a></p>';

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
render('dashsidebar', array('levelup' => '2', 'orgname' => $_SESSION["orgname"], 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'godschild'));
?>


<div class="col-w-10 dash-main">
	<div class="dash-header clearfix">
		<div class="col-w-11 dash-container"><h3 style="line-height: 60px;margin-left: 50px; color: #333;">Dashboard</h3></div>
		<div class="col-w-1"><a href="./logout.php" class="btn btn-logout" style="margin-top: 15px;">Logout</a></div>
	</div>

	<div class="dash-body">
		<div class="row">
			<div class="col-w-11" style="float: none !important; margin: 0 auto;">
				<h1 style="margin-bottom: 20px; font-family: 'Roboto regular'; font-size: 1.5em;">Manage Child</h1>
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
						<th>#</th>
						<th>Name</th>
						<th>Dob</th>
						<th>Age</th>
						<th>Gender</th>
						<th>Colour</th>
						<th class="tac">Edit</th>
					</tr>
					<?php
						if(mysqli_num_rows($rs) > 0)
						{
							$i = 1;
							while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
							{
								//print_r($row);
								//exit;
								echo '<tr>';
								echo '<td>'. $i .'</td>';
								echo '<td>'. htmlspecialchars($row["FName"] . ' ' . $row["LName"]) .'</td>';
								echo '<td>'. htmlspecialchars($row["Dob"]) .'</td>';
								echo '<td>'. htmlspecialchars($row["Age"]) .'</td>';
								if($row["Gender"] == 1)
									echo '<td>Male</td>';
								else
									echo '<td>Female</td>';
								echo '<td>'. htmlspecialchars($row["Colour"]) .'</td>';
								echo '<td class="tac"><a href="editchild.php?chid='. $row["ChId"] .'" class="btn btn-sm accent-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';

								echo '</tr>';
								$i++;
							}
						}

					?>
					<tr>
						<td colspan="7" class="tac"><a href="addchild.php" class="btn btn-sm accent-primary">+ Add Child</a></td>
					</tr>
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
