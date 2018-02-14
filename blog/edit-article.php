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

if(isset($_SESSION['current_user_id'])) {
    if (isset($_POST['editPost'])) {
            $article_id = $_GET['id'];
            $new_title = htmlentities($_POST['new_title']);
            $new_article = htmlentities($_POST['new_article']);
            $new_cat_id = htmlentities($_POST['new_category']);
            date_default_timezone_set("Europe/Amsterdam");
            $date = date("Y-m-d H:i:s");
            $sql = "UPDATE article
                    SET article_title = '$new_title', category_id = '$new_cat_id',
                    article = '$new_article', date = '$date' WHERE id = '$article_id'";
             //     var_dump($sql);


           $result = mysqli_query($connection, $sql);
            echo "Het artikel is succesvol gewijzigd";

    } //end of if EDIT NEW
    $article_id = $_GET['id'];
    $sql = "SELECT * FROM article WHERE id = '$article_id'";
    $result = mysqli_query($connection, $sql);
    $subjects = mysqli_fetch_assoc($result);
//    var_dump($subjects);
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well well-sm">
                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <legend class="text-center">Edit Article</legend>

                        <!-- Edit Name-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="name">Edit Title : </label>
                            <div class="col-md-9">
                                <input type="text" name="new_title" value="<?php echo $subjects['article_title'] ;?>"
                                       class="form-control" required>
                            </div>
                        </div>

                        <!-- Category input-->
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="name">Edit Category :</label>
                            <div class="col-md-9">
                                <?php
                                $sql = "SELECT * FROM category ORDER BY id";
                                $result = mysqli_query($connection, $sql);
                                $selected_venue_id = "";
                                $cat_id = $subjects['category_id'];
                                $sql2 = "SELECT name FROM category WHERE id = '$cat_id'";
                                $result2 = mysqli_query($connection, $sql2);
                                $cat_name = mysqli_fetch_assoc($result2);
                                echo "<select name = 'new_category' class=\"form-control\" required>";
                                ?>
                                <option selected value="<?php echo $cat_id;?>"><?php echo $cat_name['name'];?></option>
                                <?php
                                while (($row = mysqli_fetch_array($result)) != null) {
                                    echo "<option value = '{$row['id']}'";
                                    if ($selected_venue_id == $row['id'])
                                        echo "selected = 'selected'";
                                    echo ">{$row['name']}</option>";
                                }
                                echo "</select required>"; ?>
                            </div>
                        </div>

                        <!--                             Message body -->
                        <div class="form-group">
                            <label class="col-md-3 control-label">Edit Article :</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="10" cols="30" maxlength="250"
                                          name="new_article" required><?php echo $subjects['article'];?></textarea>
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
                                <input type="submit" class="btn btn-success btn-sm" name="editPost" value="Post">
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
<?php

}// end of if session

?>
</div>
