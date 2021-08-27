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
		$STH = $DBH->prepare("UPDATE province SET provName=?, groupNo=? WHERE provID= ?");
		
		$STH->bindParam(1, $_POST['p_name']);
        $STH->bindParam(2, $_POST['group_no']);

        $STH->bindParam(3, $_POST['id']);
		$STH->execute();
	}

	if(isset($_POST['delete']))
	{
		$STH = $DBH->prepare("DELETE FROM province WHERE provID=$_POST[id]");
		$STH->execute();
			
	}


	if(isset($_POST['add']))
	{
        $STH = $DBH->prepare("INSERT INTO province (provName) Values (?)");   
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
							$STH = $DBH->query("SELECT * FROM province WHERE provID=$_POST[id]");
							$row = $STH->fetch();
							
					?>

            <div class="panel panel-primary">

                <div class="panel-heading">
                    Edit Province
                </div>

                <div class="panel-body">
                    <form role="form" method="post">
                        <input type="hidden" name="id" value="<?= $_POST['id'] ?>">

                        <div class="form-group">
                            <label for="p_name">Province Name</label>
                            <input name="p_name" type="text" class="form-control" value="<?= $row['provName'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="group_no">Group No</label>
                            <input name="group_no" type="number" class="form-control" value="<?= $row['groupNo'] ?>">
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
                    Canada
                    <div style="float: right;">
                        <a class="btn btn-info" href="print.php?table=appointment">Destroy a province</a>
                    </div>
                </div>

                <div class="panel-body">
                    <h3 align="center">Provinces</h3>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Province ID</th>
                                <th>Province</th>
                                <th>Group No</th>

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
                                        "SELECT * FROM province " .
                                        (isset($search) ? //used for searching
                                         "WHERE provName LIKE '%$search%'" : "") //used for searching
                                        );    
                   
										while($row = $STH->fetch())
										{
								?>
                            <tr>
                                <td>
                                    <?= $row['provID'] ?>
                                </td>


                                <td>
                                    <?= $row['provName'] ?>
                                </td>
                                
                                <td>
                                    <?= $row['groupNo'] ?>
                                </td>

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?= $row['provID'] ?>">
                                        <input type="submit" class="btn btn-info" value="Edit" name="edit">
                                    </form>
                                </td>

                                <td>
                                    <form method="post" onsubmit="return validate(this);">
                                        <input type="hidden" name="id" value="<?= $row['provID'] ?>">
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
                                Add Province
                            </div>

                            <div class="panel-body">
                                <form role="form" method="post">

                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <input name="province" type="text" class="form-control" value="<?= $row['provName'] ?>">
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