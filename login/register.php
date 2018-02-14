<?php include("../includes/database.php");?>
<?php include("../includes/functions.php");?>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../includes/functions.js"></script>
</head>

<body>
<?php
$error = "";
if(isset($_POST['register_submit'])){
    $add_username = mysqli_real_escape_string($connection, $_POST['username']);
    $add_password = mysqli_real_escape_string($connection, $_POST['password']);
    $sql = "SELECT * FROM users WHERE username = '$add_username';";
    $result = mysqli_query($connection, $sql);

    if($result->num_rows < 1){
        //md5() calculates the MD5 hash of a string
        $encrypt_password=md5($add_password);
        $sql = "INSERT INTO users (username, password)
                    VALUES ('$add_username','$encrypt_password');";
        $result = mysqli_query($connection, $sql);
        if($result!=1)
        {
            echo "Er is iets fout gegaan, probeer opnieuw!";
        }
        else{
            echo "U heeft succesvol een nieuw user account aagemaakt!";
        }

    }else{
        echo "De username die je gekozen hebt bestaat al.";
    }
}
?>
<div class="container">
    <div class="row">
        <div class="panel panel-default col-md-6">
            <form action="" method="post">
                <div class="panel-heading" style="background-color: #3d6da7 !important; color: white !important;">Voeg user toe </div>
                <div class="panel-body">
                    <p>Username : <input type="text" name="username" placeholder="Your Username" required>
                        <a style="float:right;" href="login.php">Log-in</a></p>
                    <p>Password : <input type="password" name="password" placeholder="Your Password" required></p>
                    <a style="float:left;" href="../index.php">Ga terug </a>
                    <input style="float: right" type="submit" class="btn btn-warning btn-sm" name="register_submit" value="Voeg user toe">

                </div>
            </form>
        </div> <!-- eind div col-md-6 -->
    </div> <!-- eind div row -->
</div></body>
