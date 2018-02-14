<?php session_start(); ?>
<?php include("../includes/database.php");?>
<?php include("../includes/functions.php");?>

<?php
$error = "";
?>

<head>
    <meta charset="UTF-8">
    <title>Log-in</title>
    <link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../includes/functions.js"></script>
</head>
<?php
$error = "";
if(isset($_POST['login_submit'])) {
    // username and password sent from form
    $username = mysqli_real_escape_string($connection, $_POST['username']); //gebruikersnaam
    $password = md5(mysqli_real_escape_string($connection, $_POST['password']));

    //$encrypt_password = md5($password);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($connection, $sql);
    $subjects = mysqli_fetch_assoc($result);

    if($subjects)
    {
        session_start();
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);
        $subjects = mysqli_fetch_assoc($result);
        $_SESSION['current_user_id'] = $subjects['id'];

        redirect_to("../index.php");
    }
    else {
        $error = "Invalid username or password!";
    }


}
?>

<body>
<div class="container">
    <div class="row">
        <div class="panel panel-default col-md-6">
            <form action="" method="post">
                <div class="panel-heading" style="background-color: #3d6da7 !important; color: white !important;">Login as user </div>
                <div class="panel-body">
                    <p class="red"><?php echo $error; ?></p>
                    <p>Username : <input type="text" name="username" required>  </p>
                    <p>Password : <input type="password" name="password" required></p>
                    <a style="float:left;" href="register.php">Maak nieuw account aan</a><br>
                    <a href="forgetpass.php">Wachtwoord vergeten</a>
                    <input style="float: right" type="submit" class="btn btn-warning btn-sm" name="login_submit" value="Log-in">
                </div>
            </form>
        </div> <!-- eind div col-md-6 -->
    </div> <!-- eind div row -->
</div> <!-- eind div container -->
</body>