<?php   
    // Initialize the session      
    session_start();    
 
    // Check if the user is logged in, if not then redirect him to login page 
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){ 
        header("location: login.php");
        exit;
    }
 
    require_once "../config.php"; 

    $userlogin = $_SESSION["username"];
    $page_active = "dashboard";

    $accountType;

    $anatomy_correct; 
    $anatomy_incorrect;
    $anatomy_total;
    $physiology_correct;
    $physiology_incorrect;
    $physiology_total;
    $pathology_correct;
    $pathology_incorrect;
    $pathology_total;

    $totalquestionsattempted;

 
    set_exception_handler(function($e) {
        error_log($e);
        exit('Error reading stats');
    });

    $sql = "SELECT accType
            FROM users
            WHERE username=?"; // SQL with parameters
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s",$userlogin);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result 

    if ($result->num_rows > 0) {
        // output data of each row and save it in array for later use
        while($row = $result->fetch_assoc()) {
            $accountType = $row["accType"];
        }
    }else { 
        exit('There seems to be an error!');
    }



    $sql = "SELECT anatomy_correct, anatomy_total,
                   physiology_correct, physiology_total, 
                   pathology_correct, pathology_total
            FROM users_stats 
            WHERE username=?"; // SQL with parameters
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s",$userlogin);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result 

    if ($result->num_rows > 0) {
        // output data of each row and save it in array for later use
        while($row = $result->fetch_assoc()) {
            $anatomy_correct = $row["anatomy_correct"];
            $anatomy_incorrect = $row["anatomy_total"] - $anatomy_correct;
            $anatomy_total = $row["anatomy_total"];
            $physiology_correct = $row["physiology_correct"];
            $physiology_incorrect = $row["physiology_total"] - $physiology_correct;
            $physiology_total = $row["physiology_total"];
            $pathology_correct = $row["pathology_correct"];
            $pathology_incorrect = $row["pathology_total"] - $pathology_correct;
            $pathology_total = $row["pathology_total"];
            $totalquestionsattempted = $anatomy_total + $physiology_total + $pathology_total;
        }
    }else { 
        exit('There seems to be an error!');
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Dashboard</title>
        
        <!-- Bootstrap 4 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 
        <!-- Fonts Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
       
        <!-- CSS -->
        <link href="css/front_pages.css" rel="stylesheet">  

        <style>
            
            .card:hover{
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.1);
            }
            a:link {
                text-decoration: none;
                color:darkblue;
            }
            a:visited {
                color: darkblue;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid p-0 vh-100"> 
            <div class="row no-gutters h-100">
                <div class="col-sm-12 col-md-3 col-lg-2 p-0 shadow" id="sidemenu">        <!-- Menu Column -->
                    <?php 
                        include "sidemenu.php";
                    ?>
        		</div>
        		
        		<div class="col-sm-12 col-md-9 col-lg-10 h-100" id="content">     <!-- Content Column -->
                    <div class="row no-gutters">
                        <div class="col-md-12">
                            <div id="page_header_div">
                                <h2 id="page_header">Dashboard</h2>
                            </div>	
                        </div>
                    </div>
                    
                    <div class="row no-gutters ml-4 mr-4 shadow bg-white rounded">
                        
                        <div class="col-md-2 p-4 overflow-auto">
                            
                            <a href="createtest.php">
                                <div class="card h-100">
                                    <div class="card-body">
                                        
                                            <span style="font-size: 3em; text-align: center; display: block;  margin-left: auto;  margin-right: auto;"> 
                                                <i class="fas fa-file-alt"></i>
                                                <h5>Create Test</h5>
                                            </span>
                                        
                                    </div>
                                </div>
                            </a>
                        
                        </div>
                        <div class="col-md-2 p-4">
                            
                            <a href="performance.php">
                                <div class="card h-100">
                                    <div class="card-body">
                                    
                                        <span style="font-size: 3em; text-align: center; display: block;  margin-left: auto;  margin-right: auto;"> 
                                                <i class="fas fa-chart-bar"></i>
                                                <h5>Check Performance</h5>
                                        </span>
    
                                    </div>
                                </div>
                            </a>
                            
                        </div>
                        <div class="col-md-2 p-4">
                        
                            <a href="search.php">
                                <div class="card h-100">
                                    <div class="card-body">
    
                                        <span style="font-size: 3em; text-align: center; display: block;  margin-left: auto;  margin-right: auto;"> 
                                                <i class="fas fa-search"></i>
                                                <h5>Search Questions</h5>
                                        </span>
    
                                    </div>
                                </div>
                            </a>
                            
                        </div>
                        <div class="col-md-2 p-4">
                        
      
                            
                        </div>
                        <div class="col-md-2 p-4">
                        
                            <a href="settings.php">
                                <div class="card h-100">
                                    <div class="card-body">
    
                                        <span style="font-size: 3em; text-align: center; display: block;  margin-left: auto;  margin-right: auto;"> 
                                                <i class="fas fa-sliders-h"></i>
                                                <h5>Settings</h5>
                                        </span>
    
                                    </div>
                                </div>
                            </a>
                            
                        </div>
                        
                        
                        <div class="col-md-12 p-4 overflow-auto">
                            <h5>Future Additions</h5>
                        </div>
                        
                        <div class="col-md-2 p-4 overflow-auto text-muted">
                        
                                <div class="card h-100">
                                    <div class="card-body">
                                        
                                            <span style="font-size: 3em; text-align: center; display: block;  margin-left: auto;  margin-right: auto;"> 
                                                <i class="fas fa-file-alt"></i>
                                                <h5>Flash Cards</h5>
                                            </span>
                                        
                                    </div>
                                </div>
                            
                        
                        </div>
                        <div class="col-md-2 p-4 text-muted">
                            
                            
                                <div class="card h-100">
                                    <div class="card-body">
                                    
                                        <span style="font-size: 3em; text-align: center; display: block;  margin-left: auto;  margin-right: auto;"> 
                                                <i class="fas fa-file-alt"></i>
                                                <h5>Standardized Test</h5>
                                        </span>
    
                                    </div>
                                </div>
                            
                            
                        </div>
                        <div class="col-md-2 p-4 text-muted">

                            
                                <div class="card h-100">
                                    <div class="card-body">
    
                                        <span style="font-size: 3em; text-align: center; display: block;  margin-left: auto;  margin-right: auto;"> 
                                                <i class="fas fa-file-alt"></i>
                                                <h5>Ask a teacher!</h5>
                                        </span>
    
                                    </div>
                                </div>
                            
                            
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
            
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        
        <!-- Charts.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script> 
        
        <!-- Pace Loader -->
        <script type="text/javascript" src="js/pace.min.js"></script>       
            
    </body>
    
    

</html>