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
		$STH = $DBH->prepare("UPDATE employees SET medicareID=?, SSN=?, fName=?, lName=?, address=?, city=?, province=?, email=?, citizen=?, postalCode=?, phone=?, dob=? WHERE employeeID=?");

        $STH->bindParam(1, $_POST['medicare_id']);
		$STH->bindParam(2, $_POST['sin']);
		$STH->bindParam(3, $_POST['first_name']);
		$STH->bindParam(4, $_POST['last_name']);
		$STH->bindParam(5, $_POST['addresses']);
		$STH->bindParam(6, $_POST['cities']);
        $STH->bindParam(7, $_POST['prov']);
        $STH->bindParam(8, $_POST['emailAddress']);
        $STH->bindParam(9, $_POST['citizenship']);
        $STH->bindParam(10, $_POST['postal']);
        $STH->bindParam(11, $_POST['phone_number']);
        $STH->bindParam(12, $_POST['birth_date']);
		
		$STH->bindParam(13, $_POST['id']);
		
		$STH->execute();
	}

	if(isset($_POST['delete']))
	{
		$STH = $DBH->prepare("DELETE FROM employees WHERE employeeID=$_POST[id]");
        $STH->execute();
			
	}


	if(isset($_POST['add']))
	{
		$STH = $DBH->prepare("INSERT INTO employees (employeeID, medicareID, SSN, fName, lName, address, city, province, email, citizen, postalCode, phone, dob) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        
        $STH->bindParam(1, $_POST['id']);
        $STH->bindParam(2, $_POST['medicare_id']);
		$STH->bindParam(3, $_POST['sin']);
		$STH->bindParam(4, $_POST['first_name']);
		$STH->bindParam(5, $_POST['last_name']);
		$STH->bindParam(6, $_POST['addresses']);
		$STH->bindParam(7, $_POST['cities']);
        $STH->bindParam(8, $_POST['prov']);
        $STH->bindParam(9, $_POST['emailAddress']);
        $STH->bindParam(10, $_POST['citizenship']);
        $STH->bindParam(11, $_POST['postal']);
        $STH->bindParam(12, $_POST['phone_number']);
        $STH->bindParam(13, $_POST['birth_date']);
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


                <div class="content" style="width: 1650px">
                    <?php
						if(isset($_POST['edit']))
						{
							$STH = $DBH->query("SELECT * FROM employees WHERE employeeID=$_POST[id]");
							$row = $STH->fetch();
							
					?>

                        <div class="panel panel-primary">

                            <div class="panel-heading">
                                Edit Employee
                            </div>

                            <div class="panel-body">
                                <form role="form" method="post">

                                   <input type="hidden" name="id" value="<?= $_POST['id'] ?>"> 

                                   <div class="form-group">
                                        <label for="medicare_id">Medicare ID</label>
                                        <input name="medicare_id" type="text" class="form-control" value="<?= $row['medicareID'] ?>">
                                    </div>

                                   <div class="form-group">
                                        <label for="sin">SSN</label>
                                        <input name="sin" type="text" class="form-control" value="<?= $row['SSN'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input name="first_name" type="text" class="form-control" value="<?= $row['fName'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input name="last_name" type="text" class="form-control" value="<?= $row['lName'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="addresses">Address</label>
                                        <input name="addresses" type="text" class="form-control" value="<?= $row['address'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="cities">City</label>
                                        <input name="cities" type="text" class="form-control" value="<?= $row['city'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="prov">Province</label>
                                        <input name="prov" type="text" class="form-control" value="<?= $row['province'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="emailAddress">Email</label>
                                        <input name="emailAddress" type="text" class="form-control" value="<?= $row['email'] ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="citizenship">Citizenship</label>
                                        <input name="citizenship" type="text" class="form-control" value="<?= $row['citizen'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="postal">Postal Code</label>
                                        <input name="postal" type="text" class="form-control" value="<?= $row['postalCode'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input name="phone_number" type="text" class="form-control" value="<?= $row['phone'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="birth_date">Birth Date</label>
                                        <input name="birth_date" type="date" class="form-control" value="<?= $row['dob'] ?>">
                                    </div>

                                    <button type="submit" class="btn btn-info" name="submit_edit">Edit</button>
                                </form>
                            </div>
                        </div>

                    <?php
						}
					?>
                            <div class="panel panel-primary" >

                                <div class="panel-heading" style="height: 50px">
                                    Employee
                                    <div style="float: right;">
                                        <a class="btn btn-info" href="print.php?table=person">Print</a>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <h3 align="center">Employee Information</h3>

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
                                                
                                                <th class="text-info">Edit</th>
                                                <th class="text-danger">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            <?php
                                            
                                            //user to search
                                            if(isset($_POST['search']))
                                            {
                                                $search = $_POST['search'];
                                            }
                                            
										$STH = $DBH->query(
                                        "SELECT * FROM employees " . 
                                        (isset($search) ? //used for searching
                                         "WHERE fName LIKE '%$search%' OR lName LIKE '%$search' " : //used for searching
                                         "") //used for searching
                                        );          
                                            
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

                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?= $row['employeeID'] ?>">
                                                            <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <form method="post" onsubmit="return validate(this);">
                                                            <input type="hidden" name="id" value="<?= $row['employeeID'] ?>">
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
                                                Add Employee
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">
                                                    <form role="form" method="post">

                                                        <div class="form-group">
                                                            <label for="id">Employee ID</label>
                                                            <input name="id" type="number" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="medicare_id">Medicare ID</label>
                                                            <input name="medicare_id" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="sin">SSN</label>
                                                            <input name="sin" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="first_name">First Name</label>
                                                            <input name="first_name" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="last_name">Last Name</label>
                                                            <input name="last_name" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="addresses">Address</label>
                                                            <input name="addresses" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="cities">City</label>
                                                            <input name="cities" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="prov">Province</label>
                                                            <input name="prov" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="emailAddress">Email</label>
                                                            <input name="emailAddress" type="email" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="citizenship">Citizenship</label>
                                                            <input name="citizenship" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="postal">Postal Code</label>
                                                            <input name="postal" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="phone_number">Phone Number</label>
                                                            <input name="phone_number" type="text" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="birth_date">Birth Date</label>
                                                            <input name="birth_date" type="date" class="form-control" required>
                                                        </div>
                                            
                                                        <!--
                                                        <div class="form-group">
                                                            <label for="gender">Gender</label>
                                                                <!-<input name="gender" type="text" class="form-control" required> ->


                                                            <select name="gender" type="text" class="form-control" required>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>


                                                        </div> 
                                                        -->
                                                        <button type="submit" class="btn btn-info" name="add">Add</button>
                                                </div>
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