<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

    $query = "INSERT INTO users(username, email, password) VALUES(?,?,?)";
    //create a prepared statement
    $stmt=mysqli_stmt_init($db);
    // //prepare the prepared statement
    if(!mysqli_stmt_prepare($stmt,$query)){
        echo "SQL Statement failed";
    }else{
        mysqli_stmt_bind_param($stmt,"sss",$username,$email,$password);
        mysqli_stmt_execute($stmt);
        $_SESSION['username'] = $username;
        $_SESSION['email']=$_POST['email'];
        $_SESSION['success'] = "You are now logged in";
        header('location: create_event.php');
    }
  }  
}


// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username=? AND password=?";
        $stmt=mysqli_stmt_init($db);

        if(!mysqli_stmt_prepare($stmt,$query)){
          echo "SQL statement failed";
        }else{
          mysqli_stmt_bind_param($stmt,"ss",$username,$password);
          mysqli_stmt_execute($stmt);
          $results = mysqli_stmt_get_result($stmt);
          $row=mysqli_fetch_assoc($results);
          if (mysqli_num_rows($results) == 1) {
              $_SESSION['username'] = $username;
              $_SESSION['email']=$row['email'];
              $_SESSION['success'] = "You are now logged in";
              header('location: create_event.php');
            }else {
                array_push($errors, "Wrong username/password combination");
            }
        }
    }
  }
  
  ?>