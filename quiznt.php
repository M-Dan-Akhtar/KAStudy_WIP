<?php   
    // Initialize the session   
    session_start();
    // Check if the user is logged in, if not then redirect him to login page 
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    
    // Get question numbers from the cookie and parse it into array 
    if(isset($_COOKIE["qnumber"])){
        $sanitizedallqnumbers = filter_var($_COOKIE["qnumber"], FILTER_SANITIZE_STRING);
        $allqnumbers = explode(" ",$sanitizedallqnumbers);
    } else{
       // echo "<script>window.location.replace('createtest.php');</script>";
        header("location: createtest.php");
    }
    
    $no_question_err="";
    if(isset($_COOKIE["err"])){
        $no_question_err = '<div class="alert alert-warning alert-dismissible fade show m-0" role="alert">
                                <strong>Oops!</strong> We currently don\'t have the required amount of questions from the selected categories.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
    }
    
    require_once("../config.php"); 
    
    //Variables to hold results of the test
    $userlogin = $_SESSION["username"];
    
    $anatomy_correct;
    $anatomy_total;
    $physiology_correct;
    $physiology_total;
    $pathology_correct;
    $pathology_total;
    
    $circulatory_anatomy_correct;
    $circulatory_anatomy_total;
    $circulatory_physiology_correct;
    $circulatory_physiology_total;
    $circulatory_pathology_correct;
    $circulatory_pathology_total;
    
    $respiratory_physiology_correct;
    $respiratory_physiology_total;
    $respiratory_pathology_correct;
    $respiratory_pathology_total;

    //Read overall user's results so we can add them back with new results     
    $sql = "SELECT anatomy_correct, anatomy_total,
                   physiology_correct, physiology_total, 
                   pathology_correct, pathology_total,
                   
                   circulatory_anatomy_correct,circulatory_anatomy_total,
                   circulatory_physiology_correct,circulatory_physiology_total,
                   circulatory_pathology_correct,circulatory_pathology_total,
                   
                   respiratory_physiology_correct,respiratory_physiology_total,
                   respiratory_pathology_correct, respiratory_pathology_total
                   
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
            $anatomy_total = $row["anatomy_total"];
            $physiology_correct = $row["physiology_correct"];
            $physiology_total = $row["physiology_total"];
            $pathology_correct = $row["pathology_correct"];
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
            $respiratory_pathology_total = $row["respiratory_pathology_correct"];
        }
    } else {
    
    }
    
    
    
    
    
    $allQuestionsArray = array();                                               //This will hold all the question/answers/explainations
    $arrayCounter = 0;
    
    $sql = "SELECT      id, 
                        Question_ID, 
                        Question_Body, 
                        Answer1, 
                        Answer2, 
                        Answer3, 
                        Answer4,
                        Answer5,
                        Correct_Answer, 
                        Answer1_Explanation 
                FROM    Question_Table 
                WHERE   Question_ID=?";
    
        $stmt = $conn->prepare($sql); 
        
    //Loop to read all the questions from question ID in $allqnumbers
    for($x = 0; $x < count($allqnumbers)-1; $x++){                              //For loop Open
    
        
        $stmt->bind_param("s",$allqnumbers[$x]);
        $stmt->execute();
        
        $result = $stmt->get_result(); // get the mysqli result
        
        if ($result->num_rows > 0) {
            // output data of each row and save it in array for later use
            while($row = $result->fetch_assoc()) {
                
                $allQuestionsArray[$arrayCounter] = array($row["Question_ID"],
                                                          $row["Question_Body"],
                                                          $row["Answer1"],
                                                          $row["Answer2"],
                                                          $row["Answer3"],
                                                          $row["Answer4"],
                                                          $row["Answer5"],
                                                          $row["Correct_Answer"],
                                                          $row["Answer1_Explanation"]);
                                                    
                $arrayCounter++;
            }
        } else {
            echo "QCategory Table doesnt match with Question Table";        //QCategory Table doesnt match with Question Table
        }
    }                                                                       //For loop Close 
    $conn->close();                                                         //Close connection to database
    
    $arrayLength = count($allQuestionsArray);                               //Number of questions in the array

