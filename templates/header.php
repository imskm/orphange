<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="/favicon.png" type="image/png">
		<title><?php echo htmlspecialchars($title) ?></title>
		<?php
		    if($levelup == 1)
		        echo '<link rel="stylesheet" href="assets/css/base.css">';
		    if($levelup == 2)
		        echo '<link rel="stylesheet" href="../assets/css/base.css">';
		?>
	</head>
	<body>
		<div class="row accent-primary">
			<div class="container" style="padding: 15px 25px;">
				<header class="clearfix">
					<div class="logo">
						<a href="/">
							<h1>Online Orphanage Home</h1>
							<p>A place where people comes together.</p>
						</a>
					</div>
					<div class="nav-menu nav-horizontal">
						<ul class="clearfix">
						<?php
							$pages = array("home", "about", "contact", "faq", "register", "login");
							foreach ($pages as $page)
							{
								if($page == $curpage)
								{
									if($page == "login")
										echo '<li><a href="/'. $page .'.php" class="txt-semi-dark under-bar">'. ucfirst($page) .'</a></li>';
									else if($page == "home")
										echo '<li><a href="/" class="txt-semi-dark under-bar">'. ucfirst($page) .'</a></li>';
									else
										echo '<li><a href="/'. $page .'/" class="txt-semi-dark under-bar">'. ucfirst($page) .'</a></li>';
								}
								else
								{
									if($page == "login")
										echo '<li><a href="/'. $page .'.php" class="txt-semi-dark">'. ucfirst($page) .'</a></li>';
									else if($page == "home")
										echo '<li><a href="/" class="txt-semi-dark">'. ucfirst($page) .'</a></li>';
									else
										echo '<li><a href="/'. $page .'/" class="txt-semi-dark">'. ucfirst($page) .'</a></li>';
								}
							}
						?>
						</ul>
					</div>
				</header>
			</div>
		</div>
