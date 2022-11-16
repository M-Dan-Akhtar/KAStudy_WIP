<?php  
// Initialize the session 
session_start(); 
 
// Check if the user is logged in, if not then redirect him to login page 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} 

$total_marks=0;
if(isset($_POST["anatomy_total"])){
    $anatomy_total = $_POST["anatomy_total"];
    $anatomy_correct = ($_POST["anatomy_correct"]);    
    
    if($anatomy_total!=0){


        $anatomy_incorrect = ($_POST["anatomy_total"]) - ($_POST["anatomy_correct"]);
        $anatomy_correct_percentage = ($_POST["anatomy_correct"]) / ($_POST["anatomy_total"]) * 100;
        $anatomy_incorrect_percentage = (($_POST["anatomy_total"]) - ($_POST["anatomy_correct"])) / ($_POST["anatomy_total"]) * 100;
    }
}else{
    header("location: createtest.php");
    exit;
}



if(isset($_POST["physiology_total"])){
    $physiology_total = $_POST["physiology_total"];
    $physiology_correct = $_POST["physiology_correct"];
    
    $physiology_current_circulatory_correct = $_POST["physiology_current_circulatory_correct"];
    $physiology_current_circulatory_total = $_POST["physiology_current_circulatory_total"];
    
    $physiology_current_respiratory_correct = $_POST["physiology_current_respiratory_correct"];
    $physiology_current_respiratory_total = $_POST["physiology_current_respiratory_total"];
    
    if($physiology_total!=0){
        $physiology_incorrect = $physiology_total - $physiology_correct;
        $physiology_correct_percentage = $physiology_correct / $physiology_total * 100;
        $physiology_incorrect_percentage = ($physiology_incorrect) / ($physiology_total) * 100;
    }
}

if(isset($_POST["pathology_total"])){
    $pathology_total = $_POST["pathology_total"];
    $pathology_correct = $_POST["pathology_correct"];
    
    $pathology_current_circulatory_correct = $_POST["pathology_current_circulatory_correct"];
    $pathology_current_circulatory_total = $_POST["pathology_current_circulatory_total"];
    
    $pathology_current_respiratory_correct = $_POST["pathology_current_respiratory_correct"];
    $pathology_current_respiratory_total = $_POST["pathology_current_respiratory_total"];
    
    if($pathology_total!=0){
        $pathology_incorrect = $pathology_total - $pathology_correct;
        $pathology_correct_percentage = $pathology_correct / $pathology_total * 100;
        $pathology_incorrect_percentage = ($pathology_incorrect) / ($pathology_total) * 100;
    }
}

