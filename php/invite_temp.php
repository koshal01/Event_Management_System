<?php 
    include 'index.php';
    $from=$_SESSION['username'];
    $event_id=$_GET['event_id'];

    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registration');

    //event details of the selected event
    $query = "SELECT * FROM events WHERE event_id=? AND username=?";
    $stmt=mysqli_stmt_init($db);

    if(!mysqli_stmt_prepare($stmt,$query)){
        echo "SQL statement failed";
    }else{
        mysqli_stmt_bind_param($stmt,"is",$event_id,$from);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row=mysqli_fetch_assoc($result)){
            $_SESSION['event_id'] = $row['event_id'];
            $_SESSION['event'] = $row['event'];
            $_SESSION['place'] = $row['place'];
            $_SESSION['date']= $row['date'];
            $_SESSION['time']= $row['time'];
        }else{
            header('location:show_event.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation Card</title>
    <link rel="stylesheet" href="..\css\invite.css">
</head>
<body>
    <div class="card">
        <h2 class="invite-head">Invitation Card</h2>
        <p class="big">YOU ARE<br>INVITED<p>
        <p class="inf">For :<?php echo $_SESSION['event']?></p>
        <p class="inf">At :<?php echo $_SESSION['place']?></p>
        <p class="inf">On :<?php echo $_SESSION['date']?></p>
        <p class="inf">Time :<?php echo $_SESSION['time']?></p>
        <p class="inf">From :<?php echo $from?></p>
    </div>
    <button type="submit" class="btn" onClick="document.location.href='send_invite.php'">Next</button>  
</body>
</html>