<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$userlogin = clean_input($_SESSION["username"]);
$anatomy_total = clean_input($_REQUEST['ana_total']);
$anatomy_correct = clean_input($_REQUEST['ana_correct']);
$physiology_total = clean_input($_REQUEST['physio_total']);
$physiology_correct = clean_input($_REQUEST['physio_correct']);
$pathology_total = clean_input($_REQUEST['patho_total']);
$pathology_correct = clean_input($_REQUEST['patho_correct']);

$circulatory_anatomy_correct = clean_input($_REQUEST['circulatory_ana_correct']);
$circulatory_anatomy_total = clean_input($_REQUEST['circulatory_ana_total']);
$circulatory_physiology_correct = clean_input($_REQUEST['circulatory_physio_correct']);
$circulatory_physiology_total = clean_input($_REQUEST['circulatory_physio_total']);
$circulatory_pathology_correct = clean_input($_REQUEST['circulatory_patho_correct']);
$circulatory_pathology_total = clean_input($_REQUEST['circulatory_patho_total']);

$respiratory_physiology_correct = clean_input($_REQUEST['respiratory_physio_correct']);
$respiratory_physiology_total = clean_input($_REQUEST['respiratory_physio_total']);
$respiratory_pathology_correct = clean_input($_REQUEST['respiratory_patho_correct']);
$respiratory_pathology_total = clean_input($_REQUEST['respiratory_patho_total']);

$attempted_questions = clean_input($_REQUEST["attempted_q"]);

require_once("../config.php");

$sql = "SELECT attempted_questions                                                  
            FROM users_stats 
            WHERE username=?"; // SQL with parameters
    $stmt = $conn->prepare($sql);                                               //  Subject           System
    $stmt->bind_param("s", $userlogin);                           //[0] = Pathology [1]=Respiratory
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result

    if ($result->num_rows > 0) {
        // output data of each row and save it in array for later use
        while($row = $result->fetch_assoc()) {
            $attempted_questions_from_database = $row["attempted_questions"];                    //Get the question IDs based on 
        }
    } else {
        echo "Error";
    }

$attempted_questions = trim($attempted_questions_from_database) . " " . trim($attempted_questions) ;

/*$sql = "UPDATE users_stats SET anatomy_total=$anatomy_total, 
                               physiology_total=$physiology_total, 
                               pathology_total=$pathology_total,
                               anatomy_correct = $anatomy_correct,
                               physiology_correct=$physiology_correct,
                               pathology_correct=$pathology_correct,
                               attempted_questions='$attempted_questions'
                               WHERE username='$userlogin'";*/

$sql = "UPDATE users_stats SET anatomy_total=?, 
                               physiology_total=?, 
                               pathology_total=?,
                               anatomy_correct = ?,
                               physiology_correct=?,
                               pathology_correct=?,
                               circulatory_anatomy_correct=?,
                               circulatory_anatomy_total=?,
                               circulatory_physiology_correct=?,
                               circulatory_physiology_total=?,
                               circulatory_pathology_correct=?,
                               circulatory_pathology_total=?,
                               respiratory_physiology_correct=?,
                               respiratory_physiology_total=?,
                               respiratory_pathology_correct=?,
                               respiratory_pathology_total=?,
                               attempted_questions=?
                               WHERE username=?";
                               
$stmt = $conn->prepare($sql);  
$stmt->bind_param("ssssssssssssssssss", $anatomy_total,
                                    $physiology_total,
                                    $pathology_total,
                                    $anatomy_correct,
                                    $physiology_correct,
                                    $pathology_correct,
                                    
                                    $circulatory_anatomy_correct,
                                    $circulatory_anatomy_total,
                                    $circulatory_physiology_correct,
                                    $circulatory_physiology_total,
                                    $circulatory_pathology_correct,
                                    $circulatory_pathology_total,
                                    
                                    $respiratory_physiology_correct,
                                    $respiratory_physiology_total,
                                    $respiratory_pathology_correct,
                                    $respiratory_pathology_total,
                                    $attempted_questions, 
                                    $userlogin);
//$stmt->execute();
//$result = $stmt->get_result(); // get the mysqli result

    if ($stmt->execute()) {
        // output data of each row and save it in array for later use
       echo "Updated statistics";
    } else {
        echo "Error updating statistics: " . $conn->error;
    }
    
/*    
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo $username;
    echo "Error updating record: " . $conn->error;
    
}
*/
$conn->close();

function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>