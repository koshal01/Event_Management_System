<?php
    // initializing variables
    $name = "";
    $place = "";
    $date = "";
    $time ="";
    $username= $_SESSION['username'];
    $errors = array(); 
    
    // connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'registration');
    
    // REGISTER EVENT
    if(isset($_POST['event_reg'])) {
      // receive all input values from the form
      $name = mysqli_real_escape_string($db, $_POST['eventname']);
      $place = mysqli_real_escape_string($db, $_POST['place']);
      $date = mysqli_real_escape_string($db, $_POST['date']);
      $time = mysqli_real_escape_string($db, $_POST['time']);
      $date2 = date("Y-m-d"); 
      $_SESSION["suc"]="Event not created";

      // by adding (array_push()) corresponding error unto $errors array
      if (empty($name)) { array_push($errors, "Event name is required"); }
      if (empty($place)) { array_push($errors, "Place is required"); }
      if (empty($date)) {
        array_push($errors, "Date is required");
      }else if($date < $date2) { 
        array_push($errors,"Date not acceptable");
      }
      if(empty($time)) { array_push($errors, "Time is required");}

      //first check the database to make sure 
      // a user has already created same event or event 
      $event_check_query = "SELECT * FROM events WHERE event=? AND place=? AND date=? AND time=?";
      $stmt = mysqli_stmt_init($db);
      if(!mysqli_stmt_prepare($stmt,$event_check_query)){
        echo "SQL Statement Failed";
      }else{
        mysqli_stmt_bind_param($stmt,"ssss",$name,$place,$date,$time);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $event=mysqli_fetch_assoc($result);
      }

      // $result = mysqli_query($db, $event_check_query);
      // $event = mysqli_fetch_assoc($result);
       
      if ($event) { // if event exists
        if ($event['username'] === $username) {
          array_push($errors, "Event already exists");
        }
      }

      if (count($errors) == 0) {
        $query = "INSERT INTO events (event, place, date, time, username) 
              VALUES(?,?,?,?,?)";
        if(!mysqli_stmt_prepare($stmt,$query)){
          echo "SQL Statement Failed";
        }else{
          mysqli_stmt_bind_param($stmt,"sssss",$name,$place,$date,$time,$username);
          mysqli_stmt_execute($stmt);
          // mysqli_query($db, $query);

          //to get event_id
          $sql="SELECT MAX(event_id) as event_id FROM events";
          $results = mysqli_query($db, $sql);
          $row=mysqli_fetch_assoc($results);
          $id=$row['event_id'];
          header("location: invite_temp.php?event_id={$id}");  
        } 
      } 
    }
?>