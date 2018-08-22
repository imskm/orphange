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
		<div class="col-w-8" style="float: none !important; margin: 0 auto;">
            <div class="box">
				<div class="step-bar tac">
					<span class="accent-secondary txt-light">1</span><i style="color: #a8a8a8;">Fill up your details</i><i class="rarrow"></i>
					<i style="color: #a8a8a8;">Upload your image</i><span class="accent-secondary txt-light">2</span>
				</div>
            <!-- Main Page Block -->
                <div class="box-body">
                    <div class="box-body-container">
                        <div class="row tac">
							<br /><br />
                            <?php
                                if(!empty($errors))
                                    echo '<div class="actNotify-red">' . $errors . '</div>';

								if(isset($_GET["alert"]) && $_GET["alert"] == "success")
								{
									echo '<div class="actNotify-green">
									<h2 style="color: #0A0; font-size: 18px; text-align: center;">Successful!</h2>' . $_SESSION["success"] . '. <a href="http://'. htmlspecialchars($_SERVER["HTTP_HOST"]) .'/login.php">Login</a> to your account.</div>';
								}
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
render('footer', array('levelup' => '2'));
?>
