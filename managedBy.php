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
		$STH = $DBH->prepare("UPDATE ageGroup SET minAge=?, maxAge=? WHERE groupNo=? AND province= ?");
		$STH->bindParam(1, $_POST['min_age']);
		$STH->bindParam(2, $_POST['max_age']);
		
		$STH->bindParam(3, $_POST['id']);
		$STH->bindParam(4, $_POST['province']);
		$STH->execute();
	}



	if(isset($_POST['add']))
	{
		$STH = $DBH->prepare("INSERT INTO managedBy  (employeeID, facilityID, startDate) Values (?,?,?)");
         
        $STH->bindParam(1, $_POST['employeeID']);
		$STH->bindParam(2, $_POST['facilityID']);
        $STH->bindParam(3, $_POST['is_date']);

		$STH->execute();
			


	}
	if(isset($_POST['delete']))
	{
		$STH = $DBH->prepare("Update managedBy  set endDate=? WHERE employeeID=? AND facilityID=?");
         $STH->bindParam(1, $_POST['ie_date']);
        
		$STH->bindParam(2, $_POST['employeeID']);
		$STH->bindParam(3, $_POST['facilityID']);
      
		
		$STH->execute();
			


	}
	if(isset($_POST['remove']))
	{
		$STH = $DBH->prepare("Delete from managedBy WHERE employeeID=? AND facilityID=?");
        
        
		$STH->bindParam(1, $_POST['employeeID']);
		$STH->bindParam(2, $_POST['facilityID']);
      
		
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
							$STH = $DBH->query("SELECT * FROM ageGroup WHERE groupNo=$_POST[id]");
							$row = $STH->fetch();
							
					?>

            <div class="panel panel-primary">

                <div class="panel-heading">
                    Edit Age Group
                </div>
                <div class="panel-body">
                    <form role="form" method="post">
                        

                        <div class="form-group">
                            <label for="min_age">Min Age</label>
                            <input name="min_age" type="text" class="form-control" value="<?= $row['minAge'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="max_age">Max Age</label>
                            <input name="max_age" type="text" class="form-control" value="<?= $row['maxAge'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input name="province" type="text" class="form-control" value="<?= $row['province'] ?>">
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
                    List of managers
                    <div style="float: right;">
                        <a class="btn btn-info" href="print.php?table=appointment">Print</a>
                    </div>
                </div>

                <div class="panel-body">
                    <h3 align="center">Confidential for manager protection</h3>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Facility ID</th>
                                <th>Start Date</th>
                                <th>End date</th>

                               
                                
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
                                        "SELECT * FROM managedBy " .
                                        (isset($search) ? //used for searching
                                         "WHERE facilityID LIKE '%$search%'" : //used for searching
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
                                    <?= $row['facilityID'] ?>
                                </td>

                                <td>
                                    <?= $row['startDate'] ?>
                                </td>


                                <td>
                                    <?= $row['endDate'] ?>
                                </td>



                            </tr>

                            <?php
										}
									?>

                        </tbody>
                    </table>


                </div>
                <!--Add Button-->
                <button class="btn btn-warning" data-toggle="collapse" data-target="#demo">Hire or Fire</button>
                <div id="demo" class="collapse" style="margin-top:10px">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            enter start date for new employee or end date for terminating employee
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">


                        </div>
                        <div class="form-group">
                            <label for="employeeID">employee ID</label>
                            <input name="employeeID" type="text" class="form-control">
                        </div>
						                        <div class="form-group">
                            <label for="facilityID">facility ID</label>
                            <input name="facilityID" type="text" class="form-control">
                        </div>
     <div class="form-group">
                                                            <label for="is_date">start date</label>
                                                            <input name="is_date" type="date" class="form-control" ">
                                                        </div>
														     <div class="form-group">
                                                            <label for="ie_date">end date</label>
                                                            <input name="ie_date" type="date" class="form-control" ">
                                                        </div>
                        <button type="submit" class="btn btn-info" name="add">Add start date</button>
<button type="submit" class="btn btn-info" name="delete">add end date</button>
<button type="submit" class="btn btn-info" name="remove">Remove from list</button>
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