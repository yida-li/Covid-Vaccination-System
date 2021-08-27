<?php
	require_once 'database.php';
	session_start();
	if(!isset($_SESSION['UserSession']))
	{
		header('Location: index.php');
		die();
	}

	if(isset($_POST['submit_edit']))
	{
        $STH = $DBH->prepare("UPDATE healthFacility SET hName=?, type=?, city=?, province=?, address=?, postalCode=?, webAddress=?, phone=? WHERE facilityID=?");

		$STH->bindParam(1, $_POST['h_name']);
		$STH->bindParam(2, $_POST['h_type']);
        $STH->bindParam(3, $_POST['h_city']);
        $STH->bindParam(4, $_POST['h_province']);
        $STH->bindParam(5, $_POST['h_address']);
		$STH->bindParam(6, $_POST['h_postal']);
        $STH->bindParam(7, $_POST['h_web']);
        $STH->bindParam(8, $_POST['h_phone']);

        $STH->bindParam(9, $_POST['id']);
        
        $STH->execute();
	}

	if(isset($_POST['delete']))
	{
        
		$STH = $DBH->prepare("DELETE FROM healthFacility WHERE facilityID=$_POST[id]");
		$STH->execute();	
	}


	if(isset($_POST['add']))
	{
        
        $STH = $DBH->prepare("INSERT INTO healthFacility (hName, type, city, province, address, postalCode, webAddress, phone) Values (?,?,?,?,?,?,?,?)");
        
		$STH->bindParam(1, $_POST['h_name']);
		$STH->bindParam(2, $_POST['h_type']);
        $STH->bindParam(3, $_POST['h_city']);
        $STH->bindParam(4, $_POST['h_province']);
        $STH->bindParam(5, $_POST['h_address']);
		$STH->bindParam(6, $_POST['h_postal']);
        $STH->bindParam(7, $_POST['h_web']);
        $STH->bindParam(8, $_POST['h_phone']);

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

                <div class="content">
                    <?php
						if(isset($_POST['edit']))
						{
							$STH = $DBH->query("SELECT * FROM healthFacility WHERE facilityID=$_POST[id]");
							$row = $STH->fetch();							
					?>

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Edit Facility
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">
                                    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                    
                                    <div class="form-group">
                                        <label for="h_name">Facility Name</label>
                                        <input name="h_name" type="text" class="form-control" value="<?= $row['hName'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="h_type">Type</label>
                                        <input name="h_type" type="text" class="form-control" value="<?= $row['type'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="h_city">City</label>
                                        <input name="h_city" type="text" class="form-control" value="<?= $row['city'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="h_province">Province</label>
                                        <input name="h_province" type="text" class="form-control" value="<?= $row['province'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="h_address">Address</label>
                                        <input name="h_address" type="text" class="form-control" value="<?= $row['address'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="h_postal">Postal Code</label>
                                        <input name="h_postal" type="text" class="form-control" value="<?= $row['postalCode'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="h_web">Website</label>
                                        <input name="h_web" type="text" class="form-control" value="<?= $row['webAddress'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="h_phone">Phone</label>
                                        <input name="h_phone" type="text" class="form-control" value="<?= $row['phone'] ?>">
                                    </div>

                                    <button type="submit" class="btn btn-info" name="submit_edit">Edit</button>


                                    <!-- <button type="submit" class="btn btn-info" name="submit_edit">Cancel</button>
                                     gotta check this -->

                                </form>
                            </div>
                        </div>

                        <?php
						}
					?>

                            <div class="panel panel-primary" style="width: 1900px">
                                <div class="panel-heading" style="height: 50px">
                                    Facilty

                                    <div style="float: right;">
                                        <a class="btn btn-info" href="print.php?table=inventory">Print</a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h3 align="center">Facility Information</h3>

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

                                                <th class="text-info">Edit</th>
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
                                        "SELECT * FROM healthFacility" . 
                                        (isset($search) ? //used for searching
                                         "WHERE hName LIKE '%$search%' OR type LIKE '%$search%' OR province LIKE '%$search%'" : //used for searching
                                         "") //used for searching
                                        );
                                            
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


                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?= $row['facilityID'] ?>">
                                                            <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form method="post" onsubmit="return validate(this);">
                                                            <input type="hidden" name="id" value="<?= $row['facilityID'] ?>">
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
                                                Add Facility
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">
                                                    <form role="form" method="post">

                                                        <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                        
                                                        <div class="form-group">
                                                            <label for="h_name">Facility Name</label>
                                                        <input name="h_name" type="text" class="form-control" value="<?= $row['hName'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="h_type">Type</label>
                                                            <input name="h_type" type="text" class="form-control" value="<?= $row['type'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="h_city">City</label>
                                                            <input name="h_city" type="text" class="form-control" value="<?= $row['city'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="h_province">Province</label>
                                                            <input name="h_province" type="text" class="form-control" value="<?= $row['province'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="h_address">Address</label>
                                                            <input name="h_address" type="text" class="form-control" value="<?= $row['address'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="h_postal">Postal Code</label>
                                                            <input name="h_postal" type="text" class="form-control" value="<?= $row['postalCode'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="h_web">Website</label>
                                                            <input name="h_web" type="text" class="form-control" value="<?= $row['webAddress'] ?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="h_phone">Phone</label>
                                                            <input name="h_phone" type="text" class="form-control" value="<?= $row['phone'] ?>">
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