<?php
    include 'index.php'; 
    include 'send_invite_sql.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Invitation</title>
    <link rel="stylesheet" href="..\css\event.css">
</head>
<style>
    textarea{
        resize: vertical;
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 5px;

    }

    .success {
        color: green;
        text-align: center;
        font-size:23px;
    }

    .error {
        color: red;
        text-align: center;
        font-size:20px;
    }
</style>
<body>
    <h2 class="head">Invite Form</h2>
    <form class="inv_form" method="post" action="send_invite.php">
        <?php include ('errors.php'); ?>
        <div class="input-group">
            <label>To</label>
            <input type="text" name="email" placeholder="Gmail Id separated with comma" required>
        </div>
        <div class="input-group">
            <label>Message</label>
            <textarea rows="2" cols="41" name="message" placeholder="Write invite message here" required></textarea>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="invite">Invite</button>
        </div>

        <?php if(isset($success)): ?>
            <div class="success">
                <?php echo $success; ?>
            </div> 
        <?php endif ?>   
        </form>
</body>
</html>