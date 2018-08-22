<?php
session_start();
//Error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);
/*************************************
* Including helpers.php file
* It has render function
* to render the header and footer
* file.
**************************************/
require_once('../../includes/helpers.php');
require_once('../../includes/modules.php');

// Redirect the user if he/she has not came from step 1
// if(!isset($_SESSION["usertype"]))
//	header('Location: /register/');

if(isset($_POST["upload"]) && $_POST["upload"] == "Upload")
{
	$errors = "";

    if(!isset($_FILES["photo"]) && empty($_FILES["photo"])) { $errors = '<p>Please select an image file to upload.</p>'; }

	// Image file validation for
	// size and MIME type
	if(isset($_FILES["photo"]) && !empty($_FILES["photo"]))
	{
		if($_FILES["photo"]["type"] != "image/jpeg")
			if($_FILES["photo"]["type"] != "image/png")
				$errors .= '<p>Please upload a jpeg or png file.</p>';

		if(intval($_FILES["photo"]["size"]) > 153600)
			$errors .= '<p>Image size is large, please upload an image below 150kb.</p>';
	}

	switch ($_SESSION["usertype"]) // $_SESSION["usertype"]
	{
		case '1':	// for adopter
			if(isset($_FILES["poi"]) && !empty($_FILES["poi"]))
			{
				if($_FILES["poi"]["type"] != "image/jpeg")
					if($_FILES["poi"]["type"] != "image/png")
						$errors .= '<p>Please upload a jpeg or png file.</p>';

				if(intval($_FILES["poi"]["size"]) > 153600)
					$errors .= '<p>Image size is large, please upload an image below 150kb.</p>';
			}
			if(isset($_FILES["poa"]) && !empty($_FILES["poa"]))
			{
				if($_FILES["poa"]["type"] != "image/jpeg")
					if($_FILES["poa"]["type"] != "image/png")
						$errors .= '<p>Please upload a jpeg or png file.</p>';

				if(intval($_FILES["poa"]["size"]) > 153600)
					$errors .= '<p>Image size is large, please upload an image below 150kb.</p>';
			}

			if(empty($errors))
			{
				$usrfName = "photo";	// file input element name sent from browser
				$usrupfName = date("Ymdhis");
				$usrfPath = "../assets/img/usr/";
				if($_FILES["photo"]["type"] == "image/jpeg")
					$usrfExt = "jpg";
				else
					$usrfExt = "png";

				$poifName = "poi";	// file input element name sent from browser
				$poafName = "poa";	// file input element name sent from browser
				$poiupfName = 'poi_' . date("Ymdhis");
				$poaupfName = 'poa_' . date("Ymdhis");

				$docfPath = "../assets/img/usr/docs/";
				if($_FILES["poi"]["type"] == "image/jpeg")
					$poifExt = "jpg";
				else
					$poifExt = "png";
				if($_FILES["poa"]["type"] == "image/jpeg")
					$poafExt = "jpg";
				else
					$poafExt = "png";

				if(
					upload_file($usrfName, $usrupfName, $usrfPath, $usrfExt) &&
					upload_file($poifName, $poiupfName, $docfPath, $poifExt) &&
					upload_file($poafName, $poaupfName, $docfPath, $poafExt)
				  )
				{
					$usrupPath = "/assets/img/usr/" . $usrupfName . "." . $usrfExt;
					$poiupPath = "/assets/img/usr/docs/" . $poiupfName . "." . $poifExt;
					$poaupPath = "/assets/img/usr/docs/" . $poaupfName . "." . $poafExt;
					$conn = connect_db();

					$sql = sprintf("UPDATE adopter set Photo='%s', Poi='%s', Poa='%s' WHERE AdopId=%s", $usrupPath, $poiupPath, $poaupPath, $_SESSION["userid"]);

					$rs = mysqli_query($conn, $sql);
				    if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

					// Closing Connection
					mysqli_close($conn);
					header("Location: final.php?alert=success");

				}
				else
					die("Failed to upload image");
			}
			break;
		case '2':
			if(empty($errors))
			{
				$usrfName = "photo";	// file input element name sent from browser
				$usrupfName = date("Ymdhis");
				$usrfPath = "../assets/img/usr/";
				if($_FILES["photo"]["type"] == "image/jpeg")
					$usrfExt = "jpg";
				else
					$usrfExt = "png";

				//echo $usrupfName;
				//echo $usrfExt;
				//exit;
				if(upload_file($usrfName, $usrupfName, $usrfPath, $usrfExt))
				{
					$upPath = "/assets/img/usr/" . $usrupfName . "." . $usrfExt;
					$conn = connect_db();

					$sql = sprintf("UPDATE orphanage set Photo='%s' WHERE OId=%s", $upPath, $_SESSION["userid"]);

					$rs = mysqli_query($conn, $sql);
				    if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

					// Closing Connection
					mysqli_close($conn);
					header("Location: final.php?alert=success");
				}
				else
					die("Failed to upload image");
			}
	}
}



?>

<?php
/*************************************
* Render header file
* @param array $data
**************************************/
render('header', array('title' => 'Register | Online Orphanage Home', 'levelup' => '2', 'curpage' => 'register'));
?>


