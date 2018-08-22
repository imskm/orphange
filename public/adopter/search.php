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

$conn = connect_db();

////////////////////////////////////////////
//  fetching places from database
//  for search by city drop down
////////////////////////////////////////////
$sql = "SELECT DISTINCT City FROM orphanage";
$rs = mysqli_query($conn, $sql);
if (!$rs) { die("Query failed - " . mysqli_error($conn)); }

if (mysqli_num_rows($rs) > 0) {
    while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
        $places[] = $row["City"];
    }
}

// Freein up result source
mysqli_free_result($rs);

if((isset($_POST["search"]) && $_POST["search"] == "Search") || (isset($_GET["city"])))
{
	$isSearch = true;

	// if its get request
	if(isset($_GET["city"]) && $_GET["city"] != "all")
	{
		$city = validate_form_data($conn, $_GET["city"]);
		$q = "";
	}
	else if(isset($_GET["city"]) && $_GET["city"] == "all")
	{
		$city = "";
		$q = "";
	}

	// if its post request
	if(isset($_POST["q"]))
	{
		$q = mysqli_real_escape_string($conn, $_POST["q"]);
		if(isset($_POST["city"]))
			$city = mysqli_real_escape_string($conn, $_POST["city"]);
		else
			$city = "";

	}



	$sql = sprintf("SELECT OId, OrgName, Address1, Address2, City, State, Photo, Website,
			Phone FROM orphanage_children_V WHERE City LIKE '%%%s%%' AND OrgName LIKE '%%%s%%' ORDER BY Children
			DESC LIMIT 30", $city, $q);
	$rs = mysqli_query($conn, $sql);
	if(!$rs) { die("Query failed - " . mysqli_error($conn)); }
	$rowfound = mysqli_num_rows($rs);

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
render('dashsidebar', array('levelup' => '2', 'fullname' => $_SESSION["fullname"], 'photo' => $_SESSION["photo"], 'curpage' => 'search'));
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
					<div class="panel-body">
						<h4 style="margin-bottom: 10px; color: #000;">Search orphanages centre</h4>
						<form class="form-controls" action="search.php" method="post">
				            <div class="row form-controls-row clearfix">
				                <div class="col-w-5">
				                    <select name="city" id="city" class="searchcity">
				                        <option disabled="disabled" selected>Select city</option>
										<?php
				                            for ($i = 0; $i < count($places); $i++) {
				                                echo '<option value="'. htmlspecialchars(ucwords(strtolower($places[$i]))) .'">'. htmlspecialchars(ucwords(strtolower($places[$i]))) .'</option>';
				                            }
				                        ?>
				                    </select>
				                </div>
				                <div class="col-w-5">
				                    <input type="text" name="q" class="searchcity" placeholder="Search organisation name.." value="<?php if(isset($_POST["q"])) echo $_POST["q"];?>">
				                </div>
								<div class="col-w-2">
									<input type="submit" name="search" value="Search" class="btn searchcity" style="padding-top: 10px; padding-bottom: 10px;">
				            	</div>
				            </div>
				        </form>

					</div>
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<div class="col-w-8" style="float: none !important; margin: 0 auto;">
				<div class="panel panel-default">
					<div class="panel-body">
						<p>Search results: <strong><?php if(isset($isSearch)) echo $rowfound; ?></strong></p><br/>
						<?php
							if(isset($isSearch))
							{
								if(mysqli_num_rows($rs) > 0)
								while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
								{
									echo '<div class="row top-org" style="margin-bottom: 10px; border-bottom: 1px solid #eaeaea;">';
									echo '<div class="img-thumbnail-sm" style="background-image: url(\''. htmlspecialchars($row["Photo"]) .'\')"></div>';
									echo '<div class="top-org-desc">';
									echo '<h4>'. htmlspecialchars($row["OrgName"]) .'</h4>';
									if(!empty($row["Website"]))
										echo '<p class="small-p"><i class="fa fa-map-marker" aria-hidden="true"></i> : '. htmlspecialchars($row["Address1"] . ' ' . $row["Address2"] . ', ' . $row["City"] . ', ' . $row["State"]) .'<br /><i class="fa fa-globe" aria-hidden="true"></i> <a href=http://"'. htmlspecialchars($row["Website"]) .'">'. htmlspecialchars($row["Website"]) .'</a> | <i class="fa fa-phone" aria-hidden="true"></i> '. htmlspecialchars($row["Phone"]) .'<br /><a href="orphanageprofile.php?oid='. htmlspecialchars($row["OId"]) .'"  class="anim-link" style="margin-top: 6px;">View details</a></p>';
									else
										echo '<p class="small-p"><i class="fa fa-map-marker" aria-hidden="true"></i> '. htmlspecialchars($row["Address1"] . ' ' . $row["Address2"] . ', ' . $row["City"] . ', ' . $row["State"]) .'<br /><i class="fa fa-phone" aria-hidden="true"></i> '. htmlspecialchars($row["Phone"]) .'<br /><a href="orphanageprofile.php?oid='. htmlspecialchars($row["OId"]) .'"  class="anim-link" style="margin-top: 6px;">View details</a></p>';
									echo '</div></div>';
								}
								else
								{
									echo '<p>No Orphanage found with the searched keyword.</p>';
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




</div>
<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer', array('levelup' => '2'))
?>
