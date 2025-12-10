<?php

$page_title = "Check registration";

include 'mysqli_connect.php';

include 'includes/header.html';

include 'includes/navbar.html';

if (isset ($_SESSION['username'])){
	header('location: index.php');
}
else{
	
    $username = $_POST['username'];
    $password = $_POST['pass'];

    // group addition: just add a prepared statement
    $sql1 = $connection->prepare("SELECT users_username, users_password FROM users WHERE users_username = ? AND users_password = ?");
    $sql1->bind_param("ss", $username, $password);
    $sql1->execute();
    $result1 = $sql1->get_result();
    
    if (mysqli_num_rows ($result1) == 0){

        $sql2 = "INSERT INTO users (users_username, users_password) VALUES (?, ?)";
        $sql2 = $connection->prepare($sql2);
        $sql2->bind_param("ss", $username, $password);
        $sql2->execute();

        if ($sql2->error){
            include 'includes/error.php';
        } else {
            include 'includes/registered.php';
        }
    }
    // end of group addition
    else{
        include 'includes/notregistered.php';
    }
}

mysqli_close ($connection);

include 'includes/footer.html';

?>