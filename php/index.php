<?php 
  session_start();
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<link rel="stylesheet" type="text/css" href="..\css\index.css">
</head>
<body>
<?php  if (isset($_SESSION['username'])) : ?>
        <div class="navbar">
            <a href="..\home.html">Home</a>
            <a href="index.php?logout='1'" class="right">Log Out</a>
            <span class="rt"><?php echo "<p>".$_SESSION["username"]."</p>"?></span>
            <div class="vl"></div>
        </div>

        <div class="sidenav">
            <a class="btm" href="create_event.php">Create Event</a>
            <a href="show_event.php">Events</a>
            <a href="acc_events.php">Acccepted Events</a>
            <a href="message.php">Messages</a>
        </div>
<?php endif ?>
</div>
</body>
</html>