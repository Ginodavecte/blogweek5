<?php include("../includes/database.php");?>
<?php include("../includes/functions.php");?>

    <head>
        <meta charset="UTF-8">
        <title>Reset Wachtwoord</title>
        <link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
        <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="../jquery-3.3.1.min.js"></script>
        <script src="../includes/functions.js"></script>
    </head>

<?php
if($_GET['key'] && $_GET['reset'])
{
    $username = $_GET['key'];
    $password = $_GET['reset'];


    $sql = "SELECT id, username,password FROM users WHERE md5(username) = '$username' AND password = '$password'";
    $result = mysqli_query($connection, $sql);
    $subjects = mysqli_fetch_assoc($result);
    if($subjects)
    {
        if(isset($_POST['submit_password'])){
            $new_password = mysqli_real_escape_string($connection, $_POST['new_password']);
            $user_id = $_POST['user_id'];
            $md5_password = md5($new_password);
            $sql = "UPDATE users SET password = '$md5_password' WHERE id = '$user_id'";
            $result = mysqli_query($connection, $sql);
            $message = "Uw wachtwoord is gewijzigd!";
            echo "<script type='text/javascript'>alert('$message');
        function newDoc() {
         document.location.assign('http://localhost/blogw3/login/login.php');
            }
            newDoc();
        </script>";

        }
        $user_id = $subjects['id'];
        ?>
        <div class="container">
            <div class="row">
                <div class="panel panel-default col-md-6">
                    <form method="post">
                        <div class="panel-heading" style="background-color: #3d6da7 !important; color: white !important;">Vul nieuw wachtwoord in</div>
                        <div class="panel-body">
                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                            <p>Wachtwoord :  <input type="password" name='new_password' required></p>
                            <input style="float: right" type="submit" class="btn btn-warning btn-sm" name="submit_password" value="Verzend">
                        </div>
                    </form>
                </div> <!-- eind div col-md-6 -->
            </div> <!-- eind div row -->
        </div>
        <?php
    }
}
?>