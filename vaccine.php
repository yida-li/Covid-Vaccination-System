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
		$STH = $DBH->prepare("UPDATE vaccine SET vName=?, vaccineStatus=?, description=?, dateApproval=?, dateSuspension=? WHERE vID=?");
		$STH->bindParam(1, $_POST['v_name']);
		$STH->bindParam(2, $_POST['v_status']);
		$STH->bindParam(3, $_POST['v_desc']);
		$STH->bindParam(4, $_POST['v_approval']);
		$STH->bindParam(5, $_POST['v_suspension']);
		
		$STH->bindParam(6, $_POST['id']);
		
		$STH->execute();
	}

	if(isset($_POST['delete']))
	{
		$STH = $DBH->prepare("DELETE FROM vaccine WHERE vID=$_POST[id]");
		$STH->execute();
			
	}


	if(isset($_POST['add']))
	{
		$STH = $DBH->prepare("INSERT INTO vaccine (vName, vaccineStatus, description, dateApproval, dateSuspension) Values (?,?,?,?,?)");
         
        $STH->bindParam(1, $_POST['v_name']);
		$STH->bindParam(2, $_POST['v_status']);
        $STH->bindParam(3, $_POST['v_desc']);
		$STH->bindParam(4, $_POST['v_approval']);
		$STH->bindParam(5, $_POST['v_suspension']);
		
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
							$STH = $DBH->query("SELECT * FROM vaccine WHERE vID=$_POST[id]");
							$row = $STH->fetch();
							
					?>

                        <div class="panel panel-primary">

                            <div class="panel-heading">
                                Edit Vaccine
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">
                                    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                    
                                    <div class="form-group">
                                        <label for="v_name">Name</label>
                                        <input name="v_name" type="text" class="form-control" value="<?= $row['vName'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="v_status">Status</label>
                                        <input name="v_status" type="text" class="form-control" value="<?= $row['vaccineStatus'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="v_desc">Description</label>
                                        <input name="v_desc" type="text" class="form-control" value="<?= $row['description'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="v_approval">Approval Date</label>
                                        <input name="v_approval" type="date" class="form-control" value="<?= $row['dateApproval'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="v_suspension">Suspension Date</label>
                                        <input name="v_suspension" type="date" class="form-control" value="<?= $row['dateSuspension'] ?>">
                                    </div>

                                    <button type="submit" class="btn btn-info" name="submit_edit">Edit</button>

                                </form>
                            </div>
                        
                        </div>

                        <?php
						}
					?>

                            <div class="panel panel-primary">
                                <div class="panel-heading" style="height: 50px">
                                    Vaccines
                                    <div style="float: right;">
                                        <a class="btn btn-info" href="print.php?table=appointment">Print</a>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <h3 align="center">Vaccine Information</h3>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Description</th>
                                                <th>Approval Date</th>
                                                <th>Suspension Date</th>
                                                <!--
                                                <th>Therapist</th>
-->

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
                                        
                                            
                                        //Since First_Name are all over. It is ambiguity just to put First_Name as Columns Name. So I am specifiying which table and which colums and changing that variable to a new one.
                                        //Ex. Employees.First_Name as efirst
										$STH = $DBH->query(
                                        "SELECT * FROM vaccine " .
                                        (isset($search) ? //used for searching
                                         "WHERE vName LIKE '%$search%' OR vaccineStatus LIKE '%$search' " : //used for searching
                                         "") //used for searching
                                        );    
                   
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

                                                    <td>
                                                        <form method="post">
                                                            <input type="hidden" name="id" value="<?= $row['vID'] ?>">
                                                            <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <form method="post" onsubmit="return validate(this);">
                                                            <input type="hidden" name="id" value="<?= $row['vID'] ?>">
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
                                                Add Vaccine
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" method="post">
                                                    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
                                                    
                                                    <div class="form-group">
                                                        <label for="v_name">Name</label>
                                                        <input name="v_name" type="text" class="form-control" value="<?= $row['vName'] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="v_status">Status</label>
                                                        <input name="v_status" type="text" class="form-control" value="<?= $row['vaccineStatus'] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="v_desc">Description</label>
                                                        <input name="v_desc" type="text" class="form-control" value="<?= $row['description'] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="v_approval">Approval Date</label>
                                                        <input name="v_approval" type="date" class="form-control" value="<?= $row['dateApproval'] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="v_suspension">Suspension Date</label>
                                                        <input name="v_suspension" type="date" class="form-control" value="<?= $row['dateSuspension'] ?>">
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