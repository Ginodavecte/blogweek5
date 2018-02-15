<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require '../vendor/autoload.php';
?>
<?php include("../includes/database.php");?>
<?php include("../includes/functions.php");?>

<head>
    <meta charset="UTF-8">
    <title>Wachtwoord Vergeten</title>
    <link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../includes/functions.js"></script>
</head>
<?php
$error = "";
if(isset($_POST['newpassw_submit'])){
    $email = htmlentities($_POST['email']);
    $username = htmlentities($_POST['username']);
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $sql);

    if($result->num_rows >0 ){
        $subjects = mysqli_fetch_assoc($result);
        $username_hashed = md5($username);
        $password = $subjects['password'];
        $link="<a href='http://localhost/blogw5/blogweek5/login/resetpassw.php?key=".$username_hashed."&reset=".$password."'>Klik om wachtwoord te resetten</a>";


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
//  $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.mijndomein.nl';                   // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'blog@ginojoanroy.nl';              // SMTP username
    $mail->Password = '*****';                                 // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('blog@ginojoanroy.nl', 'Gino12');
    $mail->addAddress($email, $username);                 // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Reset uw wachtwoord';
    $mail->Body    = '  <html>
                    <head>
                      <title>Nieuw Wachtwoord</title>
                    </head>
                    <body>
                      <p>Hallo '. $username . ' u heeft een niuew wachtwoord aangevraagd</p>
                      <table>
                        <tr>
                          <td>Uw username blijft hetzelfde.</td>
                        </tr>
                        <tr>
                          <td></td>
                        </tr>
                        <tr>
                          <td>'.$link.'</td>
                        </tr>
                        <tr>
                          <td>Bedankt voor het blijven gebruiken van onze service, veel plezier.</td>
                        </tr>
                        <tr>
                           <td>Met vriendelijk groet,</td>
                        </tr>
                        <tr>
                          <td>Gino Joanroy</td>
                        </tr>
                      </table>
                    </body>
                    </html>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
    }else{
        $error = "Username bestaat niet";
    }
}
?>

<body>
<div class="container">
    <div class="row">
        <div class="panel panel-default col-md-6">
            <form action="" method="post">
                <div class="panel-heading" style="background-color: #3d6da7 !important; color: white !important;">Wachtwoord vergeten </div>
                <div class="panel-body">
                    <p>Email : <input type="email" name="email"  ></p>
                    <p>Username : <input type="text" name="username" required> <?php echo $error; ?> </p>
                    <a style="float:left;" href="register.php">Maak nieuw account aan</a><br>
                    <input style="float: right" type="submit" class="btn btn-warning btn-sm" name="newpassw_submit" value="Verzend!">
                </div>
            </form>
        </div> <!-- eind div col-md-6 -->
    </div> <!-- eind div row -->
</div> <!-- eind div container -->
</body>
