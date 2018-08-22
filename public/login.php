<?php
session_start();
/*************************************
* Including helpers.php file
* It has render function
* to render the header and footer
* file.
**************************************/
require_once('../includes/helpers.php');

// Checking if user is already logged in
// then redirect user to his/her dashboard
if(isset($_SESSION["username"]))
{
	if($_SESSION["usertype"] == 1)
		header('Location: /adopter/');

	if($_SESSION["usertype"] == 2)
		header('Location: /orphanage/');

}


if(isset($_POST["login"]) && $_POST["login"] == "Login")
{
	$errors = "";
    if(!isset($_POST["uname"]) || empty($_POST["uname"])) { $errors = '<p>Please enter your username.</p>'; }
    if(!isset($_POST["passwd"]) || empty($_POST["passwd"])) { $errors .= '<p>Please enter your password.</p>'; }

	if(empty($errors))
	{
		$username	= $_POST["uname"];
		$passwd		= $_POST["passwd"];

	    $conn = connect_db();
	    if(!$conn) { die("Connection failed - " . mysqli_connect_error($conn)); }

	    $sql = sprintf("SELECT * FROM login WHERE Username='%s'", mysqli_real_escape_string($conn, $username));
	    $rs = mysqli_query($conn, $sql);

	    if(!$rs) { die("Query failed - " . mysqli_error($conn)); }

	    if(mysqli_num_rows($rs) > 0)
	    {
			if($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
			{

				$username 		= $row["Username"];
				$hashedpasswd 	= $row["Password"];
				$usertype		= $row["UserType"];
				$userid			= $row["UserId"];

				if(password_verify($passwd, $hashedpasswd))
				{
					$_SESSION["username"] = $username;
					$_SESSION["usertype"] = $usertype;
					$_SESSION["userid"] = $userid;

					// Redirecting user to dashboard page
					if($usertype == 1)
	                	$redirect_url = "Location: http://" . $_SERVER["HTTP_HOST"] . "/adopter/profileinit.php";
					elseif($usertype == 2)
						$redirect_url = "Location: http://" . $_SERVER["HTTP_HOST"] . "/orphanage/profileinit.php";
	                header($redirect_url);
	                exit;
				}
				else
				{
					$errors .= '<p>Invalid password! try again.</p>';
				}
			}
	    }
	    else
	    {
			$errors .= '<p>Username not found.</p>';
	    }
	}
}




?>

<?php
/*************************************
* Render header file
* @param array $data
**************************************/
render('header', array('title' => 'Login | Online Orphanage Home', 'levelup' => '1', 'curpage' => 'login'));
?>


<div class="main">
    <div class="container clearfix full-section" style="background-color: #fff; padding-top: 30px !important;">
		<div class="col-w-3 accent-secondary" style="float: none !important; margin: 0 auto;">
			<h1 class="box-head txt-light">Log in to your account</h1>
			<hr style="border: 0; border-top: 1px solid rgba(255, 255, 255, 0.2);" />
            <div class="box">
            <!-- Main Page Block -->
                <div class="box-body">
                    <div class="box-body-container">
                        <div class="row">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-controls">
                            <br>
                            <?php
                                if(!empty($errors))
                                    echo '<div class="actNotify-red">' . $errors . '</div>';

								if(isset($_GET["alert"]) && $_GET["alert"] == "success")
								{
									echo '<div class="actNotify-green">' . $_SESSION["success"] . '. <a href="http://'. htmlspecialchars($_SERVER["HTTP_HOST"]) .'/#login">Login</a> to your account.</div>';
								}
                            ?>
							<div class="row form-controls-row">
								<label for="uname" class="txt-light">Enter Username:</label>
								<input style="width: 100%;" type="text" id="uname" name="uname" placeholder="username here" value="<?php if(isset($_POST["uname"])) echo htmlspecialchars($_POST["uname"]); ?>">
							</div>
							<div class="row form-controls-row">
								<label for="passwd" class="txt-light">Enter password:</label>
								<input style="width: 100%;" type="password" id="passwd" name="passwd" placeholder="password here">
							</div>
							<div class="row form-controls-btnrow">
								<input style="width: 100%;" type="submit" name="login" value="Login" class="btn txt-light accent-primary">
							</div>
							<div class="row form-controls-btnrow">
								<p style="font-size: 14px !important; color: #444;">Not registered yet? <a href="/register/" class="anim-link txt-light">Register now</a></p>
								<p style="font-size: 14px !important;"><a href="recoveraccount.php" class="anim-link txt-light">Forgotten password?</a></p>
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
					var usertype = document.getElementById("usertype");
					var target = document.getElementById("genderplaceholder");
				    usertype.onchange = function()
				    {
				        var selectedString = usertype.options[usertype.selectedIndex].value;
				        //console.log(selectedString);
						if(selectedString == 1)
						{
							target.innerHTML = '<div class="row form-controls-row" id="genderplaceholder"><label for="gender">Gender: <span class="mandatory">*</span></label><input style="width: 100%;" type="radio" id="male" name="gender" value="1"> <sapn class="txt-dark">Male </span><input style="width: 100%;" type="radio" id="female" name="gender" value="2" checked="checked"> <sapn class="txt-dark">Female</span></div>';
						}
						else if (selectedString == 2)
						{
							target.innerHTML = '<label for="medicalstore">Enter Your sore name: <span class="mandatory">*</span></label> <input style="width: 100%;" type="text" id="medicalstore" name="medicalstore" value="<?php if(isset($_POST["medicalsotre"])) echo $_POST["medicalsotre"]; ?>" placeholder="Your Medical Store name">';
						}
				    }
				</script>

        </div>
    </div>
</div>





<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer', array('levelup' => '1'));
?>