?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <title>Quiz Page</title> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> 

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        
        <link rel="stylesheet" href="css/quiz.css">
        <!-- Google Fonts -->
       <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

        <style type=text/css> 
        
        :root {
          --scrollbar-width: 9px;
        }
        
        @media only screen and (max-device-width:480px) {
            :root {
              --scrollbar-width: 2px;
            }        
        }
        
        body{
        font-family: 'Montserrat'; !important;
        }

        ::-webkit-scrollbar {
          width: var(--scrollbar-width);
          height: 8px;
        }
        ::-webkit-scrollbar-button {
          width: 0px;
          height: 0px;
        }
        ::-webkit-scrollbar-thumb {
          background: #3b3b3b;
          border: 1px solid #838383;
          border-radius: 50px;
        }
        ::-webkit-scrollbar-thumb:hover {
          background: #3b3b3b;
          border: 1px solid #FFFFFF;
        }
        ::-webkit-scrollbar-thumb:active {
          background: #000000;
        }
        ::-webkit-scrollbar-track {
          background: #EEEEEE;
          border: 0px none #ffffff;
          border-radius: 0px;
        }
        ::-webkit-scrollbar-track:hover {
          background: #EEEEEE;
        }
        ::-webkit-scrollbar-track:active {
          background: #EEEEEE;
        }
        ::-webkit-scrollbar-corner {
          background: transparent;
        }

        /* Pace Loader */
        .pace {
          -webkit-pointer-events: none;
          pointer-events: none;
        
          -webkit-user-select: none;
          -moz-user-select: none;
          user-select: none;
        
          z-index: 2000;
          position: fixed;
          margin: auto;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          height: 5px;
          width: 200px;
          background: #fff;
          border: 1px solid #29d;
        
          overflow: hidden;
        }
        
        .pace .pace-progress {
          -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
          -ms-box-sizing: border-box;
          -o-box-sizing: border-box;
          box-sizing: border-box;
        
          -webkit-transform: translate3d(0, 0, 0);
          -moz-transform: translate3d(0, 0, 0);
          -ms-transform: translate3d(0, 0, 0);
          -o-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0);
        
          max-width: 200px;
          position: fixed;
          z-index: 2000;
          display: block;
          position: absolute;
          top: 0;
          right: 100%;
          height: 100%;
          width: 100%;
          background: #29d;
        }
        
        .pace.pace-inactive {
          display: none;
        }
            

        #gradientTop {
        background: rgb(2,0,36);
        background: linear-gradient(180deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 100%, rgba(0,14,255,1) 100%);
          
        }
        #grad {
          background-color: white; /* For browsers that do not support gradients */
          /*background-image: linear-gradient(#292b2c, black); /* Standard syntax (must be last) */
          
        }
        
       
        .module {
          height: 100vh; /* Use vh as a fallback for browsers that do not support Custom Properties */
          height: calc(var(--vh, 1vh) * 100);
          
          
        }
        </style> 
      <!-- Pace Loader -->
      <script type="text/javascript" src="js/pace.min.js"></script>
      
    </head>
    <body> 
    <?php
        /* Read all the question numbers from the cookie and parse it into an array
           Connect to database, use a loop to go thru the array and get all the questions/answers/explanations from the database and save all of it in an array. Close connection to database
           Count the array and make a division for all the Question# buttons, each button has ID same as its question ID
           Loop through the array and print all the questions answers in a form, make a button to check answer. Make result box for the question.
        */
        
        


    ?>
        <!--Main Container Open -->
        <div class="container-fluid p-0 m-0 border border-dark d-flex flex-column overflow-hidden module">  
        <div class="row no-gutters">                                         <!--Header Row Open-->
		<div class="col-sm-12 pt-2 pl-3 bg-dark text-white d-flex"><!--Header Column Open-->
		<!-- <h3>Pecker's | <small class="text-muted">Medical</small></h3> -->
		<img src="img/KAMed2.png" class="ml-3 img-fluid">
