<style>
<?php include '..\css\show_event.css'; ?>
</style>
<?php
    include 'index.php';
    echo "<title>Invitees</title>";
    
    echo "<p class= 'head header'>Event: ".$_GET['event']."</p>";
    $username = $_SESSION['username'];
    $event_id=$_GET['event_id'];

    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registration');

    echo "<table class='invitees'>
        <tr>
        <th>Invitees</th>
        <th>Status</th>
        </tr>";


    $query="SELECT invite.invites, events.event, invite.status FROM invite 
     INNER JOIN events ON invite.event_id=events.event_id 
     WHERE invite.username='$username' AND invite.event_id='$event_id'";
    
    $result = mysqli_query($db, $query);
    while($row=mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>" . $row['invites'] . "</td>";
        echo "<td>" . $row['status'] ."</td>";
        echo "</tr>";
    }
    echo "</table>";
?>