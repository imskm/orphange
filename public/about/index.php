<?php
session_start();
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
render('header', array('title' => 'Register | Online Orphanage Home', 'levelup' => '2', 'curpage' => 'about'));
?>


<div class="main accent-secondary">
    <div class="container clearfix full-section" style="background-color: #fff; padding-top: 30px !important;">
		<h1 class="box-head txt-primary">Know about us</h1>
		<hr style="border-top: 1px solid rgba(0, 0, 0, 0.05);" />
		<div class="col-w-8" style="float: none !important; margin: 0 auto;">
			<h3>Who are we?</h3>
			<p>We are a community</p>

			<h3>What do we do?</h3>
			<p>We are a community</p>

			<h3>Who can use this site?</h3>
			<p>We are a community</p>

			<h3>How this system works?</h3>
			<p>We are a community</p>

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
