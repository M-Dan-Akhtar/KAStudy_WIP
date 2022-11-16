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

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Subscription</title>
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
        
        <!-- Stripe API -->
        <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
        <script src="https://js.stripe.com/v3/"></script>
       
        <!-- CSS -->
        <link href="css/front_pages.css" rel="stylesheet">
        <link href="subscription.css" rel="stylesheet" >
        <link href="style2.css" rel="stylesheet" >
       <style>

            div#content {
                 overflow: auto;
               }    
            @media only screen and (max-device-width: 480px) {
              div#content {
                 overflow: visible;
                
               }
            }

            
       </style>     
      <!-- Pace Loader -->
      <script type="text/javascript" src="js/pace.min.js"></script>
 
    </head>
    <body>

        <div class="container-fluid p-0 vh-100"> <!--rgba(226, 227, 227, 0.29)-->
        	<div class="row no-gutters h-100">
    		    <div class="col-sm-12 col-md-3 col-lg-2 p-0 shadow" id="sidemenu">      <!-- Menu Column -->
    		        
        		    <div class="p-2 mb-0 text-white" id="sidemenutop">
        		        
        		        <br>
            		    <h4 class="p-2">K&A Study | <small class="text-muted">Medical</small></h4>
            		    <!-- <img src="img/KAMed2.png" class="ml-3 img-fluid"> -->
            		    <hr>
                        
    					<a class="userdropdown ml-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" >
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION["username"]); ?><i class="fa fa-sort-down float-right"></i>
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
            		   
            		    
        		    <br>
        		    <ul class="nav flex-column p-2 w-100">
        				<li class="nav-item">
        					<a class="nav-link rounded active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        				</li>
        				<br>
        				<li class="nav-item">
        					<a class="nav-link rounded" href="createtest.php"><i class="fas fa-pencil-alt"></i> Create a test</a>
        				</li>
        				<li class="nav-item">
        					<a class="nav-link rounded" href="performance.php"><i class="fas fa-chart-bar"></i> Performance</a>
        				</li>
        				<li class="nav-item">
        					<a class="nav-link rounded" href="search.php"><i class="fa fa-search"></i> Search</a>
        				</li>
        			</ul>
            			
        		</div>
        		
        		
        		<div class="col-sm-12 col-md-9 col-lg-10 h-100" id="content">     <!-- Content Column -->
        		
        		    
        		    
            		    <div class="row no-gutters">
            	        	<div class="col-md-12">
                    			<div style="margin-left:25px; margin-top:10px; padding-left:15px;">
                        			<h2 style="padding-left:10px; margin-right: 20px; margin-top:20px;margin-bottom:20px;border-left-style: solid; border-color:#3BBA9C; border-width:2px;">Subscription</h2>
                        		</div>	
                			</div>
                		</div>
                		<div class="row no-gutters ml-4 mr-4 shadow bg-white rounded">
            	        	<div class="col-md-12 p-4">
            	        	    
                                <div class="card">
                                    <h5 class="card-header" style="color:#2D3032;background-color:rgba(204, 237, 254, 0.25);">Choose your plan</h5>
                                    <div class="card-body">
                                        <p><b>All plans include:</b></p>
                                        <ul>
                                            <li>Full Question Bank inlcuding new questions</li>
                                            <li>Performance Graphs</li>
                                            <li>Search attempted questions including answers</li>
                                        </ul>
                                        
                    	                <div class="row">
                    	                    <div class="col-sm-12 col-md-4 mb-1">
                                                
                                                    <div class="product shadow">
                                                        <img
                                                        src="https://i.imgur.com/EHyR2nP.png"
                                                        alt="The cover of Stubborn Attachments"
                                                        />
                                                        <div class="description">
                                                            <h3>1 Month Plan</h3>
                                                            <h5>$5.00</h5>
                                                        </div>
                                                    </div>
                                                    <button id="checkout-button-1">Select</button>
                                                
                                            </div>    
                                        
                                            <div class="col-sm-12 col-md-4 mb-1">
                                                
                                                    <div class="product shadow">
                                                        <img
                                                        src="https://i.imgur.com/EHyR2nP.png"
                                                        alt="The cover of Stubborn Attachments"
                                                        />
                                                        <div class="description">
                                                            <h3>3 Month Plan</h3>
                                                            <h5>$15.00 </h5>
                                                        </div>
                                                    </div>
                                                    <button id="checkout-button-3">Select</button>
                                                
                                            </div>
                                            <div class="col-sm-12 col-md-4 mb-1">
                                            
                                                
                                                    <div class="product shadow">
                                                        <img
                                                        src="https://i.imgur.com/EHyR2nP.png"
                                                        alt="The cover of Stubborn Attachments"
                                                        />
                                                        <div class="description">
                                                            <h3>6 Month Plan</h3>
                                                            <h5>$30.00</h5>
                                                        </div>
                                                    </div>
                                                    <button id="checkout-button-6">Select</button>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="columns">
                                            
                                        </div>
                                        
                                        <div class="columns">
                                            
                                        </div>
                    	                
                    	            </div>
                    	        </div>
                    	       
            	        	</div>
            	        	
            	        </div>

        			</div>
        		</div>
        	</div>
        </div>
    </body>
    
    <script type="text/javascript">
        // Create an instance of the Stripe object with your publishable API key
        var stripe = Stripe("pk_test_5otykzKEQZbN7CmrVXObWBkq00ExbuJ84a");
        var checkoutButton1 = document.getElementById("checkout-button-1");
        checkoutButton1.addEventListener("click", function () {
          fetch("/create-checkout-session-1.php", {
            method: "POST",
          })
            .then(function (response) {
              return response.json();
            })
            .then(function (session) {
              return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function (result) {
              // If redirectToCheckout fails due to a browser or network
              // error, you should display the localized error message to your
              // customer using error.message.
              if (result.error) {
                alert(result.error.message);
              }
            })
            .catch(function (error) {
              console.error("Error:", error);
            });
        });
        
        // Create an instance of the Stripe object with your publishable API key
        
        var checkoutButton3 = document.getElementById("checkout-button-3");
        checkoutButton3.addEventListener("click", function () {
          fetch("/create-checkout-session-3.php", {
            method: "POST",
          })
            .then(function (response) {
              return response.json();
            })
            .then(function (session) {
              return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function (result) {
              // If redirectToCheckout fails due to a browser or network
              // error, you should display the localized error message to your
              // customer using error.message.
              if (result.error) {
                alert(result.error.message);
              }
            })
            .catch(function (error) {
              console.error("Error:", error);
            });
        });
        
        var checkoutButton6 = document.getElementById("checkout-button-6");
        checkoutButton6.addEventListener("click", function () {
          fetch("/create-checkout-session-6.php", {
            method: "POST",
          })
            .then(function (response) {
              return response.json();
            })
            .then(function (session) {
              return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function (result) {
              // If redirectToCheckout fails due to a browser or network
              // error, you should display the localized error message to your
              // customer using error.message.
              if (result.error) {
                alert(result.error.message);
              }
            })
            .catch(function (error) {
              console.error("Error:", error);
            });
        });
    </script>
</html>