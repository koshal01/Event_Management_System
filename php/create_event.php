<?php 
include 'index.php';
include 'eventsql.php'; ?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Event</title>
        <link rel="stylesheet" href="..\css\event.css">
    </head>
    
    <body>
    <h2 class="heading">Create Event Form</h2>
    <form method="post" action="create_event.php">
        <?php include ('errors.php'); ?>
        <div class="input-group">
            <label>Name</label>
            <input type="text" name="eventname">
        </div>
        <div class="input-group">
            <label>Place</label>
            <input type="text" name="place">
        </div>
        <div class="input-group">
            <label>Date</label>
            <input type="date" name="date">
        </div>
        <div class="input-group">
            <label>Time</label>
            <input type="time" name="time">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="event_reg">Register</button>
        </div>
    </form>

</body>
</html>