<?php
	session_start();
    //if the user is not logged in, redirect them to the loggin page
	if(!isset($_SESSION['UserSession']))
	{
		header('Location: index.php');
		die();
	}

?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
        <script type="text/javascript" src="bootstrap.min.js"></script>
        <script type="text/javascript" src="jquery.min.js"></script>
    </head>

    <body>


        <div class="container">
            <?php include 'header.php' ?>
                <!-- container -->
                <!-- content -->
                <div class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="well">
                                Welcome to the Covid-19 Vaccination System!
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="well">
            
                                <h2>Province Vaccination Campaigns</h2>                    
                                <ul id="horizontal-menus">
                                    <li><a href="https://www.quebec.ca/en/health/health-issues/a-z/2019-coronavirus/progress-of-the-covid-19-vaccination" target="_blank">Quebec</a></li>
                                    <li><a href="https://covid-19.ontario.ca/covid-19-vaccines-ontario" target="_blank">Ontario</a></li>
                                    <li><a href="https://novascotia.ca/coronavirus/vaccine/" target="_blank">Nova Scotia</a></li>
                                    <li><a href="https://www2.gnb.ca/content/gnb/en/corporate/promo/covid-19/nb-vaccine.html" target="_blank">New Brunswick</a></li>
                                    <li><a href="https://www.gov.mb.ca/covid19/vaccine/index.html" target="_blank">Manitoba</a></li>
                                    <li><a href="https://www2.gov.bc.ca/gov/content/covid-19/vaccine/plan" target="_blank">British Columbia</a></li>
                                    <li><a href="https://www.princeedwardisland.ca/en/information/health-and-wellness/getting-the-covid-19-vaccine" target="_blank">Prince Edward Island</a></li>
                                    <li><a href="https://www.saskatchewan.ca/covid19-vaccine." target="_blank">Saskatchewan</a></li>
                                    <li><a href="https://www.albertahealthservices.ca/topics/page17295.aspx" target="_blank">Alberta</a></li>
                                    <li><a href="https://www.gov.nl.ca/covid-19/vaccine/gettheshot/" target="_blank">Newfoundland and Labrador</a></li>
                                </ul>

                                <h3>Territory Vaccination Campaigns</h3>
                                <ul id="horizontal-menus">
                                    <li><a href="https://www.gov.nt.ca/covid-19/en/services/covid-19-vaccine" target="_blank">Northwest Territories</a></li>
                                    <li><a href="https://yukon.ca/en/this-is-our-shot" target="_blank">Yukon</a></li>
                                    <li><a href="https://www.gov.nu.ca/health/information/covid-19-vaccination" target="_blank">Nunavut</a></li>
                                </ul>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

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