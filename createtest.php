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
    $page_active = "create_test"; 
    
    $accountType;
    
    
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
    
    
    
 
$anatomy_total_questions="0";
$anatomy_circulatory_totalquestions="0";

$physiology_total_questions="0";
$physiology_circulatory_totalquestions="0";
$physiology_respiratory_totalquestions="0";
$physiology_renal_totalquestions="0";

$pathology_total_questions="0";
$pathology_circulatory_totalquestions="0";
$pathology_respiratory_totalquestions="0";

$biochemistry_total_questions="7";
$biochemistry_cellular_totalquestions="7";


$sql = "SELECT * FROM QCategory_Table WHERE Subject=? AND System=?"; // SQL with parameters
$stmt = $conn->prepare($sql); 
$stmt->bind_param("ss",$subject, $system);

$subject="Anatomy";
$system="Circulatory";

$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_NUM); // get the mysqli result
if(!$result) exit('No rows');
$anatomy_total_questions += count($result);
$anatomy_circulatory_totalquestions = count($result);

$subject="Physiology";
$system="Circulatory";

//$stmt->bind_param("ss",$subject, $system);
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_NUM); // get the mysqli result
if(!$result) exit('No rows');
$physiology_total_questions += count($result);
$physiology_circulatory_totalquestions = count($result);


$subject="Physiology";
$system="Respiratory";

//$stmt->bind_param("ss",$subject, $system);
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_NUM); // get the mysqli result
if(!$result) exit('No rows');
$physiology_total_questions += count($result);
$physiology_respiratory_totalquestions = count($result);

$subject="Physiology";
$system="Renal";

//$stmt->bind_param("ss",$subject, $system);
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_NUM); // get the mysqli result
if(!$result) exit('No rows');
$physiology_total_questions += count($result);
$physiology_renal_totalquestions = count($result);


$subject="Pathology";
$system="Circulatory";

//$stmt->bind_param("ss",$subject, $system);
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_NUM); // get the mysqli result
if(!$result) exit('No rows');
$pathology_total_questions += count($result);
$pathology_circulatory_totalquestions = count($result);

$subject="Pathology";
$system="Respiratory";

//$stmt->bind_param("ss",$subject, $system);
$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_NUM); // get the mysqli result
if(!$result) exit('No rows');
$pathology_total_questions += count($result);
$pathology_respiratory_totalquestions = count($result);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Create Test</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            
            <!-- CSS -->
            <link href="css/front_pages.css" rel="stylesheet"> 
            <!-- CSS -->
            <link href="css/custom_check_radio.css" rel="stylesheet"> 
            
            <!-- Pace Loader -->
            <script type="text/javascript" src="js/pace.min.js"></script>
            <style>
                .custom-range::-webkit-slider-thumb {
                              -webkit-appearance: none;
                              appearance: none;
                              width: 50px;
                              
                }
                
                .custom-range::-moz-range-thumb {
                  width: 25px;
                  height: 25px;
                }
                
                            
            div#content {
     overflow: auto;
   }    