<!--		echo "<h1>Website Testing</h1>
		echo "<a href='#' class='btn btn-secondary float-right pt-2 ml-auto mr-2 mt-1 mb-1'><i class='fa fa-lg fa-sticky-note'></i></a>  -->                                      <!--         //Notepad -->
		<a href='#' id='exitbtn' class='btn btn-danger float-right ml-auto mr-2 mt-1 mb-1' data-toggle='modal' data-target='#exitModal'>Exit</a>                                <!--                 //Exit -->
		
        </div>                                                       <!--  //Header Column Close -->
        </div>                                                      <!--    //Header Row Close -->
        
        <!--*** Start Question Division -->
        <!--Display Question Buttons in a division-->
        <div class='row no-gutters' style='height:92%'>                          <!--//Content Row Open-->
		<div class='col-2 col-sm-1 h-100 overflow-auto'>           <!-- //Button Column Open-->
		<div class="">                                                <!--  //Left Division overflow division open-->
		            
        <div class='btn-group-vertical btn-block bg-dark'>                     <!-- //Button Group Division Open-->
        <?php
        
        //Print left side question buttons in 2 different colors
        for ($row = 0; $row < $arrayLength; $row++){                            //For loop open
            $qnumber = $row + 1;
            
            if($row % 2 == 0){ 
                echo "<input type ='button' 
                             class = 'btn btn-info w-100 border border-dark' 
                             id = 'lbtn" . $row . "' 
                             onclick = 'showqdiv(" . $row . ")' 
                             value = ' * " . $qnumber . "'>";  
            } 
            else{ 
                echo "<input type = 'button' 
                             class = 'btn btn-light w-100 border border-dark'
                             id = 'lbtn" . $row . "' 
                             onclick = 'showqdiv(" . $row . ")' 
                             value = ' * " . $qnumber . "'>";
            } 
        }                                                                       //For loop Close
        
        echo "</div>";                                                          //Button Group Division Close
        echo "</div>";                                                          //Left Division Overflow Close 
        echo "</div>";                                                          //Button Column Close
        //***End  Question List Division
        ?>
        
        
        <!--Start Question Dispaly Division-->
        
        <div class='col-10 col-sm-11 h-100 border border-dark border-bottom-0' style="background-color:rgba(226, 227, 227, 0.19)">           <!--Quesion Column Open-->
                   
        <div class='overflow-auto h-100'>                                       <!--Right Division Overflow Open-->
        
        <?php
        echo $no_question_err;
        //Loop to go thru each row in the array
        for($row = 0; $row < $arrayLength; $row++){                             //For loop gothru database row Open
            $qNumber = $row + 1;        //Display the question number(row starts at 0 question starts at 1)
            $answerAlphabet = "Z";      //Store the correct answer for the current question
            $qAnswer = "";
            $ansExp = "";
            $questionid = $allQuestionsArray[$row][0];
            //Make a division and print the question/answer in the division
            echo "<div class='col-sm-12' style='background-color:transparent;display:none;'id='show" . $row ."'>";
                        echo "<hr>";
            echo "<form class='qForm" . $row . "' id='qForm" . $row . "'>";
            echo "<fieldset>";
            echo "<h2>Question " . $qNumber . "</h2>";
            echo "<h6 align='right' style='padding:5px'>Question ID: " . $questionid . "</h6>";

            
            //Loop to go thru each column and print all the questions and answers as well as save correct answer
            for($col = 1; $col < 9; $col++){                                    //For loop database columns Open
                if($col ==1){                                                   //column 1 is question
                    echo "<h5 style='line-height: 1.7;'>";
                    echo trim($allQuestionsArray[$row][$col]);
                    echo "</h5>";
                }else if($col == 2){                            //column 2 is first answer, 3-4-5 are next answers
                    $answerAlphabet = "A";
                    echo "<div class='custom-control custom-radio border border-dark border-bottom-0 pl-1 pt-1'>"; //bootstrap custom radio button
                    echo '<label class="container_radio">A) '. trim($allQuestionsArray[$row][$col]);;
                    echo "<input type='radio' class='custom-control-input' id='" . $row . $answerAlphabet . "' name='ansForm" . $row . "' value='" . $answerAlphabet . "'>";
                    echo '<span class="checkmark_radio"></span>';
                    echo '</label>';
                    //echo "<label class='custom-control-label' for='" . $row .  $answerAlphabet . "'>";
                    //echo "A) " . trim($allQuestionsArray[$row][$col]);
                    //echo "</label><br>";
                    echo "</div>";  //close bootstrap div 
                }else if($col == 3){
                    $answerAlphabet = "B";
                    echo "<div class='custom-control custom-radio border border-dark border-top-0 border-bottom-0 pl-1 pt-1'>"; //bootstrap custom radio button
                    echo '<label class="container_radio">B) '. trim($allQuestionsArray[$row][$col]);;
                    echo "<input type='radio' class='custom-control-input' id='" . $row . $answerAlphabet . "' name='ansForm" . $row . "' value='" . $answerAlphabet . "'>";
                    echo '<span class="checkmark_radio"></span>';
                    echo '</label>';
                    //echo "<label class='custom-control-label' for='" . $row . $answerAlphabet . "'>";
                    //echo "B) " . trim($allQuestionsArray[$row][$col]);
                    //echo "</label><br>";
                    echo "</div>";  //close bootstrap div 
                }else if($col == 4){
                    $answerAlphabet = "C";
                    echo "<div class='custom-control custom-radio border border-dark border-top-0 border-bottom-0 pl-1 pt-1'>"; //bootstrap custom radio button
                    echo '<label class="container_radio">C) '. trim($allQuestionsArray[$row][$col]);;
                    echo "<input type='radio' class='custom-control-input' id='" . $row . $answerAlphabet . "' name='ansForm" . $row . "' value='" . $answerAlphabet . "'>";
                    echo '<span class="checkmark_radio"></span>';
                    echo '</label>';
                    //echo "<label class='custom-control-label' for='" . $row . $answerAlphabet . "'>";
                    //echo "C) " . trim($allQuestionsArray[$row][$col]);
                    //echo "</label><br>";
                    echo "</div>";  //close bootstrap div 
                }else if($col == 5){
                    $answerAlphabet = "D";
                    echo "<div class='custom-control custom-radio border border-dark border-top-0 border-bottom-0 pl-1 pt-1'>"; //bootstrap custom radio button
                    echo '<label class="container_radio">D)'. trim($allQuestionsArray[$row][$col]);;
                    echo "<input type='radio' class='custom-control-input' id='" . $row . $answerAlphabet . "' name='ansForm" . $row . "' value='" . $answerAlphabet . "'>";
                    echo '<span class="checkmark_radio"></span>';
                    echo '</label>';
                    //echo "<label class='custom-control-label' for='" . $row . $answerAlphabet . "'>";
                    //echo "D) " . trim($allQuestionsArray[$row][$col]);
                    //echo "</label><br>";
                    echo "</div>";  //close bootstrap div
                }else if($col == 6){
                    $answerAlphabet = "E";
                    echo "<div class='custom-control custom-radio border border-dark border-top-0 pl-1 pt-1'>"; //bootstrap custom radio button
                    echo '<label class="container_radio">E) '. trim($allQuestionsArray[$row][$col]);;
                    echo "<input type='radio' class='custom-control-input' id='" . $row . $answerAlphabet . "' name='ansForm" . $row . "' value='" . $answerAlphabet . "'>";
                    echo '<span class="checkmark_radio"></span>';
                    echo '</label>';
                    //echo "<label class='custom-control-label' for='" . $row . $answerAlphabet . "'>";
                    //echo "E) " . trim($allQuestionsArray[$row][$col]);
                    //echo "</label><br>";
                    echo "</div>";  //close bootstrap div 
                }else if($col == 7){                    //column 6 is the correct answer, 7-8-9-10 will be explanations
                    $qAnswer = trim($allQuestionsArray[$row][$col]);
                }else if($col == 8){
                    $ansExp = $allQuestionsArray[$row][$col];
                    //$ansExp = str_replace(' ', '&nbsp;', $ansExp);
                    $ansExp = nl2br($ansExp);
                }
            }                                                                   //For loop database columns Close
            
            echo "<br>";
            //Check Answer Button
            echo "<input type='button'
                         class='btn btn-primary mt-1'
                         id='radbtn" . $row . "' 
                         value='Check Answer' 
                         onclick='getAnswer(" . $row . ",\"" . $qAnswer . "\", \"" . $questionid . "\")'>";
                                
            //Show Explanation Button
            /*
            echo "<input type='button'
                         class='btn btn-primary mt-1 ml-1'
                         id='expbtn" . $row . "' 
                         value='Explanation' 
                         data-toggle='collapse' 
                         data-target='#showExp". $row ."'>";*/
            
            //Previous Question Button(dont print if first question)
            if($row!=0){
            echo "<input type ='button'
                         class='btn btn-primary mt-1 ml-1'
                         id='prevbtn" . $row . "' 
                         value='<<' 
                         onclick='goprevnext(" . $row . ",\"Previous\")'>";
            }
            
            //Next Question Button (dont print if last question)
            if($row!=$arrayLength-1){
            echo "<input type ='button'
                         class='btn btn-primary mt-1 ml-1'
                         id='nextbtn" . $row . "' 
                         value='>>' 
                         onclick='goprevnext(" . $row . ",\"Next\")'>";             
            }
            
            echo "</fieldset>"; 
            echo "</form>";
            echo "<hr>";
            echo "<p style='padding-left:10px; margin-right: 20px; margin-top:20px;margin-bottom:20px;border-left-style: solid; border-color:#3BBA9C; border-width:2px;' id='showResult" . $row . "'></p>";    //This displays correct/incorrect
            
            //This displays explanation, is called after check answer button is pressed
            echo "<div style='display:none' id='showExp" . $row . "'>
                    <ul class='nav nav-tabs'>
                          <li class='nav-item'>
                            <a class='nav-link active' href='#'>Explanation</a>
                          </li>
                    </ul>
                " . $ansExp . "<br><hr></div>";
            
            echo "</div>";                                                      //Close eachQuestion Division
        }                                                                       //For loop gothru database row Close
        echo "</div>";                                                          //Right Division overflow Close
        echo "</div>";                                                          //Question Column Close
        echo "</div>";                                                          //Content Row Close
        echo "</div>";                                                          //Main Content Close
        //*** End Main Display Division
        
    
        //*** SCRIPT ***
