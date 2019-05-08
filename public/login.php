<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /home");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$key = "";
$key_err = "";
$out = array('error' => false);
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["pubkey"]))){
        $key_err = "No key";
        $out['error'] = true;
        $out['message'] = $key_err;
    } else{
        $key = trim($_POST["pubkey"]);
    }

    
    // Validate credentials
    if(empty($key_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, pubkey FROM users WHERE pubkey = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_key);
            
            // Set parameters
            $param_key = $key;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $key);
                    if(mysqli_stmt_fetch($stmt)){
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;                            
                            
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $key_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>