<style>
<?php include '..\css\show_event.css'; ?>
</style>
<?php
    include 'index.php';
    echo "<title>Events</title>";
    echo "<p class= 'header'>Events</p>";
    $username= $_SESSION['username']; 
    
    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registration');
    
    $query = "SELECT * FROM events WHERE username=?";
    $stmt=mysqli_stmt_init($db);

    echo "<table>
    <tr>
    <th>Event Name</th>
    <th>Place</th>
    <th>Date</th>
    <th>Time</th>
    <th>Invite</th>
    <th>Invitees</th>
    </tr>";

    if(!mysqli_stmt_prepare($stmt,$query)){
        echo "SQL Statement Failed";
    }else{
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);

        while($row=mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>" . $row['event'] . "</td>";
            echo "<td>" . $row['place'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td><a href='invite_temp.php?event_id={$row['event_id']}'>Invite</a>";
            echo "<td><a href='invited_list.php?event_id={$row['event_id']}&event={$row['event']}'>List</a>";
            echo "</tr>";
        }
        echo "</table>";
    }
?>