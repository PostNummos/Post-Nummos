<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values

$email ="";
$email_err = "";
$key = $key_err ="";
$out = array('error' => false);
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email";
        $out['error'] = true;
    }elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
    	$email_err = "Please enter a valid email";
        $out['error'] = true;
    }
    else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already signed up";
                    $out['error'] = true;
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                $out['error'] = true;
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    if(empty($key)){
        $out['error'] = true;
        $key_err = "No key, fool";
        $out['message'] = $key_err;
    }
    
    $out['message'] = $email_err;
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($key_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (email, pubkey) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_key);
            
            // Set parameters
            $param_email = $email;
            $param_key = $key;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $out['message'] = "nice";
            } else{
                $out['message'] = "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);

    header("Content-type: application/json");
    echo json_encode($out);
    die();
 
}
?>