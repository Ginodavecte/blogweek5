<?php session_start();?>
<?php include("../includes/database.php");?>
<?php include("../includes/functions.php");?>

<head>
    <meta charset="UTF-8">
    <title>Blog-lezen</title>
    <link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../includes/functions.js"></script>
</head>

<?php

if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM `article` WHERE `article`.`id` = '$id'";
        $result = mysqli_query($connection, $sql);
        $message = "Your article has been deleted";
        echo "<script type='text/javascript'>alert('$message');
        function newDoc() {
         document.location.assign('http://localhost/blogw3/blog/read.php');
            }
            newDoc();
        </script>";

}