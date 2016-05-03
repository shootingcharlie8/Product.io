<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function mysql_escape_mimic($inp) { 
    if(is_array($inp)) 
        return array_map(__METHOD__, $inp); 

    if(!empty($inp) && is_string($inp)) { 
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
    } 

    return $inp; 
} 

   if ($_POST) {
    $servername = "localhost";
    $username = "productio";
    $password = "suSx6HQKQPaMOMGA";
    $dbname = "productio";
    $belongsto = $_POST['BelongsTo'];
    $title = mysql_escape_mimic($_POST['NoteTitle']);
    $entry = mysql_escape_mimic($_POST['NoteEntry']);
    $ip = $_SERVER["REMOTE_ADDR"];

    // Create connection
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "INSERT INTO Entries (BelongsTo, Title, Task)
    VALUES ('" . $belongsto . "', '" . $title . "', '" . $entry . "')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<h1>Success</h1>";
        echo "<p>We are now redirecting you to the member area.</p>";
        echo "<meta http-equiv='refresh' content='0;index.php' />";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();     
    }
?>