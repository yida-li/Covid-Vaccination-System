<link rel="stylesheet" href="css/logout.css" />

<!-- header -->
<div class="header">
	<div class="jumbotron">
		<h1>COVID-19 Vaccination System</h1>
		<div style="float: left">
			<?php
				echo date("l dS Y");
			?>
		</div>
	</div>
	<?php
		if(isset($_SESSION['UserSession']))
	    {
    ?>

		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div>
					<ul class="nav navbar-nav">
						<li><a href="home.php">Home</a></li>
						<li><a href="employees.php">Employees</a></li>
                        <li><a href="person.php">Person</a></li>
                        <li><a href="facility.php">Facilities</a></li>
                        <li><a href="vaccine.php">Vaccines</a></li>
						<li><a href="group.php">Age Groups</a></li>
                        <li><a href="inventory.php">Inventory</a></li>
						<li><a href="province.php">Province</a></li>
						<li><a href="vaccination.php">Vaccination</a></li>
                         <li><a href="works.php">Workers</a></li>
						 <li><a href="managedBy.php">Managers</a></li>
                        <li class="logout"><a href="logout.php">Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
    
		<?php
	    }
	?>
</div>



<!-- /sub-header -->