@media only screen and (max-device-width: 480px) {
  div#content {
     overflow: visible;
    
   }
}

            </style>
      
    </head>
    <body>
    <!-- Website template divisions -->
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
        	           		<div style="margin-left:25px; margin-top:10px; padding-left:15px;">
                    			<h2 style="padding-left:10px; margin-right: 20px; margin-top:20px;margin-bottom:20px;border-left-style: solid; border-color:#3BBA9C; border-width:2px;">Create Test
                    			</h2>
                    			<p>You must attempt all questions to save your progess</p>
                    		</div>	
            			</div>
            		</div>
            		
        		    <div class="row no-gutters">
        	        	<div class="col-md-12 p-4">
                			
                            
                            <!-- Website Functionality -->
                            
                            
                            <div class="card shadow mb-5">
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.25);">Test Options 
                                <a href="#" data-toggle="popover" data-html="true" data-trigger="focus" 
                                            data-content="Tutor - Untimed test with answers and explanations."><i class="fa fa-info-circle"></i></a></h5>
                                            
                                <div class="card-body">
                            
                                    <form class="form-inline" autocomplete="off">
                                        <div class="form-check form-check-inline">
                                            <label class="container_radio">Tutor
                                                <input class="form-check-input" type="radio" id="tutor_rad" name="tutor_or_timed" value="Tutor Test" checked>
                                                <span class="checkmark_radio"></span>
                                            </label>
                                        
                                        
                                                 <!--<label class="form-check-input" for="unused_question_rad">Unused</label><br>-->
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                            
                                
                            <div class="card shadow mb-5">
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.25);">Question Option 
                                <a href="#" data-toggle="popover" data-html="true" data-trigger="focus" 
                                            data-content="<hr>Unused - Selects questions from a set of new/unseen questions.<hr>All - Selects questions from a set of previously seen and unseen questions.<hr>"><i class="fa fa-info-circle"></i></a></h5>
                                            
                                <div class="card-body">
                            
                                    <form class="form-inline" autocomplete="off">
                                        <div class="form-check form-check-inline">
                                            <label class="container_radio">All
                                                <input class="form-check-input" type="radio" id="all_question_rad" name="unused_or_all" value="All Questions" checked>
                                                <span class="checkmark_radio"></span>
                                            </label>
                                        
                                        
                                                 <!--<label class="form-check-input" for="unused_question_rad">Unused</label><br>-->
                                        </div>
                                        <div class="form-check form-check-inline">
                                                
                                            <label class="container_radio">Unused    
                                                <input class="form-check-input" type="radio" id="unused_question_rad" name="unused_or_all" value="Unused Questions">
                                                <span class="checkmark_radio"></span>
                                            </label>
                                            
                                                <!-- <label class="form-check-input" for="all_question_rad"></label><br>-->
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
    
                            <div class="card shadow mb-5">
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.25);">Subjects</h5>
                                <div class="card-body">
                                    
                                    <!-- Anatomy -->
                                    <form autocomplete="off">
                                        
                                        
                                        <label class="container_checkbox">Anatomy
                                            <input type="checkbox" name="anatomy_cat" id="chk_anatomy_cat" value = "Anatomy Category" onclick="openAnaCat()">
                                            <span class="checkmark"></span><span class="badge badge-pill badge-info"><?php echo $anatomy_total_questions; ?></span>
                                        </label>
                                        
                                        <div id="div_ana_cat" style="display:none;margin-left:25px">
                                            <label class="container_checkbox"> Circulatory System
                                                <input type="checkbox" name="anatomy_cat"  id="chk_anatomy_cardio" value="Anatomy Circulatory">
                                                <span class="checkmark"></span><span class="badge badge-pill badge-secondary"><?php echo $anatomy_circulatory_totalquestions; ?></span>
                                            </label>
                                        
                                       <!--  OLD CHECK BOXES
                                       
                                        <input type="checkbox" name="anatomy_cat" id="chk_anatomy_cat" value = "Anatomy Category" onclick="openAnaCat()">
                                        <label> Anatomy <span class="badge badge-pill badge-info"><?php echo $anatomy_total_questions; ?></span></label>
                                        
                                        <div id="div_ana_cat" style="display:none;margin-left:10px">
                                            <input type="checkbox" name="anatomy_cat"  id="chk_anatomy_cardio" value="Anatomy Cardiology">
                                            <label> Circulatory System <span class="badge badge-pill badge-secondary"><?php echo $anatomy_cardiology_totalquestions; ?></span></label>
                                            
                                            <input type="checkbox" name="anatomy_cat"  id="chk_anatomy_resp" value="Anatomy Respiratory">
                                            <label> Respiratory System</label>
                                            
                                            <input type="checkbox" name="anatomy_cat" id="chk_anatomy_renal" value="Anatomy Renal">
                                            <label> Renal System</label>
                                        -->
                                            
                                        </div>
                                    </form>
                        
                                    <!-- Physiology -->    
                                    <form autocomplete="off">
                                        <label class="container_checkbox">Physiology
                                            <input type="checkbox" name="physiology_cat" id="chk_physiology_cat" value = "Physiology Category" onclick="openPhysioCat()">
                                            <span class="checkmark"></span><span class="badge badge-pill badge-info"><?php echo $physiology_total_questions; ?></span>
                                        </label>
                                
                                        
                                        <div id="div_physio_cat" style="display:none;margin-left:25px">
                                            <label class="container_checkbox"> Circulatory System
                                                <input type="checkbox" name="physiology_cat"  id="chk_physiology_cardio" value="Physiology Circulatory">
                                                <span class="checkmark"></span><span class="badge badge-pill badge-secondary"><?php echo $physiology_circulatory_totalquestions; ?></span>
                                            </label>
                                            
                                            <label class="container_checkbox"> Respiratory System                                
                                                <input type="checkbox" name="physiology_cat"  id="chk_physiology_resp" value="Physiology Respiratory">
                                                <span class="checkmark"></span><span class="badge badge-pill badge-secondary"><?php echo $physiology_respiratory_totalquestions; ?></span>
                                            </label>
                                            
                                            <label class="container_checkbox"> Renal System                                
                                                <input type="checkbox" name="physiology_cat"  id="chk_physiology_renal" value="Physiology Renal">
                                                <span class="checkmark"></span><span class="badge badge-pill badge-secondary"><?php echo $physiology_renal_totalquestions; ?></span>
                                            </label>        
                                        </div>
                                    </form>
                    
                                    <!-- Pathology -->    
                                    <form autocomplete="off">
                                        <label class="container_checkbox"> Pathology
                                            <input type="checkbox" name="pathology_cat" id="chk_pathology_cat" value = "Pathology Category" onclick="openPathoCat()">
                                            <span class="checkmark"></span><span class="badge badge-pill badge-info"><?php echo $pathology_total_questions; ?></span>
                                        </label>
                                        
                                        <div id="div_patho_cat" style="display:none;margin-left:25px">
                                            
                                            <label class="container_checkbox"> Circulatory System
                                                <input type="checkbox" name="pathology_cat"  id="chk_pathiology_cardio" value="Pathology Circulatory">
                                                <span class="checkmark"></span><span class="badge badge-pill badge-secondary"><?php echo $pathology_circulatory_totalquestions; ?></span>
                                            </label>
                                            
                                            <label class="container_checkbox"> Respiratory System
                                                <input type="checkbox" name="pathology_cat"  id="chk_pathology_resp" value="Pathology Respiratory">
                                                <span class="checkmark"></span><span class="badge badge-pill badge-secondary"><?php echo $pathology_respiratory_totalquestions; ?></span>
                                            </label>
                                         <!--   <input type="checkbox" name="pathology_cat" id="chk_pathology_renal" value="Pathology Renal">
                                            <label> Renal System</label> -->
                                            
                                        </div>
                                    </form>
                                    
                                    <!-- Biochemistry -->    
                                    <form autocomplete="off">
                                        <label class="container_checkbox">Biochemistry
                                            <input type="checkbox" name="biochemistry_cat" id="chk_biochemistry_cat" value = "Biochemistry Category" onclick="openBiochemCat()">
                                            <span class="checkmark"></span><span class="badge badge-pill badge-info"><?php echo $biochemistry_total_questions; ?></span>
                                        </label>
                                
                                        
                                        <div id="div_biochem_cat" style="display:none;margin-left:25px">
                                            <label class="container_checkbox"> Cellular
                                                <input type="checkbox" name="biochemistry_cat"  id="chk_biochemistry_cellular" value="Biochemistry Cellular">
                                                <span class="checkmark"></span><span class="badge badge-pill badge-secondary"><?php echo $biochemistry_cellular_totalquestions; ?></span>
                                            </label>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
    
                            <div class="card shadow mb-5">
                                <h5 class="card-header" style="background-color:rgba(204, 237, 254, 0.25);">Number of Questions</h5>
                                <div class="card-body">
                                    
                                    <!-- Select number of questinos -->
                                    <div class="slidecontainer w-50">
                                      <input autocomplete="off" type="range" min="10" max="50" step="2" value="10" class="custom-range" id="myQRange">
                                      
                                    </div>
                                    <p>Number of questions: <span id="qvalue"></span></p>
                                </div>
                            </div>    
    
                            <!-- Next -->    
                            <input type="button" class="btn btn-primary btn" value="Create Test" onclick="checkQuestions()">

                        </div>
                    </div>

    <!-- Website Functionality End-->
        		</div>
        	</div>
        </div>
        
        <!-- Modals -->
    
        <div class="modal fade" id="myModalNoQuestions">
          <div class="modal-dialog">
            <div class="modal-content">
        
              <!-- Modal Header -->
              <div class="modal-header bg-dark text-white">
                <h4 class="modal-title">Error</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
        
              <!-- Modal body -->
              <div class="modal-body">
                Please select subjects and systems to continue.
              </div>
        
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
        
            </div>
          </div>
        </div>

    </body>
        
        
        
    <script>
        var slider = document.getElementById("myQRange");
        var output = document.getElementById("qvalue");
        output.innerHTML = slider.value; // Display the default slider value
        
        // Update the current slider value (each time you drag the slider handle)
        slider.oninput = function() {
          output.innerHTML = this.value;
        }
        
        function openAnaCat() {
          var checkBox = document.getElementById("chk_anatomy_cat");
          var divBox = document.getElementById("div_ana_cat");
          if (checkBox.checked == true){
            divBox.style.display = "block";
          } else {
            divBox.style.display = "none";
          }
        }
        
        function openPhysioCat() {
          var checkBox = document.getElementById("chk_physiology_cat");
          var divBox = document.getElementById("div_physio_cat");
          if (checkBox.checked == true){
            divBox.style.display = "block";
          } else {
            divBox.style.display = "none";
          }
        }
        
       function openPathoCat() {
          var checkBox = document.getElementById("chk_pathology_cat");
          var divBox = document.getElementById("div_patho_cat");
          if (checkBox.checked == true){
            divBox.style.display = "block";
          } else {
            divBox.style.display = "none";
          }
        }
        
        function openBiochemCat() {
          var checkBox = document.getElementById("chk_biochemistry_cat");
          var divBox = document.getElementById("div_biochem_cat");
          if (checkBox.checked == true){
            divBox.style.display = "block";
          } else {
            divBox.style.display = "none";
          }
        }
        
        function checkQuestions() {
           
            var tutor_rad = document.getElementById("tutor_rad");
            var unused_rad = document.getElementById("unused_question_rad");
            var anatomy_form = document.forms[2];
            var physiology_form = document.forms[3];
            var pathology_form = document.forms[4];
            var biochemistry_form = document.forms[5];
            var txt = "";
            var i;
            var forml=0;
            var numofquestions = slider.value;
            var unusedq=false;  
            var tutormode=true;  
            
              if(unused_rad.checked){
                  //setCookie('unused',true,1);
                  unusedq=true;
              }else{
                  //setCookie('unused',false,1);
                  unusedq=false;
              }
              
              if(tutor_rad.checked){
                  //setCookie('unused',true,1);
                  tutormode=true;
              }else{
                  //setCookie('unused',false,1);
                  tutormode=false;
              }
              
              if(anatomy_form[0].checked){
                  for (i = 1; i < anatomy_form.length; i++) {
                    if (anatomy_form[i].checked) {
                      txt = txt + "(" + anatomy_form[i].value + ") <br>";
                      forml++;
                    }
                  }
              }
              if(physiology_form[0].checked){
                  for (i = 1; i < physiology_form.length; i++) {
                    if (physiology_form[i].checked) {
                      txt = txt + "(" + physiology_form[i].value + ") <br>";
                      forml++;
                    }
                  }
              }
              if(pathology_form[0].checked){
                  for (i = 1; i < pathology_form.length; i++) {
                    if (pathology_form[i].checked) {
                      txt = txt + "(" + pathology_form[i].value + ") <br>";
                      forml++;
                    }
                  }
              }
              if(biochemistry_form[0].checked){
                  for (i = 1; i < biochemistry_form.length; i++) {
                    if (biochemistry_form[i].checked) {
                      txt = txt + "(" + biochemistry_form[i].value + ") <br>";
                      forml++;
                    }
                  }
              }
              
              if(txt!=""){
                //document.getElementById("textpr").innerHTML = "You chose:<br> " + txt + "<br>Number of Questions: " + numofquestions;
                
                //setCookie('cname',txt,1);
                //setCookie('cnum',forml,1);
                //setCookie('qnum',numofquestions,1);
                //window.location.href = 'selectQPOST.php';
                
                
                
                var form = document.createElement("form");
                    document.body.appendChild(form);
                    form.method = "POST";
                    form.action = "selectQPOST.php";
                    
                    var element1 = document.createElement("INPUT");         
                    element1.name="cname";
                    element1.value = txt;
                    element1.type = 'hidden';
                    form.appendChild(element1);
                    
                    var element2 = document.createElement("INPUT");         
                    element2.name="cnum";
                    element2.value = forml;
                    element2.type = 'hidden';
                    form.appendChild(element2);
                    
                    var element3 = document.createElement("INPUT");         
                    element3.name="qnum";
                    element3.value = numofquestions;
                    element3.type = 'hidden';
                    form.appendChild(element3);
                    
                    var element4 = document.createElement("INPUT");         
                    element4.name="unused";
                    element4.value = unusedq;
                    element4.type = 'hidden';
                    form.appendChild(element4);
                    
                    var element5 = document.createElement("INPUT");         
                    element5.name="tutormode";
                    element5.value = tutormode;
                    element5.type = 'hidden';
                    form.appendChild(element5);
                    
                    form.submit();
              }else{
                $("#myModalNoQuestions").modal('show');  
              }
              
              
        }
        
        function setCookie(name, value, daysToLive) {
            // Encode value in order to escape semicolons, commas, and whitespace
            var cookie = name + "=" + encodeURIComponent(value);
            
            if(typeof daysToLive === "number") {
                /* Sets the max-age attribute so that the cookie expires
                after the specified number of days */
                cookie += "; max-age=" + (daysToLive*60);
                
                document.cookie = cookie;
                //document.getElementById("textpr").innerHTML = "cookie set";
            }
        }
       
          
        
    </script>    
    <script>
        $(document).ready(function(){
          $('[data-toggle="popover"]').popover();
        });
    </script>
    
    </body>
</html>