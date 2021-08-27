<?php
	require_once 'database.php';
	session_start();

	if(!isset($_SESSION['UserSession']))
	{
		header('Location: index.php');
		die();
	}

    function function_alert($message) {
        // Display the alert box 
        echo "<script>alert('$message');</script>";
    }

	if(isset($_POST['delete']))
	{
        
		$STH = $DBH->prepare("DELETE FROM vaccination WHERE vaccinationID=$_POST[id]");
		$STH->execute();	
	}

	if(isset($_POST['add']))
	{
        /*$STH = $DBH->prepare("SELECT * FROM inventory WHERE facilityID=? AND vID=?");
        $STH->bindParam(1, $_POST['f_id']);
        $STH->bindParam(2, $_POST['v_id']);

        $row = $STH->fetch();

        
        function_alert($row['quantity']);
        
        if($row['quantity'] < 1)
        {
            //function_alert('No sufficiant amount in the inventory for this vaccine');
        }

        else
        {
        }*/

        $STH = $DBH->prepare("UPDATE inventory SET quantity=quantity-1 WHERE facilityID=? AND vID=?");

        $STH->bindParam(1, $_POST['f_id']);
        $STH->bindParam(2, $_POST['v_id']);
        
		$STH->execute();
      

        $STH = $DBH->prepare("INSERT INTO vaccination (employeeID, pID, groupNo, vID, facilityID, dateVaccinated, isInfected, dateInfection, infectionType, doseNo) VALUES (?,?,?,?,?,?,?,?,?,?)");
        
        $STH->bindParam(1, $_POST['e_id']);
        $STH->bindParam(2, $_POST['p_id']);
        $STH->bindParam(3, $_POST['group']);
        $STH->bindParam(4, $_POST['v_id']);
        $STH->bindParam(5, $_POST['f_id']);
        $STH->bindParam(6, $_POST['vax_date']);
        $STH->bindParam(7, $_POST['i_status']);
        $STH->bindParam(8, $_POST['i_date']);
        $STH->bindParam(9, $_POST['i_type']);
        $STH->bindParam(10, $_POST['dose']);

        $STH->execute();
	}

