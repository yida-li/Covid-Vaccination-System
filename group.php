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

	if(isset($_POST['delete']))
	{
		$STH = $DBH->prepare("DELETE FROM ageGroup WHERE groupNo=$_POST[id]");
		$STH->execute();
			
	}


	if(isset($_POST['add']))
	{
		$STH = $DBH->prepare("INSERT INTO ageGroup (groupNo, minAge, maxAge,province) Values (?,?,?)");
         
        $STH->bindParam(1, $_POST['id']);
		$STH->bindParam(2, $_POST['min_age']);
        $STH->bindParam(3, $_POST['max_age']);
		$STH->bindParam(3, $_POST['province']);
		$STH->execute();
			
	}

		if(isset($_POST['addprovince']))
	{
	 $STH = $DBH->prepare("INSERT INTO ageGroup (minAge, maxAge,province,groupZone) Values (80,120,?,1)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();
			
		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (70,79,?,2)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();	
		
        		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (60,69,?,3)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();	
			
            		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (50,59,?,4)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();	
			
            		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (40,49,?,5)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();	
			
            		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (30,39,?,6)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();	
			
            		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (18,29,?,7)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();	
			
            		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (12,17,?,8)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();	
			
            		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (5,11,?,9)");   
		$STH->bindParam(1, $_POST['province']);
		$STH->execute();	
			
            		$STH = $DBH->prepare("INSERT INTO ageGroup ( minAge, maxAge,province,groupZone) Values (0,4,?,10)");   
		$STH->bindParam(1, $_POST['province']);
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
                        <input type="hidden" name="id" value="<?= $_POST['id'] ?>">

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
                    Age Groups
                    <div style="float: right;">
                        <a class="btn btn-info" href="print.php?table=appointment">Print</a>
                    </div>
                </div>

                <div class="panel-body">
                    <h3 align="center">Group Information</h3>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Province</th>
                                <th>groupZone</th>
                                <th>Min Age</th>
                                <th>Max Age</th>

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
                                        "SELECT * FROM ageGroup " .
                                        (isset($search) ? //used for searching
                                         "WHERE groupZone LIKE '%$search%'" : //used for searching
                                         "") //used for searching
                                        );    
                   
										while($row = $STH->fetch())
										{
								?>
                            <tr>
                                <td>
                                    <?= $row['province'] ?>
                                </td>

                                <td>
                                    <?= $row['groupZone'] ?>
                                </td>

                                <td>
                                    <?= $row['minAge'] ?>
                                </td>


                                <td>
                                    <?= $row['maxAge'] ?>
                                </td>

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?= $row['groupNo'] ?>">
                                        <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                    </form>
                                </td>

                                <td>
                                    <form method="post" onsubmit="return validate(this);">
                                        <input type="hidden" name="id" value="<?= $row['groupNo'] ?>">
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
                    <button class="btn btn-warning" data-toggle="collapse" data-target="#demo">Add Province</button>
                    <div id="demo" class="collapse" style="margin-top:10px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add 10 groupZone
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">


                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input name="province" type="text" class="form-control" value="<?= $row['province'] ?>">
                            </div>

                            <button type="submit" class="btn btn-info" name="addprovince">Add</button>

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