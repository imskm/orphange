<?php
session_start();
/*************************************
* Including helpers.php file
* It has render function
* to render the header and footer
* file.
**************************************/
require_once('../includes/helpers.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link rel="icon" href="/favicon.png" type="image/png">
		<title>Home | Online Orphanage Home</title>
		<link rel="stylesheet" type="text/css" href="assets/css/base.css">
	</head>
	<body>
		<div class="row banner">
			<div class="container" style="padding: 15px 25px;">
				<header class="clearfix">
					<div class="logo">
						<h1>Online Orphanage Home</h1>
						<p>A place where people comes together.</p>
					</div>
					<div class="nav-menu nav-horizontal">
						<ul class="clearfix">
							<li><a href="/" class="under-bar">Home</a></li>
							<li><a href="/about/">About</a></li>
							<li><a href="/contact/">Contact</a></li>
							<li><a href="/faq/">FAQ</a></li>
							<li><a href="/register">Register</a></li>
							<li><a href="/login.php">Login</a></li>
						</ul>
					</div>
				</header>
				<div class="banner-text">
					<h1>Be great by adopting a child</h1>
					<p>We are an organisation that brings people together<br />so that no child is alone.</p>
					<a href="/about/" class="btn-hero">Know more</a>
				</div>
			</div>
		</div>

		<div class="row full-section accent-secondary">
			<div class="container tac">
				<h1 class="txt-light">Are you an orphanage organisation?</h1>
				<p class="txt-semi-dark div-center hero-para">Register your organisation with us. Your organistaion will be listed as an orphanage centre and an adopter can adopt child from your organisation.</p><br><br>
				<p class="div-center"><a href="aboutus/#org" class="anim-link txt-optional">Know more</a></p>
				<a href="register/?reg=org" class="btn btn-hero-sm accent-primary txt-light">Register</a>
			</div>
		</div>

		<div class="row full-section accent-primary">
			<div class="clearfix" style="width: 95%; margin: 0 auto;">
				<div class="col-w-3">
					<div class="adop-img">
					</div>
				</div>
				<div class="col-w-9 tal" style="padding-left: 30px; box-sizing: border-box;">
					<h1 class="txt-light tal">Do you want to adopt a child?</h1>
					<p class="txt-semi-dark tal hero-para" style="width: 100% !important">Adopt a child to make a child's wish true.<br/>You don't have to find all the organisation centre by visiting to their place, try our site, we have more than 100 (for now) verified orphanage centre.</p>
					<p class="txt-semi-dark tal hero-para" >Just Register, Search, Appoint, Adopt. As simple as that!</p>
					<a href="aboutus/#adop" class="anim-link txt-optional">Know more</a><br>
					<a href="register/?reg=adop" class="btn btn-hero-sm accent-secondary txt-light">Adopt a child</a>
				</div>
			</div>
		</div>
		<div class="row full-section sec-growth">
			<div class="container">
				<h1 class="txt-light">Adoption growth</h1>
			</div>
		</div>
		<div class="row full-section top-org">
			<div class="container clearfix">
				<h1 class="txt-dark">Top ranked orphanage home.</h1>

				<div class="col-w-6">
					<div class="row top-org-margin">
						<div class="img-thumbnail" style="background-image: url('assets/img/sites/top1.jpg')"></div>
						<div class="top-org-desc">
							<h3>Orphanage title</h3>
							<p>Location: Block 25, B.T. Road, Hayderabad<br /> Estd. 2002<br /><br /><a href="public/" class="anim-link">View details</a></p>
						</div>
					</div>
					<div class="row top-org-margin">
						<div class="img-thumbnail" style="background-image: url('assets/img/sites/top2.jpg')"></div>
						<div class="top-org-desc">
							<h3>Orphanage title</h3>
							<p>Location: Block 25, B.T. Road, Hayderabad<br /> Estd. 2002<br /><br /><a href="public/" class="anim-link">View details</a></p>
						</div>
					</div>
				</div>
				<div class="col-w-6">
					<div class="row top-org-margin">
						<div class="img-thumbnail" style="background-image: url('assets/img/sites/top3.jpg')"></div>
						<div class="top-org-desc">
							<h3>Orphanage title</h3>
							<p>Location: Block 25, B.T. Road, Hayderabad<br /> Estd. 2002<br /><br /><a href="public/" class="anim-link">View details</a></p>
						</div>
					</div>
					<div class="row top-org-margin">
						<div class="img-thumbnail" style="background-image: url('assets/img/sites/top4.jpg')"></div>
						<div class="top-org-desc">
							<h3>Orphanage title</h3>
							<p>Location: Block 25, B.T. Road, Hayderabad<br /> Estd. 2002<br /><br /><a href="public/" class="anim-link">View details</a></p>
						</div>
					</div>
				</div>
				<div class="tac"><a href="register/" class="btn btn-hero-sm accent-primary txt-light" style="clear: both; display: inline-block;">View more</a></div>
			</div>
		</div>
<?php
/*************************************
* Render footer file
* @param array $data
**************************************/
render('footer');
?>
