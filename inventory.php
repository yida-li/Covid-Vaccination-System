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
		$STH = $DBH->prepare("UPDATE inventory SET quantity=quantity+?, receptionDate=? WHERE hname=? AND vName=?");

		$STH->bindParam(1, $_POST['v_quantity']);
		$STH->bindParam(2, $_POST['v_date']);
		$STH->bindParam(3, $_POST['v_hname']);
		$STH->bindParam(4, $_POST['v_name']);
		
	
		
		$STH->execute();
	}


	if(isset($_POST['send'])) // actually transfer
	{
		$STH = $DBH->prepare("UPDATE inventory i1 JOIN inventory i2 ON i1.hname= ? AND i2.hname= ? SET i1.quantity = i1.quantity-?, i2.quantity = i2.quantity+?,i2.receptionDate=? WHERE i1.quantity >? AND i1.vName=? AND i2.vName=?");

        $STH->bindParam(1, $_POST['v_hname']); 
        $STH->bindParam(2, $_POST['v_hname2']);
		$STH->bindParam(3, $_POST['v_quantity']);
        $STH->bindParam(4, $_POST['v_quantity']);
		$STH->bindParam(5, $_POST['v_date']);
        $STH->bindParam(6, $_POST['v_quantity']);
		$STH->bindParam(7, $_POST['v_name']);
		$STH->bindParam(8, $_POST['v_name']);
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
							$STH = $DBH->query("SELECT * FROM inventory WHERE vID=$_POST[id]");
							$row = $STH->fetch();
							
					?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    Send Shipments
                </div>
                <div class="panel-body">
                    <form role="form" method="post">


                        <div class="form-group">
                            <label for="v_hname">Hospital Name</label>
                            <input name="v_hname" type="text" class="form-control" ">
                                    </div>

                                    <div class=" form-group">
                            <label for="v_name">Vaccine Name</label>
                            <input name="v_name" type="text" class="form-control" ">
                                    </div>

                                    <div class=" form-group">
                            <label for="v_quantity">Quantity</label>
                            <input name="v_quantity" type="text" class="form-control" ">
                                    </div>

                                    <div class=" form-group">
                            <label for="v_date">Reception Date</label>
                            <input name="v_date" type="date" class="form-control" ">
                                    </div>

                           
                                    <button type=" submit" class="btn btn-info" name="submit_edit">Send</button>

                    </form>
                </div>
            </div>
            <?php
						}
					?>

            <div class="panel panel-primary">
                <div class="panel-heading" style="height: 50px">
                    Covid vaccine stock
                    <div style="float: right;">
                        <a class="btn btn-info" href="print.php?table=appointment">Destroy all vaccines</a>
                    </div>
                </div>

                <div class="panel-body">
                    <h3 align="center">Inventory</h3>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hospital Name</th>
                                <th>Vaccine Name</th>
                                <th>Quantity Available</th>
                                <th>Approval Date</th>
                                <th class="text-info">Shipments</th>

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
                                        "SELECT * FROM inventory " .
                                        (isset($search) ? //used for searching
                                         "WHERE vName LIKE '%$search%' OR hname LIKE '%$search'" : //used for searching
                                         "ORDER BY hname ASC") //used for searching
                                        );    
                   
										while($row = $STH->fetch())
										{
								?>
                            <tr>
                                <td>
                                    <?= $row['hname'] ?>
                                </td>

                                <td>
                                    <?= $row['vName'] ?>
                                </td>


                                <td>
                                    <?= $row['quantity'] ?>
                                </td>

                                <td>
                                    <?= $row['receptionDate'] ?>
                                </td>

                                <td>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?= $row['vID'] ?>">
                                        <input type="submit" class="btn btn-info" value="Send" name="edit">
                                    </form>
                                </td>



                            </tr>

                            <?php
										}
									?>

                        </tbody>
                    </table>

                    <!--send Button-->
                    <button class="btn btn-warning" data-toggle="collapse" data-target="#demo">Request a transfer of
                        vaccines between 2 health facilities</button>
                    <div id="demo" class="collapse" style="margin-top:10px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Make sure the current to enter the quantity which does not exceed the limit of the
                                provider
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">

                                    <div class="form-group">
                                        <label for="v_hname">Facility Name(provider)</label>
                                        <input name="v_hname" type="text" class="form-control" ">
                                    </div>

                                    <div class=" form-group">
                                        <label for="v_name">Vaccine Name</label>
                                        <input name="v_name" type="text" class="form-control" ">
                                    </div>
                                    <div class=" form-group">
                                        <label for="v_hname2">Destination Facility(procurer)</label>
                                        <input name="v_hname2" type="text" class="form-control" ">
                                    </div>
                                    <div class=" form-group">
                                        <label for="v_quantity">Quantity to transfer</label>
                                        <input name="v_quantity" type="text" class="form-control" ">
                                    </div>

                                    <div class=" form-group">
                                        <label for="v_date">Reception Date</label>
                                        <input name="v_date" type="date" class="form-control" ">
                                    </div>
                                               

                                                    <button type=" submit" class="btn btn-info"
                                            name="send">Request</button>

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