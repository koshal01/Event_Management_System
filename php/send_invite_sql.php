<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

//for any errors in form or during sending mail
$errors = array();
$email = array();
$from=$_SESSION['username'];
$event_id=$_SESSION['event_id'];
$check_mail=$_SESSION['email'];

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

if(isset($_POST['invite'])){
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true); 

    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'john2000sharma@gmail.com';             // SMTP username
    $mail->Password   = '123Science789';                        // SMTP password
    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;           // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('john2000sharma@gmail.com', 'username');
    foreach(explode(',',$_POST['email']) as $rec_mail){
        if(!filter_var($rec_mail, FILTER_VALIDATE_EMAIL)){
            array_push($errors,"You entered wrong email address");
        }else{
            //Self Email Check
            if($rec_mail==$check_mail){
                array_push($errors,"Cant Send Self Mail");
            }          
            //Check whether user have send invite for the event to the same mail_id or not
            $sql = "SELECT * FROM invite  WHERE username='$from' AND event_id='$event_id' AND invites='$rec_mail';";
            $result = mysqli_query($db,$sql);
            if(mysqli_num_rows($result) == 1){
                array_push($errors,"Cant invite again for same event");
            }
            array_push($email,$rec_mail);
            $mail->addAddress($rec_mail);     // Add a recipient
        }       
    }

    if (count($errors) == 0) {
        //Event details to put up in card
        $event=$_SESSION['event'];
        $place=$_SESSION['place']; 
        $date=$_SESSION['date'];
        $time=$_SESSION['time'];
        $message=$_POST['message'];
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Invitation From: '.$from;
        $mail->Body    = "<HTML><body>
            <div style='background-color: lightgrey;
                width: 600px; height: 650px; text-align: center; border: 1px solid black; '>

                <h2 style=' font-size: 40px; font-weight: bold; '>Invitation Card</h2>

                <p style='font-size: 35px; color: blueviolet; word-spacing: 15px; '>YOU ARE<br>INVITED</p>
                <p style='font-size: 25px; color: coral; '>To : $event</p>
                <p style='font-size: 25px; color: coral; '>At : $place</p>
                <p style='font-size: 25px; color: coral; '>On : $date</p>
                <p style='font-size: 25px; color: coral; '>Time : $time</p>
                <p style='font-size: 25px; color: coral; '>From : $from</p>
            </div>
            <p style='font-size: 25px; color: coral; '>Message: $message</p>     
            </body></HTML>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()){
            array_push($errors,"Failed to send invitation");
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }else {
            $success="INVITATION WAS SENT";
            for($i=0;$i<count($email);$i++){
                $query="INSERT INTO invite VALUES('$from','$event_id','$email[$i]','nil');";
                mysqli_query($db, $query);
            }
        }
    }
}