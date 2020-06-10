<style>
<?php include '..\css\show_event.css'; ?>
</style>
<?php
    include 'index.php';
    echo "<title>Messages</title>";
    echo "<p class= 'inv header'>Invitation</p>";
    
    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registration');

    $username=$_SESSION['username'];
    $email=$_SESSION['email'];
    $status='nil';
    $query="SELECT invite.event_id, invite.username, invite.invites, events.event FROM invite 
     INNER JOIN events ON invite.event_id=events.event_id 
     WHERE invite.invites=? AND invite.status=?";

    $stmt=mysqli_stmt_init($db);

    echo "<table class='invitation'>
    <tr>
    <th>Event</th>
    <th>Invited By</th>
    <th>Message</th>
    </tr>";

    if(!mysqli_stmt_prepare($stmt,$query)){
      echo "SQL statement failed";
    }else{
      mysqli_stmt_bind_param($stmt,"ss",$email,$status);
      mysqli_stmt_execute($stmt);
      $results = mysqli_stmt_get_result($stmt);
      while($row=mysqli_fetch_assoc($results)){
        echo "<tr>";
        echo "<td>" . $row['event'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td><a href='invite_temp_rec.php?event_id={$row['event_id']}'>Show</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    }
?>