$total_marks_correct = $anatomy_correct + $physiology_correct + $pathology_correct;
$total_marks = $anatomy_total + $physiology_total + $pathology_total;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Test Results</title>
        <!-- Bootstrap 4 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        
        <!-- Charts.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        
        <!-- Fonts Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
        
        <!-- Google Fonts -->
       <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
       
       <link href="css/front_pages.css" rel="stylesheet">
        
        <!-- Pace Loader -->
        <script type="text/javascript" src="js/pace.min.js"></script>
        
         <script src='https://cdnjs.cloudflare.com/ajax/libs/countup.js/1.8.2/countUp.min.js'></script>
      
    </head>
    <body>

            
        <div class="container-fluid p-0 vh-100">
        	<div class="row no-gutters p-0 menu h-100">
        		<div class="col-md-2 p-0 shadow collapse show" id="sidemenu">
        		 
        		   <div class="p-2 text-white" id="sidemenutop">
        		        
        		        <br>
            		    <h4 class="p-2">Pecker's | <small class="text-muted">Medical</small></h4>
            		    <hr>
                        
            					<a class="userdropdown ml-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" >
                                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION["username"]); ?><i class="fa fa-sort-down float-right"></i>
                                </a>
            				
            			
            			
            			<div class="collapse" id="collapseExample">
                            <ul class="nav flex-column p-2 w-100">
                				<li class="nav-item">
                					<a class="nav-link rounded" href="settings.php"><i class="fas fa-sliders-h"></i> Settings</a>
                				</li>
                				<li class="nav-item">
                					<a class="nav-link rounded" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a>
                				</li>
                			</ul>
                        </div>
                        
        		    </div>
        		   
        		   
        		   <hr>
        		   
                    
        			<ul class="nav flex-column p-2 w-100">
        				<li class="nav-item">
        					<a class="nav-link rounded" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        				</li>
        				<br>
        				<li class="nav-item">
        					<a class="nav-link rounded" href="createtest.php"><i class="fas fa-pencil-alt"></i> Create a test</a>
        				</li>
        				<li class="nav-item">
        					<a class="nav-link rounded" href="performance.php"><i class="fas fa-chart-bar"></i> Performance</a>
        				</li>
        				<li class="nav-item">
        					<a class="nav-link rounded" href="search.php"><i class="fas fa-search"></i> Search</a>
        				</li>
        			</ul>
        		</div>
        		<div class="col-md-10 overflow-auto h-100">
        		     
        		    <div class="d-md-none d-lg-none d-xl-none w-100">
        		        <a class="btn btn-primary btn-sm w-100 rounded-0" data-toggle="collapse" href="#sidemenu" role="button" aria-expanded="false" aria-controls="collapseExample">Menu</a>
        		    </div> 
        		     
        		    <div class="row no-gutters">
        	            <div class="col-md-12">
        	                 
                		    
                			<div style="margin-left:25px; margin-top:10px; padding-left:15px;">
                    			<h2 style="padding-left:10px; margin-right: 20px; margin-top:20px;margin-bottom:20px;border-left-style: solid; border-color:#3BBA9C; border-width:2px;">Test Results
                    			</h2>
                    		</div>	
                    		
                    		<div style="margin-left:25px; margin-top:10px; padding-left:15px;">
                    		    <h5 class="d-inline"><b>Overall Marks     </b></h5><div id="counter" class="d-inline"></div> / <?php echo $total_marks; ?>
                    		</div>
                    		
            			</div>
            		</div>
            		
            		
            		
        		    <div class="row no-gutters">
        	        	<div class="col-md-12 p-4">
        	        	    
        	        	    <?php if($anatomy_total != 0){ ?>
        	        	        
            	        	    <div class="card shadow mb-5">
            	        	         <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.25);">Anatomy</h5>
                                    <div class="card-body">
                                        
                                        <div class="progress">
                                          <div class="progress-bar bg-success" style="width:<?php echo $anatomy_correct_percentage; ?>%">
                                              <?php echo $anatomy_correct; ?>
                                          </div>
                                          
                                          <div class="progress-bar bg-danger" style="width:<?php echo $anatomy_incorrect_percentage; ?>%">
                                            <?php echo $anatomy_incorrect; ?>
                                          </div>
                                        </div>
                                        <br>
                                        <table class="table table-sm table-striped">
                                              
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><?php echo $anatomy_correct . " / "  . $anatomy_total; ?></td>
                                              
                                            </tr>
                                            <tr>
                                              
                                              <td>Circulatory (Only Example Not Accurate)</td>
                                              <td>4 / 6</td>
                                            </tr>
                                            <tr>
                                              
                                              <td>Respiratory (Only Example Not Accurate)</td>
                                              <td>2 / 4</td>
                                            </tr>
                                          
                                        </table>
                                    </div>    
                                </div>
                            <?php }; ?>
                            
                            <?php if($physiology_total != 0){ ?>
                            
                                <div class="card shadow mb-5">
            	        	         <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.25);">Physiology</h5>
                                    <div class="card-body">
                                        
                                        <div class="progress">
                                          <div class="progress-bar bg-success" style="width:<?php echo $physiology_correct_percentage; ?>%">
                                              <?php echo $physiology_correct; ?>
                                          </div>
                                          
                                          <div class="progress-bar bg-danger" style="width:<?php echo $physiology_incorrect_percentage; ?>%">
                                            <?php echo $physiology_incorrect; ?>
                                          </div>
                                        </div>
                                        <br>
                                        <table class="table table-sm table-striped">
                                              
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><b><?php echo $physiology_correct . " / "  . $physiology_total; ?></b></td>
                                              
                                            </tr>
                                            <tr>
                                              
                                              <td><b>Circulatory</b></td>
                                              <td><b><?php echo $physiology_current_circulatory_correct . " / " . $physiology_current_circulatory_total; ?></b></td>
                                            </tr>
                                            <tr>
                                              
                                              <td><b>Respiratory</b></td>
                                              <td><b><?php echo $physiology_current_respiratory_correct . " / " . $physiology_current_respiratory_total; ?></b></td>
                                            </tr>
                                          
                                        </table>
                                    </div>    
                                </div>
                            
                            <?php }; ?>
                            
                            <?php if($pathology_total != 0){ ?>
                            
                                <div class="card shadow mb-5">
            	        	         <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.25);">Pathology</h5>
                                    <div class="card-body">
                                        
                                        <div class="progress">
                                          <div class="progress-bar bg-success" style="width:<?php echo $pathology_correct_percentage; ?>%">
                                              <?php echo $pathology_correct; ?>
                                          </div>
                                          
                                          <div class="progress-bar bg-danger" style="width:<?php echo $pathology_incorrect_percentage; ?>%">
                                            <?php echo $pathology_incorrect; ?>
                                          </div>
                                        </div>
                                        <br>
                                        <table class="table table-sm table-striped">
                                              
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><b><?php echo $pathology_correct . " / "  . $pathology_total; ?></b></td>
                                              
                                            </tr>
                                            <tr>
                                              
                                              <td><b>Circulatory</b></td>
                                              <td><b><?php echo $pathology_current_circulatory_correct . " / " . $pathology_current_circulatory_total; ?></b></td>
                                            </tr>
                                            <tr>
                                              
                                              <td><b>Respiratory</b></td>
                                              <td><b><?php echo $pathology_current_respiratory_correct . " / " . $pathology_current_respiratory_total; ?></b></td>
                                            </tr>
                                          
                                        </table>
                                    </div>    
                                </div>
                            
                            <?php }; ?>
                            
                            
            			</div>
            		</div>
    			</div>
    		</div>
    	</div>
    </div>
    </body>
    <script>
        var options = {
            useEasing : true,
            useGrouping : true,
        };
        
        var c = new CountUp("counter",0,<?php echo $total_marks_correct; ?>,0,3,options);
        c.start();
        
        
    
    </script>

</html>