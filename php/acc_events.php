<style>
<?php include '..\css\show_event.css'; ?>
</style>
<?php
    include 'index.php';
    echo "<title>Accepted Events</title>";

    echo "<p class= 'acc_head header'> Accepted Event</p>";
    $username= $_SESSION['username']; 
    $email= $_SESSION['email'];
    $status='accept';
    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registration');
    
    $query = "SELECT * FROM invite INNER JOIN events on invite.event_id=events.event_id WHERE invite.invites=? && invite.status=?";
    $stmt=mysqli_stmt_init($db);

    echo "<table class='acc_event'>
    <tr>
    <th>From</th>
    <th>Event</th>
    <th>Place</th>
    <th>Date</th>
    <th>Time</th>
    <th>Message</th>
    </tr>";

    if(!mysqli_stmt_prepare($stmt,$query)){
        echo "SQL Statement Failed";
    }else{
        mysqli_stmt_bind_param($stmt,"ss",$email,$status);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        while($row=mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>" . $row['username']. "</td>";
            echo "<td>" . $row['event'] . "</td>";
            echo "<td>" . $row['place'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td><a href='acc_events_temp.php?event_id={$row['event_id']}'>Show</a>";
            echo "</tr>";
        }
        echo "</table>";
    }
?>