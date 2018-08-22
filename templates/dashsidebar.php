<div class="col-w-2 dash-sidebar accent-primary">
	<div class="brand-header" style="background-color: #05ccbe;">
		<h3>OOH</h3>
	</div>

	<div class="dash-container user-info">
		<div class="user-avatar" style="background-image: url('<?php echo htmlspecialchars($photo); ?>');"></div>
		<h3>
			<?php
				if($_SESSION["usertype"] == 1)
					echo htmlspecialchars($fullname);

				if($_SESSION["usertype"] == 2)
					echo htmlspecialchars($orgname);
			?>
		</h3>
		<?php
			if($_SESSION["usertype"] == 1)
				echo '<p>Adopter</p>';

			if($_SESSION["usertype"] == 2)
			{
				echo '<p>Organisation</p>';
				echo '<p>Person Incharge - '. htmlspecialchars($fullname) .'</p>';

			}
		?>
	</div>

	<div class="dash-menu">
		<ul>
			<li><a><i class="fa fa-bars" aria-hidden="true"></i>Menu</a></li>
			<?php
				if($_SESSION["usertype"] == 1)
					$pages = array("home", "appointments", "search", "adoptions", "donation", "settings");

				if($_SESSION["usertype"] == 2)
					$pages = array("home", "appointments", "godschild", "donation", "settings");

				foreach ($pages as $page)
				{
					if($page == $curpage)
					{
						switch ($page)
						{
							case 'home':
								echo '<li class="active"><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>';
								break;
							case 'appointments':
								echo '<li class="active"><a href="'. $page .'.php"><i class="fa fa-calendar-o" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;
							case 'search':
								echo '<li class="active"><a href="'. $page .'.php"><i class="fa fa-search" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;
							case 'godschild':
								echo '<li class="active"><a href="'. $page .'.php"><i class="fa fa-child" aria-hidden="true"></i>Manage Children</a></li>';
								break;
							case 'adoptions':
								echo '<li class="active"><a href="'. $page .'.php"><i class="fa fa-child" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;
							case 'donation':
								echo '<li class="active"><a href="'. $page .'.php"><i class="fa fa-heart" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;
							case 'settings':
								echo '<li class="active"><a href="'. $page .'.php"><i class="fa fa-cog" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;

							default:
								# code...
								break;
						}
					}
					else
					{
						switch ($page)
						{
							case 'home':
								echo '<li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>';
								break;
							case 'appointments':
								echo '<li><a href="'. $page .'.php"><i class="fa fa-calendar-o" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;
							case 'search':
								echo '<li><a href="'. $page .'.php"><i class="fa fa-search" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;
							case 'godschild':
								echo '<li><a href="'. $page .'.php"><i class="fa fa-child" aria-hidden="true"></i>Manage Children</a></li>';
								break;
							case 'adoptions':
								echo '<li><a href="'. $page .'.php"><i class="fa fa-child" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;
							case 'donation':
								echo '<li><a href="'. $page .'.php"><i class="fa fa-heart" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;
							case 'settings':
								echo '<li><a href="'. $page .'.php"><i class="fa fa-cog" aria-hidden="true"></i>'. ucfirst($page) .'</a></li>';
								break;

							default:
								# code...
								break;
						}
					}
				}
			?>


		</ul>
	</div>

</div>
