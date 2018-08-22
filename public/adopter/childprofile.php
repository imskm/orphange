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

if(isset($_GET["chid"]))
{
	$isSearch = true;
	$chid = validate_form_data($conn, $_GET["chid"]);

	$sql = sprintf("SELECT * FROM godchild WHERE chid=%s", $chid);

	$rs = mysqli_query($conn, $sql);
	if(!$rs) { die("Query failed - " . mysqli_error($conn)); }
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
render('dashsidebar', array('levelup' => '2', 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'adoptions'));
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
						<h1 class="panel-title">Child Profile</h1>
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
									echo '<table width="100%" class="table">';

									echo '<tr>';
									echo '<th>Name</th>';
									echo '<td>'. htmlspecialchars($row["FName"] . ' ' . $row["LName"]) . '</td>';
									echo '</tr>';
									echo '<tr>';
									echo '<th>Gender</th>';
									if($row["Gender"] == 1)
										echo '<td colspan="3">Male</td>';
									else
										echo '<td colspan="3">Female</td>';
									echo '</tr>';

									echo '<tr>';
									echo '<th>Dob</th>';
									echo '<td>'. htmlspecialchars($row["Dob"]) . '</td>';
									echo '</tr>';

									echo '<tr>';
									echo '<th>Age</th>';
									echo '<td>'. htmlspecialchars($row["Age"]) . ' years</td>';
									echo '</tr>';
									echo '<tr>';
									echo '<th>Colour</th>';
									echo '<td>'. htmlspecialchars($row["Colour"]) . '</td>';
									echo '</tr>';

									echo '<tr>';
									echo '<td colspan="2" class="tac"><a href="'. htmlspecialchars($_SERVER["HTTP_REFERER"]) . '" title="Go back" class="btn btn-sm accent-primary"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Go back</a></td>';
									echo '</tr>';
								}
							}
								else echo 'No Children found!';
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