?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script type="text/javascript">
            function validate(form) {
                return confirm('Are you certain?');
            }
        </script>
    </head>

    <body>

        <div class="container">
            <?php include 'header.php' ?>
                <!-- container -->
                <!-- content -->

                <!--Search Bar -->
                <form method="post" align="right" class="navbar-form navbar-center" role="search">
                    <div class="form-group">
                        <input name="search" type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                    <?php
                    if(isset($_POST['search']))//used for searching
                    {
                ?>
                        <button onclick="window.location=window.location.href" class="btn btn-default">Undo Search</button>
                        <?php
                    }
                ?>

                </form>
                
                <!-- Edit -->
                <div class="content">
                
                    <!-- Employee Record -->
                    <?php
						if(isset($_POST['eID']))
						{
							$STH = $DBH->query("SELECT * FROM employees WHERE employeeID = $_POST[eID]");
					?>
                        <div class="panel panel-primary" style="width:1500px">

                            <div class="panel-heading">
                                Employee Info
                            </div>

                            <div class="panel-body">
                                <form role="form" method="post">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Employee ID</th>
                                                <th>Medicare ID</th>
                                                <th>SSN</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>Province</th>
                                                <th>Email</th>
                                                <th>Citizenship</th>
                                                <th>Postal Code</th>
                                                <th>Phone Number</th>
                                                <th>Birth Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                    <?php            
                        
                        while($row = $STH->fetch())
						{
                    ?>                   
                                            <tr>

                                                    <td>
                                                        <?= $row['employeeID'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['medicareID'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['SSN'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['fName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['lName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['address'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['city'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['province'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['email'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['citizen'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['postalCode'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['phone'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['dob'] ?>
                                                    </td>
                                            </tr>
                    <?php
                        }
                    ?>
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-info" name="submit_close">Close</button>
                                </form>
                            </div>
                        </div>
                    <?php
						}
					?> 

                    <!-- Person Record -->
                    <?php
						if(isset($_POST['pID']))
						{
							$STH = $DBH->query("SELECT * FROM person WHERE pID = $_POST[pID]");
					?>
                        <div class="panel panel-primary" style="width:1500px">

                            <div class="panel-heading">
                                Person Info
                            </div>

                            <div class="panel-body">
                                <form role="form" method="post">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Person ID</th>
                                                <th>Medicare ID</th>
                                                <th>SSN</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>Province</th>
                                                <th>Email</th>
                                                <th>Citizenship</th>
                                                <th>Postal Code</th>
                                                <th>Phone Number</th>
                                                <th>Birth Date</th>
                                                <th>Group No</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                    <?php            
                        
                        while($row = $STH->fetch())
						{
                    ?>                   
                                            <tr>

                                                    <td>
                                                        <?= $row['pID'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['medicareID'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['SSN'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['fName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['lName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['address'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['city'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['province'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['email'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['citizen'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['postalCode'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['phone'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['dob'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['groupNo'] ?>
                                                    </td>
                                            </tr>
                    <?php
                        }
                    ?>
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-info" name="submit_close">Close</button>
                                </form>
                            </div>
                        </div>
                    <?php
						}
					?> 


                    <!-- Age Group Record -->
                    <?php
						if(isset($_POST['gID']))
						{
							$STH = $DBH->query("SELECT * FROM ageGroup WHERE groupNo = $_POST[gID]");
					?>
                        <div class="panel panel-primary" style="width:1500px">

                            <div class="panel-heading">
                                Group Info
                            </div>

                            <div class="panel-body">
                                <form role="form" method="post">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Group No</th>
                                                <th>Minimum Age</th>
                                                <th>Maximum Age</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                    <?php            
                        
                        while($row = $STH->fetch())
						{
                    ?>                   
                                            <tr>

                                                    <td>
                                                        <?= $row['groupNo'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['minAge'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['maxAge'] ?>
                                                    </td>
                                            </tr>
                    <?php
                        }
                    ?>
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-info" name="submit_close">Close</button>
                                </form>
                            </div>
                        </div>
                    <?php
						}
					?> 


                    <!-- Vaccine Record -->
                    <?php
						if(isset($_POST['vID']))
						{
							$STH = $DBH->query("SELECT * FROM vaccine WHERE vID = $_POST[vID]");
					?>
                        <div class="panel panel-primary" style="width:1500px">

                            <div class="panel-heading">
                                Vaccine Info
                            </div>

                            <div class="panel-body">
                                <form role="form" method="post">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Vaccine ID</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Description</th>
                                                <th>Approval Date</th>
                                                <th>Suspension Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                    <?php            
                        
                        while($row = $STH->fetch())
						{
                    ?>                   
                                            <tr>

                                                    <td>
                                                        <?= $row['vID'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['vName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['vaccineStatus'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['description'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['dateApproval'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['dateSuspension'] ?>
                                                    </td>
                                            </tr>
                    <?php
                        }
                    ?>
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-info" name="submit_close">Close</button>
                                </form>
                            </div>
                        </div>
                    <?php
						}
					?> 


                    <!-- Facility Record -->
                    <?php
						if(isset($_POST['fID']))
						{
							$STH = $DBH->query("SELECT * FROM healthFacility WHERE facilityID = $_POST[fID]");
					?>
                        <div class="panel panel-primary" style="width:1500px">

                            <div class="panel-heading">
                                Facility Info
                            </div>

                            <div class="panel-body">
                                <form role="form" method="post">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>City</th>
                                                <th>Province</th>
                                                <th>Address</th>
                                                <th>Postal Code</th>
                                                <th>Website</th>
                                                <th>Phone</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                    <?php            
                        
                        while($row = $STH->fetch())
						{
                    ?>                   
                                            <tr>

                                                    <td>
                                                        <?= $row['facilityID'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['hName'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['type'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['city'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['province'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['address'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['postalCode'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['webAddress'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['phone'] ?>
                                                    </td>
                                            </tr>
                    <?php
                        }
                    ?>
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-info" name="submit_close">Close</button>
                                </form>
                            </div>
                        </div>
                    <?php
						}
					?> 


                        <!-- Main Display -->
                            <div class="panel panel-primary" style="width: 2000px">
                                <div class="panel-heading" style="height: 50px">
                                    Vaccination

                                    <div style="float: right;">
                                        <a class="btn btn-info" href="print.php?table=inventory">Print</a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h3 align="center">Vaccination Information</h3>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Vaccination ID</th>
                                                <th>Employee ID</th>
                                                <th>Person ID</th>
                                                <th>Group No</th>
                                                <th>Vaccine ID</th>
                                                <th>Facility ID</th>
                                                <th>Date Vaccinated</th>
                                                <th>Infection Status</th>
                                                <th>Date Infection</th>
                                                <th>Infection Type</th>
                                                <th>Dose No</th>

                                                <th class="text-danger">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            
                                            //used for searching
                                            if(isset($_POST['search']))
                                            {
                                                $search = $_POST['search'];
                                            }
                                        
                                            $STH = $DBH->query(
                                                "SELECT * FROM vaccination ORDER BY dateVaccinated" . 
                                                (isset($search) ? //used for searching
                                                 "WHERE isInfected LIKE '%$search%' OR doseNo LIKE '%$search' " : //used for searching
                                                 "") //used for searching
                                                ); 

										while($row = $STH->fetch())
										{
								?>
                                                <tr>
                                                    <td>
                                                        <?= $row['vaccinationID'] ?>
                                                    </td>

                                                    <td>
                                                        <form method="post">
                                                            <input type="submit" class="btn btn-default" style="width:100px" name="eID" value="<?= $row['employeeID'] ?>">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <form method="post">
                                                            <input type="submit" class="btn btn-default" style="width:50px" name="pID" value="<?= $row['pID'] ?>">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <form method="post">
                                                            <input type="submit" class="btn btn-default" style="width:50px" name="gID" value="<?= $row['groupNo'] ?>">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <form method="post">
                                                            <input type="submit" class="btn btn-default" style="width:50px" name="vID" value="<?= $row['vID'] ?>">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <form method="post">
                                                            <input type="submit" class="btn btn-default" style="width:50px" name="fID" value="<?= $row['facilityID'] ?>">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <?= $row['dateVaccinated'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['isInfected'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['dateInfection'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['infectionType'] ?>
                                                    </td>

                                                    <td>
                                                        <?= $row['doseNo'] ?>
                                                    </td>

                                                    <td>
                                                        <form method="post" onsubmit="return validate(this);">
                                                            <input type="hidden" name="id" value="<?= $row['vaccinationID'] ?>">
                                                            <input type="submit" class="btn btn-danger" value="Delete" name="delete">
                                                        </form>
                                                    </td>

                                                </tr>

                                                <?php
										}
									?>

                                        </tbody>
                                    </table>


                                    <!--Add Button-->
                                    <button class="btn btn-warning" data-toggle="collapse" data-target="#demo">Add</button>


                                    <div id="demo" class="collapse" style="margin-top:10px">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Add Vaccination
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">
                                                    <form role="form" method="post">
                                                        
                                                        <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                        
                                                        <div class="form-group">
                                                            <label for="e_id">Employee</label>
                                                            <select class="form-control" name="e_id">

                                                                <?php
                                                                    $STH = $DBH->query("SELECT * FROM employees");
                                                                    while($row = $STH->fetch())
                                                                    {
                                                                ?>
                                                                    <option value="<?= $row['employeeID'] ?>">
                                                                        <?= $row['employeeID'] . " " . $row['fName'] . " " . $row['lName']?>
                                                                    </option>
                                                                 <?php
                                                                    }
                                                                ?>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="p_id">Person</label>
                                                            <select class="form-control" name="p_id">

                                                                <?php
                                                                    $STH = $DBH->query(
                                                                    "SELECT * FROM person");
                                                                    while($row = $STH->fetch())
                                                                    {
                                                                ?>
                                                                    <option value="<?= $row['pID'] ?>">
                                                                        <?= $row['pID'] . " " . $row['fName'] . ' ' . $row['lName'] ?>
                                                                    </option>
                                                                 <?php
                                                                    }
                                                                ?>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="group">Group No</label>
                                                            <select class="form-control" name="group">

                                                                <?php
                                                                    $STH = $DBH->query(
                                                                    "SELECT * FROM ageGroup");
                                                                    while($row = $STH->fetch())
                                                                    {
                                                                ?>
                                                                    <option value="<?= $row['groupNo'] ?>">
                                                                        <?= $row['groupNo'] . " (" . $row['minAge'] . '-' . $row['maxAge'] . ")"?>
                                                                    </option>
                                                                 <?php
                                                                    }
                                                                ?>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="v_id">Vaccine</label>
                                                            <select class="form-control" name="v_id">

                                                                <?php
                                                                    $STH = $DBH->query(
                                                                    "Select * From vaccine WHERE vaccineStatus = 'SAFE' ");
                                                                    while($row = $STH->fetch())
                                                                    {
                                                                ?>
                                                                    <option value="<?= $row['vID'] ?>">
                                                                        <?= $row['vID'] . " " . $row['vName'] ?>
                                                                    </option>
                                                                 <?php
                                                                    }
                                                                ?>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="f_id">Vaccination Facility</label>
                                                            <select class="form-control" name="f_id">

                                                                <?php
                                                                    $STH = $DBH->query(
                                                                    "SELECT * FROM healthFacility");
                                                                    while($row = $STH->fetch())
                                                                    {
                                                                ?>
                                                                    <option value="<?= $row['facilityID'] ?>">
                                                                        <?= $row['facilityID'] . " " . $row['hName'] ?>
                                                                    </option>
                                                                 <?php
                                                                    }
                                                                ?>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="vax_date">Date Vaccinated</label>
                                                            <input name="vax_date" type="date" class="form-control" value="<?= $row['dateVaccinated'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="i_status">Infection Status</label>
                                                            <select class="form-control" name="i_status">
                                                                <option value="healthy">Healthy</option>
                                                                <option value="infected">Infected</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="i_date">Date Infection</label>
                                                            <input name="i_date" type="date" class="form-control" value="<?= $row['dateInfection'] ?>">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="i_type">Infection Type</label>
                                                            <input name="i_type" type="text" class="form-control" value="<?= $row['infectionType'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="dose">Dose No</label>
                                                            <input name="dose" type="number" class="form-control" value="<?= $row['doseNo'] ?>">
                                                        </div>

                                                        <button type="submit" class="btn btn-info" name="add">Add</button>

                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
        </div>
        <!-- top-grids -->
        <!-- content -->
        <?php include 'footer.php' ?>
            <!-- container -->
            </div>
    </body>

    </html>