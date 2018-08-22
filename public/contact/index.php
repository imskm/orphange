<?php
session_start();
/*************************************
* Including helpers.php file
* It has render function
* to render the header and footer
* file.
**************************************/
require_once('../../includes/helpers.php');


if(isset($_POST["submit"]) && $_POST["submit"] == "Submit")
{

	if(!isset($_POST["phone"]) || $_POST["phone"] == "") { $errors = '<p><span class="mandatory">*</span> marked fields are mandatory.</p>'; }
    if(!isset($_POST["email"]) || $_POST["email"] == "") { $errors = '<p><span class="mandatory">*</span> marked fields are mandatory.</p>'; }

	if($_POST["phone"] != "" && !is_num($_POST["phone"])) { $errors .= '<p>Not a valid phone number.</p>'; }

	if(empty($errors))
	{
		$conn = connect_db();
		if(!$conn) { die("Connection failed - " . mysqli_connect_error($conn)); }

		$email		= mysqli_real_escape_string($conn, $_POST["email"]);
		$phone		= mysqli_real_escape_string($conn, $_POST["phone"]);

		if(isset($_POST["name"]) && !empty($_POST["name"])) { $name = mysqli_real_escape_string($conn, $_POST["name"]); } else { $name = ""; }
		if(isset($_POST["msg"]) && !empty($_POST["msg"])) { $msg = mysqli_real_escape_string($conn, $_POST["msg"]); } else { $msg = ""; }

		// Casing user details
		$name = ucwords(strtolower($name));
		$email = strtolower($email);

		///////////////////////////////////
		// Step 1: Inserting user
		//   contact info in table
		///////////////////////////////////
		$sql = sprintf("INSERT INTO contact(Name, Email, Phone, Message)
				VALUES('%s', '%s', '%s', '%s')", $name, $email, $phone, $msg);

		$rs = mysqli_query($conn, $sql);
	    if(!$rs)
			die("Query failed - " . mysqli_error($conn));
		else
			header('Location: ' . htmlspecialchars($_SERVER["PHP_SELF"]) . '?alert=success');

		// Closing Connection
		mysqli_close($conn);
	}
}

?>

<?php
/*************************************
* Render header file
* @param array $data
**************************************/
render('header', array('title' => 'Contact | Online Orphanage Home', 'levelup' => '2', 'curpage' => 'contact'));
?>


<div class="main">
    <div class="container clearfix full-section" style="background-color: #fff; padding-top: 30px !important;">
		<div class="col-w-4 accent-secondary" style="float: none !important; margin: 0 auto;">
			<h1 class="box-head txt-light">Contact and join us</h1>
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
									echo '<div class="actNotify-green"><h3 style="color: #0A0;">Thanks for giving your valuable time!</h3><p>We will Contact you soon.</p></div>';
								}
                            ?>
							<div class="row form-controls-row">
								<label for="name" class="txt-semi-dark">Enter your full name:</label>
								<input type="text" style="width: 100%" id="name" name="name" placeholder="Full name" value="<?php if(isset($_POST["name"])) echo htmlspecialchars($_POST["name"]); ?>">
							</div>
							<div class="row form-controls-row">
								<label for="email" class="txt-semi-dark">Enter your email address:<span class="mandatory">*</span></label>
								<input type="text" style="width: 100%" id="email" name="email" placeholder="Email address" value="<?php if(isset($_POST["email"])) echo htmlspecialchars($_POST["email"]); ?>">
							</div>
							<div class="row form-controls-row">
								<label for="phone" class="txt-semi-dark">Enter your mobile number:<span class="mandatory">*</span></label>
								<input type="text" style="width: 100%" id="phone" name="phone" placeholder="Mobile number" value="<?php if(isset($_POST["phone"])) echo htmlspecialchars($_POST["phone"]); ?>" maxlength="10">
							</div>
							<div class="row form-controls-row">
								<label for="msg" class="txt-semi-dark">Write message:</label>
								<textarea  style="width: 100%" id="msg" name="msg" placeholder="Write your message.." rows="6"><?php if(isset($_POST["msg"])) echo htmlspecialchars($_POST["msg"]); ?></textarea>
							</div>
							<div class="row form-controls-btnrow">
								<input type="submit" name="submit" value="Submit" class="btn txt-light accent-primary">
							</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row full-section accent-primary contact">
	<div class="container clearfix">
		<div class="col-w-5 tal">
			<div class="brand-logo"><img src="../assets/img/sites/logo.png"></div>
			<div style="display: inline-block; vertical-align: top; margin-left: 25px">
				<h2 class="txt-light">Online Orphange Home</h2>
				<a href="/about/" class="btn btn-hero-sm accent-secondary txt-dark">Know more</a>
			</div>
		</div>
		<div class="col-w-3 tal"></div>
		<div class="col-w-4 tar">
			<h3>Address</h3>
			<p>25/2, N.C. Raod<br>Kankinara, 24 PGS (N) - PIN 743126<br>Kankinara, West Bengal<br>India</p>
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
