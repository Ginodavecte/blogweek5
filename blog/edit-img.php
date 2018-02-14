<?php session_start();?>
<?php include("../includes/database.php");?>
<?php include("../includes/functions.php");?>
<head>
    <meta charset="UTF-8">
    <title>Blog-plaatsen</title>
    <link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../includes/functions.js"></script>
    <script src="../jquery-3.3.1.min.js"></script>
</head>
<div class="container">
<?php
$error = "";
if(isset($_SESSION['current_user_id'])) {
    $article_id = $_GET['id'];
    if(isset($_POST['deleteImg'])){
        $delete_img = null;
        $sql = "UPDATE article SET article_img = '$delete_img' WHERE id = '$article_id'";
        $result = mysqli_query($connection, $sql);
    }
    if(isset($_POST['editImg'])) {
        $new_img = $_FILES['new_image']; //get file from html form
        if ($new_img['type'] != "image/png") {
            $error = "Sorry, only .PNG files are allowed.";
        } else {
            // Check file size
            if ($new_img['size'] > 1000000) {
                $error = "Sorry, your file is too large. Max is 1 MB";
            } else {
                $temp_img_name = $new_img['tmp_name']; //get temp filename and put it in temp variable
                $new_img = mysqli_real_escape_string($connection, fread(fopen($temp_img_name, 'rb'), $new_img['size'])); //get the raw data of the image in a variable to put in in database with blob value

                $sql = "UPDATE article SET article_img = '$new_img' WHERE id = '$article_id'";
                $result = mysqli_query($connection, $sql);
            }
        }
    }
    $article_id = $_GET['id'];
    $sql = "SELECT * FROM article WHERE id = '$article_id'";
    $result = mysqli_query($connection, $sql);
    $subjects = mysqli_fetch_assoc($result);
    ?>


    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well well-sm">
                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <legend class="text-center">Edit Image</legend>


                        <!-- Current Image-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="image">Current Image : </label>
                            <div class="col-md-9">
                                <?php if (!empty($subjects['article_img'])) {
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($subjects['article_img']) . '" height="100" width="150"/>';
                                } else {
                                    echo '<img src="../includes/img/fcgroningenlogo.jpg" height="100" width="150"/>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Edit image-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="image">Change Image : </label>
                            <div class="col-md-9">
                                <input type="file" name="new_image" class="form-control" >
                            </div>
                        </div>

                        <!-- Form actions -->
                        <div class="form-group">
                            <div class="col-md-6 text-left">
                                <?php if (!empty($error)) {
                                    echo '<p class="alert alert-danger">' . $error . '</p>';
                                }; ?>
                            </div>
                            <div class="col-md-6 text-right">
                                <input type="submit" class="btn btn-success btn-sm" name="editImg" value="Verander">
                                <input type="submit" class="btn btn-danger btn-sm" name="deleteImg" value="Verwijder">
                            </div>
                        </div>
                        <div>
                            <div class="col-md-12">
                                <a href="select-article.php">Ga terug</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    </div>
    <?php
}  //end of if statement session user
?>