<?php
    session_start();
    $sender = $_SESSION['sender'];
    $event_id = $_SESSION['event_id'];
    $email=$_SESSION['email'];

    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registration');

    if(isset($_POST['accept'])){
        $query="UPDATE invite SET status='accept' WHERE username='$sender' && event_id='$event_id' && invites='$email';";
        $result=mysqli_query($db,$query);
    }
    if(isset($_POST['reject'])){
        $query="UPDATE invite SET status='reject' WHERE username='$sender' && event_id='$event_id' && invites='$email';";
        $result=mysqli_query($db,$query);
    }
    header('location:message.php');
?>