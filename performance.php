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
    $page_active = "performance";

    $accountType;

    //Subject Variables
    $anatomy_correct=0; 
    $anatomy_incorrect=0;
    $anatomy_total=0;

    $physiology_correct="0";
    $physiology_incorrect="0";
    $physiology_total="0";

    $pathology_correct="0";
    $pathology_incorrect="0";
    $pathology_total="0"; 


    //System variables
    $circulatory_anatomy_correct="0";
    $circulatory_anatomy_total="0";
    $circulatory_anatomy_percentage="0"; 

    $circulatory_physiology_correct="0";
    $circulatory_physiology_total="0";
    $circulatory_physiology_percentage="0";

    $circulatory_pathology_correct="0";
    $circulatory_pathology_total="0";
    $circulatory_pathology_percentage="0";

    $respiratory_physiology_correct="0";
    $respiratory_physiology_total="0";
    $respiratory_physiology_percentage="0";

    $respiratory_pathology_correct="0";
    $respiratory_pathology_total="0";
    $respiratory_pathology_percentage="0";


    $totalquestionsattempted;

    $errgraph=0;


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


    $sql = "SELECT anatomy_correct, 
                   anatomy_total,

                   physiology_correct,
                   physiology_total,

                   pathology_correct,
                   pathology_total,

                   circulatory_anatomy_correct,
                   circulatory_anatomy_total,

                   circulatory_physiology_correct,
                   circulatory_physiology_total,

                   circulatory_pathology_correct,
                   circulatory_pathology_total,

                   respiratory_physiology_correct,
                   respiratory_physiology_total,

                   respiratory_pathology_correct,
                   respiratory_pathology_total

                   FROM users_stats WHERE username='$userlogin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
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

            $circulatory_anatomy_correct = $row["circulatory_anatomy_correct"];
            $circulatory_anatomy_total = $row["circulatory_anatomy_total"];

            $circulatory_physiology_correct = $row["circulatory_physiology_correct"];
            $circulatory_physiology_total = $row["circulatory_physiology_total"];

            $circulatory_pathology_correct = $row["circulatory_pathology_correct"];
            $circulatory_pathology_total = $row["circulatory_pathology_total"];

            $respiratory_physiology_correct = $row["respiratory_physiology_correct"];
            $respiratory_physiology_total = $row["respiratory_physiology_total"];

            $respiratory_pathology_correct = $row["respiratory_pathology_correct"];
            $respiratory_pathology_total = $row["respiratory_pathology_total"];

            if($circulatory_anatomy_correct != 0){
                $circulatory_anatomy_percentage = round(($circulatory_anatomy_correct/$circulatory_anatomy_total)*100);
            }

            if($circulatory_physiology_correct != 0){
                $circulatory_physiology_percentage = round(($circulatory_physiology_correct/$circulatory_physiology_total)*100);
            }

            if($circulatory_pathology_correct != 0){
                $circulatory_pathology_percentage = round(($circulatory_pathology_correct/$circulatory_pathology_total)*100);
            }

            if($respiratory_physiology_correct != 0){
                $respiratory_physiology_percentage = round(($respiratory_physiology_correct/$respiratory_physiology_total)*100);
            }

            if($respiratory_pathology_correct != 0){
                $respiratory_pathology_percentage = round(($respiratory_pathology_correct/$respiratory_pathology_total)*100);
            }


            if($anatomy_total == "0" || $physiology_total =="0" || $pathology_total == "0" ){
                $errgraph=1;
            }
            $totalquestionsattempted = $anatomy_total + $physiology_total + $pathology_total;
        }
    } else {
        echo "<div class='alert alert-warning alert-dismissible fade show m-0' role='alert'>
      <strong>Oops!</strong> Something is broken!
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }
    $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>User Performance</title>
        
        <!-- Bootstrap 4 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 
        <!-- Fonts Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
        
        <!-- Google Fonts -->
       <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
       
        <!-- CSS -->
        <link href="css/front_pages.css" rel="stylesheet">  
 
    </head>
    <body>
        <div class="container-fluid p-0  vh-100"> <!--rgba(226, 227, 227, 0.29)-->
        	<div class="row no-gutters h-100">
        		<div class="col-sm-12 col-md-3 col-lg-2 p-0 shadow" id="sidemenu">
                    <?php 
                        include "sidemenu.php";
                    ?>
        		</div>
        		
        	    <div class="col-sm-12 col-md-9 col-lg-10 h-100" id="content">     <!-- Content Column -->
                    <div class="row no-gutters">
            	        <div class="col-md-12">
        	        	    <?php 
        	        	        if($errgraph==1){
        	        	            echo "<div class='alert alert-warning alert-dismissible fade show m-0' role='alert'>
                                      <strong>Oops!</strong> One or more graphs may not display because you haven't completed any questions for those categories!
                                      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                      </button>
                                    </div>";
        	        	        }
        	        	    
        	        	    ?>
            	        	         	    
                			<div id="page_header_div">
                    			<h2 id="page_header">Overall Performace</h2>
                    		</div>	
            			</div>
                    </div>
                    <div class="row no-gutters ml-4 mr-4 shadow bg-white rounded">
            	        <div class="col-md-6 p-4 overflow-auto">
            	     	    
                            <div class="card">
                                <h5 class="card-header" style="color:#2D3032;background-color:rgba(204, 237, 254, 0.25);">Total Questions Attempted</h5>
                                <div class="card-body">
                                        
                                    <canvas id="myTotalQChart" width="450" height="250"></canvas>
                    	                
                                 </div>
                            </div>
                    	       
            	        </div>
                        <div class="col-md-6 p-4">
            	        	    
            	            <div class="card">
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.25);">Systems - Correct percentage</h5>
                                <div class="card-body">
                                    <!--<canvas id="mySystemBarChart" width="460" height="300"></canvas>-->
            	                </div>
                            </div>
                    	        
            	        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-md-4 p-4">
        	        	        
        	        	   <div class="card shadow bg-white rounded" >
                               <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.35);">Anatomy</h5>
                               <div class="card-body">
            	                   <canvas id="myAnaChart" width="250" height="250"></canvas>
                               </div>
                           </div>
                    	        
            	       </div>
            	        	
            	       <div class="col-md-8 p-4">
        	        	        
        	               <div class="card shadow bg-white rounded" >
                               <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.35);">Anatomy by Systems</h5>
                               <div class="card-body">
            	                   <canvas id="anatomySystemBarChart" width="300" height="250"></canvas>
            	               </div>
                           </div>
                    	        
            	       </div>
                    </div>
            	        
            	    <div class="row no-gutters">
                        <div class="col-md-4 p-4">
             	        
             	            <div class="card shadow bg-white rounded" >
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.35);">Physiology</h5>
                                <div class="card-body">
        	     	                <canvas id="myPhysioChart" width="250" height="250"></canvas>
                 	            </div>
            	            </div>
                	        
        	        	</div>
                        <div class="col-md-8 p-4">
             	        
                            <div class="card shadow bg-white rounded" >
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.35);">Physiology by Systems</h5>
                                <div class="card-body">
                                    <canvas id="physiologySystemBarChart" width="300" height="250"></canvas>
                                </div>
                            </div>
                	        
                        </div>
                    </div>	
        	       <div class="row no-gutters">
        	        	<div class="col-md-4 p-4">
             	        
             	        <div class="card shadow bg-white rounded" >
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.35);">Pathology</h5>
                                <div class="card-body">
        	        	            <canvas id="myPathoChartCanvas" width="250" height="250"></canvas>
        	        	        </div>
                	        </div>
                	        
        	        	</div>
        	        	<div class="col-md-8 p-4">
        	        	        
             	        <div class="card shadow bg-white rounded" >
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.35);">Pathology by Systems</h5>
                                <div class="card-body">
        	        	             <canvas id="pathologySystemBarChart" width="300" height="250"></canvas>
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
        <script>
            Chart.defaults.global.legend.labels.usePointStyle = true;
            var ctxTotalQ = document.getElementById('myTotalQChart').getContext('2d');
            var myTotalQ = new Chart(ctxTotalQ, {
                type: 'polarArea',
                responsive:true,
                data: {
                    labels: ['Anatomy', 'Physiology', 'Pathology'],
                    datasets: [{
                        label: 'Total Questions Attempted',
                        data: [<?php echo htmlspecialchars($anatomy_total);?>, <?php echo htmlspecialchars($physiology_total);?>,<?php echo htmlspecialchars($pathology_total);?>],
                        backgroundColor: [
                            'rgba(7, 201, 146, 0.8)',
                            'rgba(255, 133, 45, 0.98)',
                            'rgba(0, 250, 255, 0.8)'
                        ],
                        borderColor: [
                            '#ffffff',
                            '#ffffff',
                            '#ffffff'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Total Questions Attempted - <?php echo htmlspecialchars($totalquestionsattempted); ?>'
                    },
                     animation: {
                         duration: 1000,
                    },
                    legend: {
                        position:'bottom'
                    },
                    responsive: true, maintainAspectRatio: false,
                }
            });
           
        </script>
        
        
        <script>
            var ctxana = document.getElementById('myAnaChart').getContext('2d');
            var myChart = new Chart(ctxana, {
                type: 'doughnut',
                responsive:true,
                data: {
                    labels: ['Total Correct', 'Total Incorrect'],
                    datasets: [{
                        label: 'Anatomy - All',
                        data: [<?php echo $anatomy_correct?>, <?php echo $anatomy_incorrect?>],
                        backgroundColor: [
                            'rgba(44, 187, 0, 0.9)',
                            'rgba(240, 34, 34, 0.9)'
                        ],
                        borderColor: [
                            '#FFFFFF',
                            '#FFFFFF'
                        ],
                        borderWidth: 3
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Anatomy - All'
                    },
                     animation: {
                         duration: 2000,
                    },
                    legend: {
                        position:'bottom'
                    },
                    responsive: true, maintainAspectRatio: false,cutoutPercentage:70,
                }
            });
        </script>
        <script>
            var ctxanatomySystemBarChart = document.getElementById('anatomySystemBarChart').getContext('2d');
            var anatomySystemBarChart = new Chart(ctxanatomySystemBarChart, {
                type: 'bar',
                responsive:true,
                data: {
                    labels: ['Circulatory Anatomy', 'Respiratory Anatomy(eg)', 'Renal Anatomy(eg)'],
                    datasets: 
                    [
                        {
                        label: 'Percent correct',
                        data: [<?php echo htmlspecialchars($circulatory_anatomy_percentage);?>,0,0],
                        backgroundColor: [
                            'rgb(224, 66, 69,0.5)',
                            'rgb(66, 69, 224,0.5)',
                            'rgb(76, 224, 66,0.5)'
                        ],
                        borderColor: [
                            'rgb(224, 66, 69)',
                            'rgb(66, 69, 224)',
                            'rgb(76, 224, 66)'
                        ],
                        borderWidth: 1
                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Correct Anatomy Questions by Systems'
                    },
                     animation: {
                         duration: 2500,
                    },
                    legend: {
                        position:'bottom',
                        display:false,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax:100,
                                callback: function(value, index, values) {
                                    return value + '%';
                                }
                            }
                        }]
                    },
                    tooltips: {
                      callbacks: {
                        label: function(tooltipItem, data) {
                          return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '%';
                        },
                      }
                    },
                    responsive: true, maintainAspectRatio: false,
                }
            });
           
        </script>
        
        
        
        
        <script>
            var ctxphysio = document.getElementById('myPhysioChart').getContext('2d');
            var myPhysioChart = new Chart(ctxphysio, {
                type: 'doughnut',
                data: {
                    labels: ['Total Correct', 'Total Incorrect'],
                    datasets: [{
                        label: 'Physiology - All',
                        data: [<?php echo $physiology_correct?>, <?php echo $physiology_incorrect?>],
                        backgroundColor: [
                            'rgba(7, 201, 49, 0.8)',
                            'rgba(247, 38, 48, 0.95)'
                        ],
                        borderColor: [
                            '#FFFFFF',
                            '#FFFFFF'
                        ],
                        borderWidth: 3
                    }]
                },
                options: {
                     title: {
                        display: true,
                        text: 'Physiology - All'
                    },
                    animation: {
                         duration: 3000,
                         
                     },
                    legend: {
                        position:'bottom'
                    },
                     responsive: true, maintainAspectRatio: false,cutoutPercentage:70,
            
                }
            });
        </script>
        <script>
            var ctxphysiologySystemBarChart = document.getElementById('physiologySystemBarChart').getContext('2d');
            var physiologySystemBarChart = new Chart(ctxphysiologySystemBarChart, {
                type: 'bar',
                responsive:true,
                data: {
                    labels: ['Circulatory Physiology', 'Respiratory Physiology(eg)', 'Renal Physiology(eg)'],
                    datasets: 
                    [
                        {
                        label: 'Percent correct',
                        data: [<?php echo htmlspecialchars($circulatory_physiology_percentage);?>,<?php echo htmlspecialchars($respiratory_physiology_percentage);?>,0],
                        backgroundColor: [
                            'rgb(224, 66, 69,0.5)',
                            'rgb(66, 69, 224,0.5)',
                            'rgb(76, 224, 66,0.5)'
                        ],
                        borderColor: [
                            'rgb(224, 66, 69)',
                            'rgb(66, 69, 224)',
                            'rgb(76, 224, 66)'
                        ],
                        borderWidth: 1
                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Percentage of Correct Anatomy Questions by Systems'
                    },
                     animation: {
                         duration: 2500,
                    },
                    legend: {
                        position:'bottom',
                        display:false,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax:100,
                                callback: function(value, index, values) {
                                    return value + '%';
                                }
                            }
                        }]
                    },
                    tooltips: {
                      callbacks: {
                        label: function(tooltipItem, data) {
                          return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '%';
                        },
                      }
                    },
                    responsive: true, maintainAspectRatio: false,
                }
            });
           
        </script>    
        <script>
            var ctxpatho = document.getElementById('myPathoChartCanvas').getContext('2d');
            var myPathoChart = new Chart(ctxpatho, {
                type: 'doughnut',
                data: {
                    labels: ['Total Correct', 'Total Incorrect'],
                    datasets: [{
                        label: 'Pathology - All',
                        data: [<?php echo $pathology_correct?>, <?php echo $pathology_incorrect?>],
                        backgroundColor: [
                            'rgba(7, 201, 49, 0.8)',
                            'rgba(247, 38, 48, 0.95)'
                        ],
                        borderColor: [
                            '#FFFFFF',
                            '#FFFFFF'
                        ],
                        borderWidth: 3
                    }]
                },
                options: {
                     title: {
                        display: true,
                        text: 'Pathology - All'
                    },
                    animation: {
                         duration: 3300,
                    },
                    legend: {
                        position:'bottom'
                    },
                     responsive: true, maintainAspectRatio: false,cutoutPercentage:70,
                }
            });
                
        </script>
        <script>
            var ctxpathologySystemBarChart = document.getElementById('pathologySystemBarChart').getContext('2d');
            var pathologySystemBarChart = new Chart(ctxpathologySystemBarChart, {
                type: 'bar',
                responsive:true,
                data: {
                    labels: ['Circulatory Pathology', 'Respiratory Pathology(eg)', 'Renal Pathology(eg)'],
                    datasets: 
                    [
                        {
                        label: 'Percent correct',
                        data: [<?php echo htmlspecialchars($circulatory_pathology_percentage);?>,<?php echo htmlspecialchars($respiratory_pathology_percentage);?>,0],
                        backgroundColor: [
                            'rgb(224, 66, 69,0.5)',
                            'rgb(66, 69, 224,0.5)',
                            'rgb(76, 224, 66,0.5)'
                        ],
                        borderColor: [
                            'rgb(224, 66, 69)',
                            'rgb(66, 69, 224)',
                            'rgb(76, 224, 66)'
                        ],
                        borderWidth: 1
                        }
                    ]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Percentage of Correct Anatomy Questions by Systems'
                    },
                     animation: {
                         duration: 2500,
                    },
                    legend: {
                        position:'bottom',
                        display:false,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax:100,
                                callback: function(value, index, values) {
                                    return value + '%';
                                }
                            }
                        }]
                    },
                    tooltips: {
                      callbacks: {
                        label: function(tooltipItem, data) {
                          return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '%';
                        },
                      }
                    },
                    responsive: true, maintainAspectRatio: false,
                }
            });
           
        </script>
</html>