<div class="main accent-secondary">
    <div class="container clearfix full-section" style="background-color: #fff; padding-top: 30px !important;">
		<h1 class="box-head txt-primary">Registration page for adopter or orphanage centre</h1>
		<hr style="border-top: 1px solid rgba(0, 0, 0, 0.05);" />
		<div class="col-w-12">
            <div class="box">
				<div class="step-bar tac">
					<span class="accent-secondary txt-light">1</span><i style="color: #a8a8a8;">Fill up your details</i><i class="rarrow"></i>
					<i style="color: #a8a8a8;">Upload your image</i><span class="accent-secondary txt-light">2</span>
				</div>
            <!-- Main Page Block -->
                <div class="box-body">
                    <div class="box-body-container">
                        <div class="row tac">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-controls" enctype="multipart/form-data">
                            <br>
                            <?php
                                if(!empty($errors))
                                    echo '<div class="actNotify-red">' . $errors . '</div>';

								if(isset($_GET["alert"]) && $_GET["alert"] == "success")
								{
									echo '<div class="actNotify-green">' . $_SESSION["success"] . '</div>';
								}
                            ?>
							<div class="col-w-9 clearfix" style="float: none !important; margin: 0 auto;">
								<div class="col-w-4" <?php if(!isset($_SESSION["usertype"]) && $_SESSION["usertype"] != 1) echo 'style="float: none !important; margin: 0 auto;"'; ?>>
									<div class="row form-controls-row">
										<p>Select your photo</p>
										<div id="iFile" class="upload-img img-thumbnail"></div>
									</div>
									<div class="row form-controls-row">
										<input type="file" id="photo" name="photo" style="border: 1px solid #ddd; border-radius: 4px; padding: 7px 2px;" value="">
									</div>
								</div>

								<?php if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 1): ?>
									<div class="col-w-4">
										<div class="row form-controls-row">
											<p>Upload your Proof of Identity</p>
											<div id="iFile" class="upload-img img-thumbnail"></div>
										</div>
										<div class="row form-controls-row">
											<input type="file" id="poi" name="poi" style="border: 1px solid #ddd; border-radius: 4px; padding: 7px 2px;" value="">
										</div>
									</div>
									<div class="col-w-4">
										<div class="row form-controls-row">
											<p>Upload your Proof of Address</p>
											<div id="iFile" class="upload-img img-thumbnail"></div>
										</div>
										<div class="row form-controls-row">
											<input type="file" id="poa" name="poa" style="border: 1px solid #ddd; border-radius: 4px; padding: 7px 2px;" value="">
										</div>
									</div>
								<?php endif ?>


							</div>
                                <br />

                                <div class="row form-controls-btnrow tac">
                                    <input type="submit" name="upload" value="Upload" class="btn txt-light accent-primary">
                                    <?php //<p style="font-family: 'Roboto light'; font-size: 13px; width: auto; margin-top: 14px;"><a class="txt-optional" href="/login.php">Skip</a> - I&apos;ll upload it letter.</p> ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>

                <?php
                /////////////////////////////////////////////
                // JavaScript to add node for gender
                ////////////////////////////////////////////
                ?>
				<script type="text/JavaScript">
					var photo = document.getElementById("photo");
					console.log(photo.value);
					var target = document.getElementById("iFile");
				    function get_img_path()
				    {
				        var iPath = photo.value;
				        console.log(iPath);
						return;
						if(selectedString == 1)
						{
							target.innerHTML = '<div class="row form-controls-row" id="genderplaceholder"><label for="gender">Gender: <span class="mandatory">*</span></label><input type="radio" id="male" name="gender" value="1"> <sapn class="txt-dark">Male </span><input type="radio" id="female" name="gender" value="2" checked="checked"> <sapn class="txt-dark">Female</span></div>';
							target.innerHTML += '<div class="row form-controls-row" id="genderplaceholder"><label for="aadhaar">Aadhaar number: <span class="mandatory">*</span></label> <input type="text" id="aadhaar" name="aadhaar" placeholder="Aadhaar number (0000 0000 0000)" value="<?php if(isset($_POST["aadhaar"])) echo htmlspecialchars($aadhaar); ?>" maxlength="12"></div>';
						}
						else if (selectedString == 2)
						{
							target.innerHTML = '<div class="row form-controls-row" id="genderplaceholder"><label for="orgname">Your organisation name: <span class="mandatory">*</span></label> <input type="text" id="orgname" name="orgname" value="<?php if(isset($_POST["orgname"])) echo $_POST["orgname"]; ?>" placeholder="Organisation name"></div>';
							target.innerHTML += '<div class="row form-controls-row" id="genderplaceholder"><label for="regno">Registration number of organisation: <span class="mandatory">*</span></label> <input type="text" id="regno" name="regno" value="<?php if(isset($_POST["regno"])) echo $_POST["regno"]; ?>" placeholder="Registration number"></div>';
						}
				    }
					photo.addEventListener("onchange", get_img_path);
				</script>

        </div>
    </div>
</div>





<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer', array('levelup' => '2'));
?>