?>       

        <script>
        
            var totalquestionsleft= <?php echo $arrayLength; ?>;
            
            var anatomy_current_correct=0;
            var anatomy_current_total=0;
            
            var physiology_current_correct=0;
            var physiology_current_total=0;
            var physiology_current_circulatory_correct=0;
            var physiology_current_circulatory_total=0;
            var physiology_current_respiratory_correct=0;
            var physiology_current_respiratory_total=0;
            
            var pathology_current_correct=0;
            var pathology_current_total=0;
            var pathology_current_circulatory_correct=0;
            var pathology_current_circulatory_total=0;
            var pathology_current_respiratory_correct=0;
            var pathology_current_respiratory_total=0;
            
            var anatomy_correct = <?php echo $anatomy_correct; ?>;
            var anatomy_total = <?php echo $anatomy_total; ?>;
            var physiology_correct = <?php echo $physiology_correct; ?>;
            var physiology_total = <?php echo $physiology_total; ?>;
            var pathology_correct = <?php echo $pathology_correct; ?>;
            var pathology_total = <?php echo $pathology_total; ?>;
            
            var circulatory_anatomy_correct = <?php echo $circulatory_anatomy_correct; ?>;
            var circulatory_anatomy_total = <?php echo $circulatory_anatomy_total; ?>;
            var circulatory_physiology_correct = <?php echo $circulatory_physiology_correct; ?>;
            var circulatory_physiology_total = <?php echo $circulatory_physiology_total; ?>;
            var circulatory_pathology_correct = <?php echo $circulatory_pathology_total; ?>;
            var circulatory_pathology_total = <?php echo $circulatory_pathology_total; ?>;
            
            var respiratory_physiology_correct = <?php echo $respiratory_physiology_correct; ?>;
            var respiratory_physiology_total = <?php echo $respiratory_physiology_total; ?>;
            var respiratory_pathology_correct = <?php echo $respiratory_pathology_total; ?>;
            var respiratory_pathology_total = <?php echo $respiratory_pathology_total; ?>;
            
            
            
            var allquestionsattempted = "<?php echo $sanitizedallqnumbers; ?>";
            
            var pressedbutton = "0";
            var pressedbuttoncolor = "white";
            
            function hideall(){ //Creating function to hide all divisions
                <?php        
                for($row = 0; $row < $arrayLength; $row++){
                    echo "document.getElementById('show" . $row . "').style.display = 'none';";
                }
                ?>
            }
        

            function showqdiv(qdivid){
                qdiv = "show" + qdivid;
                buttonpressed = "lbtn" + qdivid;
                oldbuttonpressed = "lbtn" + pressedbutton;
                
                document.getElementById(buttonpressed).style.color = "white";
                document.getElementById(buttonpressed).style.backgroundColor = "black";
                
                if(pressedbutton % 2 === 0){
	                document.getElementById(oldbuttonpressed).style.color = "white";
	                document.getElementById(oldbuttonpressed).style.backgroundColor = "#17a2b8";
                }else{
                    document.getElementById(oldbuttonpressed).style.color = "black";
                    document.getElementById(oldbuttonpressed).style.backgroundColor = "#f7f7f7";
                }
                
                pressedbutton = qdivid;
                hideall(); 
	            document.getElementById(qdiv).style.display = "block";  //Show division
	            document.getElementById(qdiv).scrollIntoView();         //Scroll to the top of new division after going to next question.
	            
            }
            function startquiz() {
                document.getElementById('show0').style.display = 'block';
                document.getElementById('lbtn0').style.color = "white";
                document.getElementById('lbtn0').style.backgroundColor = "black";
            }

            startquiz();

            function getAnswer(rowNumber, actualAnswer,questionid) {
                var formNum = 'qForm' + rowNumber;
                var radiobtnNum = 'ansForm' + rowNumber;
                var radiobtnID = 'radbtn' + rowNumber;
                var rltdisplay = 'showResult' + rowNumber;  
                var listbtn = 'lbtn' + rowNumber;           
                var listbtnnew = rowNumber+1;   //Button display is rowNumber + 1 
                var cid = questionid.charAt(1); //Subject ID from QuestionID (1234) 1=System 2=Subject 34=Question ID
                var sid = questionid.charAt(0); //System ID
                var answeredcorrect=false;
                
                
                actualAnswer = actualAnswer.trim();
                 
                var form = document.getElementById(formNum);
                var radiobtn = form.elements[radiobtnNum];
                var oneselected = 0;
                
                for(let x=0; x <5; x++){
                    if(radiobtn[x].checked==true){
                    oneselected=1;
                    }
                }
                if(oneselected==1){               
                    if(actualAnswer== 'A' && radiobtn[0].checked == true) {
                        document.getElementById(rltdisplay).innerHTML = '<p class=\"text-success\"><b>(A) Correct Answer!</b></p>';
                        answeredcorrect=true;
                    }else if(actualAnswer == 'B' && radiobtn[1].checked == true) {
                        document.getElementById(rltdisplay).innerHTML = '<p class=\"text-success\"><b>(B) Correct Answer!</b></p>';
                        answeredcorrect=true;
                    }else if(actualAnswer == 'C' && radiobtn[2].checked == true) {
                        document.getElementById(rltdisplay).innerHTML = '<p class=\"text-success\"><b>(C) Correct Answer!</b></p>';
                        answeredcorrect=true;
                    }else if(actualAnswer == 'D' && radiobtn[3].checked == true) {
                        document.getElementById(rltdisplay).innerHTML = '<p class=\"text-success\"><b>(D) Correct Answer!</b></p>';
                        answeredcorrect=true;
                    }else if(actualAnswer == 'E' && radiobtn[4].checked == true) {
                        document.getElementById(rltdisplay).innerHTML = '<p class=\"text-success\"><b>(E) Correct Answer!</b></p>';
                        answeredcorrect=true;
                    }else{
                        document.getElementById(rltdisplay).innerHTML = '<p class=\"text-danger\"><b>Incorrect Answer!</b></p><p>The correct answer is <b>' + actualAnswer + '</b></p>';
                        document.getElementById(rltdisplay).style.borderColor = 'red';
                        
                    }
                    document.getElementById(radiobtnID).disabled = true;
                    document.getElementById(listbtn).value = '  ' + listbtnnew;                 //Remove * from the list button once question has been solved
                    
                    for(let x=0; x <5; x++){
                        radiobtn[x].disabled=true;
                    }
                    
                    //If answer is correct, add to user stat
                    if(answeredcorrect==true){
                        if(cid=="0"){                                                           //Anatomy 
                            anatomy_correct = anatomy_correct + 1;
                            anatomy_current_correct = anatomy_current_correct + 1;
                            if(sid=="1"){                                                       //Circulatory Anatomy
                                circulatory_anatomy_correct = circulatory_anatomy_correct + 1;    
                            }else if(sid=="2"){
                        
                            }
                        }else if(cid=="1"){                                                     //Physiology
                            physiology_correct = physiology_correct + 1;
                            physiology_current_correct = physiology_current_correct + 1;
                            
                            if(sid=="1"){                                                       //Circulatory Physiology
                                circulatory_physiology_correct = circulatory_physiology_correct + 1;   
                                physiology_current_circulatory_correct = physiology_current_circulatory_correct + 1;
                                
                            }else if(sid=="2"){                                                 //Respiratory Physiology
                                respiratory_physiology_correct = respiratory_physiology_correct + 1;
                                physiology_current_respiratory_correct = physiology_current_respiratory_correct + 1;
                            }
                            
                        }else if(cid=="2"){
                            pathology_correct = pathology_correct + 1;
                            pathology_current_correct = pathology_current_correct + 1;
                            
                            
                            if(sid=="1"){                                                       //Circulatory Pathology
                                circulatory_pathology_correct = circulatory_pathology_correct + 1;    
                                pathology_current_circulatory_correct = pathology_current_circulatory_correct + 1;
                            }else if(sid=="2"){                                                 //Respiratory Pathology
                                respiratory_pathology_correct = respiratory_pathology_correct + 1;    
                                pathology_current_respiratory_correct = pathology_current_respiratory_correct + 1;
                            }
                        }
                        
                        
                    }
                    
                    //Add to total user stat
                    if(cid=="0"){
                        anatomy_total = anatomy_total + 1;
                        anatomy_current_total = anatomy_current_total +1;
                       
                        if(sid=="1"){   //Circulatory Anatomy
                            circulatory_anatomy_total = circulatory_anatomy_total + 1;    
                        }
                    
                    }else if(cid=="1"){
                        physiology_total = physiology_total + 1;
                        physiology_current_total = physiology_current_total +1;
                        
                        if(sid=="1"){
                            circulatory_physiology_total = circulatory_physiology_total + 1;
                            physiology_current_circulatory_total = physiology_current_circulatory_total + 1;
                        }else if(sid=="2"){
                            respiratory_physiology_total = respiratory_physiology_total + 1; 
                            physiology_current_respiratory_total = physiology_current_respiratory_total + 1;
                        }
                    }else if(cid=="2"){
                        pathology_total = pathology_total + 1;
                        pathology_current_total = pathology_current_total +1;
                        
                        if(sid=="1"){
                            circulatory_pathology_total = circulatory_pathology_total + 1;    
                            pathology_current_circulatory_total = pathology_current_circulatory_total + 1;
                        }else if(sid=="2"){
                            respiratory_pathology_total = respiratory_pathology_total + 1;    
                            pathology_current_respiratory_total = pathology_current_respiratory_total + 1;
                        }
                    }
                    
                    
                    totalquestionsleft = totalquestionsleft - 1;
                    if(totalquestionsleft==0){
                        document.getElementById("exitbtn").innerHTML ="Complete";
                        document.getElementById("exitbtn").className = "btn btn-success float-right ml-auto mr-2 mt-1 mb-1";
                        document.getElementById("modalbody").innerHTML = "Click Complete to save your progress";
                        document.getElementById("quitbtn").innerHTML ="Complete";
                        document.getElementById("quitbtn").className = "btn btn-success";
                        document.getElementById("returnbtn").className = "btn btn-warning";
                    }
                    
                    getExp(rowNumber);
                }else{
                    document.getElementById(rltdisplay).innerHTML = '<p class=\"text-info\"><b>Choose an Answer!</b></p>';
                }
                
                
                
            }
            
            function getExp(rowNumber) {
            var expdisplay = 'showExp' + rowNumber;
                document.getElementById(expdisplay).style.display = 'block';
            }
            

            function goprevnext(rowNumber,gopn){
                if(gopn=='Previous'){
                    var x=rowNumber-1;
                    hideall(); 
	                document.getElementById('show' + x).style.display = 'block';
	                showqdiv(x);
               }else if(gopn=='Next'){
                    var x=rowNumber+1;
                    hideall(); 
	                document.getElementById('show' + x).style.display = 'block';
	                showqdiv(x);
               }
            }
            
        </script>
    
        
        <script type="text/javascript">
        function submitform()
        {
          document.myform.submit();
        }
        </script>


        <!-- The Modal -->
        <div class="modal fade" id="exitModal">
          <div class="modal-dialog">
            <div class="modal-content">
        
              <!-- Modal Header -->
              <div class="modal-header bg-dark text-white">
                <h4 class="modal-title">Exit</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
        
              <!-- Modal body -->
              <div class="modal-body" id="modalbody">
                Are you sure you want to exit?
              </div>
        
              <!-- Modal footer -->
              <div class="modal-footer">
                <button id="returnbtn" type="button" class="btn btn-success" data-dismiss="modal">Return</button>
                <button id="quitbtn" onclick="exitTest()" type="button" class="btn btn-danger">Quit</button>
              </div>
        
            </div>
          </div>
        </div>

        <script>
        
        // First we get the viewport height and we multiple it by 1% to get a value for a vh unit
        let vh = window.innerHeight * 0.01;
        // Then we set the value in the --vh custom property to the root of the document
        document.documentElement.style.setProperty('--vh', `${vh}px`);
        
        // We listen to the resize event
        window.addEventListener('resize', () => {
          // We execute the same script as before
          let vh = window.innerHeight * 0.01;
          document.documentElement.style.setProperty('--vh', `${vh}px`);
        });
    
            function exitTest() {
            
                if(totalquestionsleft==0){
                    //alert("Called");
                    $.ajax({
                        type: "POST",
                        url: 'postteststats.php',
                        data: {ana_total: anatomy_total, 
                               physio_total: physiology_total, 
                               patho_total: pathology_total,
                               ana_correct: anatomy_correct,
                               physio_correct: physiology_correct,
                               patho_correct: pathology_correct,
                               circulatory_ana_correct: circulatory_anatomy_correct,
                               circulatory_ana_total: circulatory_anatomy_total,
                               circulatory_physio_correct: circulatory_physiology_correct,
                               circulatory_physio_total: circulatory_physiology_total,
                               circulatory_patho_correct: circulatory_pathology_correct,
                               circulatory_patho_total: circulatory_pathology_total,
                               respiratory_physio_correct: respiratory_physiology_correct,
                               respiratory_physio_total: respiratory_physiology_total,
                               respiratory_patho_correct: respiratory_pathology_correct,
                               respiratory_patho_total: respiratory_pathology_total,
                               attempted_q: allquestionsattempted
                        },
                        dataType: "text",
                        cache: false,
                        success: function(data){
                            //alert(data);
                            //location.replace("index.php");
                        }
                        //error: function (error) {
                        //    alert('error; ' + eval(error));
                        //}
                    });
                    //alert(anatomy_current_total);
                    var form = document.createElement("form");
                    document.body.appendChild(form);
                    form.method = "POST";
                    form.action = "testresults.php";
                    
                    var element1 = document.createElement("INPUT");         
                    element1.name="anatomy_correct";
                    element1.value = anatomy_current_correct;
                    element1.type = 'hidden';
                    form.appendChild(element1);
                    
                    var element2 = document.createElement("INPUT");         
                    element2.name="anatomy_total";
                    element2.value = anatomy_current_total;
                    element2.type = 'hidden';
                    form.appendChild(element2);
                    
                    var element3 = document.createElement("INPUT");         
                    element3.name="physiology_correct";
                    element3.value = physiology_current_correct;
                    element3.type = 'hidden';
                    form.appendChild(element3);
                    
                    var element4 = document.createElement("INPUT");         
                    element4.name="physiology_total";
                    element4.value = physiology_current_total;
                    element4.type = 'hidden';
                    form.appendChild(element4);
                    
                    
                    var element5 = document.createElement("INPUT");         
                    element5.name="physiology_current_circulatory_correct";
                    element5.value = physiology_current_circulatory_correct;
                    element5.type = 'hidden';
                    form.appendChild(element5);
                    
                    var element6 = document.createElement("INPUT");         
                    element6.name="physiology_current_circulatory_total";
                    element6.value = physiology_current_circulatory_total;
                    element6.type = 'hidden';
                    form.appendChild(element6);
                    
                    var element7 = document.createElement("INPUT");         
                    element7.name="physiology_current_respiratory_correct";
                    element7.value = physiology_current_respiratory_correct;
                    element7.type = 'hidden';
                    form.appendChild(element7);
                    
                    var element8 = document.createElement("INPUT");         
                    element8.name="physiology_current_respiratory_total";
                    element8.value = physiology_current_respiratory_total;
                    element8.type = 'hidden';
                    form.appendChild(element8);
                    
                    var element9 = document.createElement("INPUT");         
                    element9.name="pathology_correct";
                    element9.value = pathology_current_correct;
                    element9.type = 'hidden';
                    form.appendChild(element9);
                    
                    var element10 = document.createElement("INPUT");         
                    element10.name="pathology_total";
                    element10.value = pathology_current_total;
                    element10.type = 'hidden';
                    form.appendChild(element10);
                    
                    
                    var element11 = document.createElement("INPUT");         
                    element11.name="pathology_current_circulatory_correct";
                    element11.value = pathology_current_circulatory_correct;
                    element11.type = 'hidden';
                    form.appendChild(element11);
                    
                    var element12 = document.createElement("INPUT");         
                    element12.name="pathology_current_circulatory_total";
                    element12.value = pathology_current_circulatory_total;
                    element12.type = 'hidden';
                    form.appendChild(element12);
                    
                    var element13= document.createElement("INPUT");         
                    element13.name="pathology_current_respiratory_correct";
                    element13.value = pathology_current_respiratory_correct;
                    element13.type = 'hidden';
                    form.appendChild(element13);
                    
                    var element14 = document.createElement("INPUT");         
                    element14.name="pathology_current_respiratory_total";
                    element14.value = pathology_current_respiratory_total;
                    element14.type = 'hidden';
                    form.appendChild(element14);
                    
                    form.submit();
                    
                    
                }else{
                    location.replace("dashboard.php");
                }
                

                
            }
            
            
            
        </script>
    </body>
</html>