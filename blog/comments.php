<?php session_start();?>
<?php include("../includes/database.php");?>
<?php include("../includes/functions.php");?>
<head>
    <meta charset="UTF-8">
    <title>Comments</title>
    <link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../jquery-3.3.1.min.js"></script>
    <script src="../includes/functions.js"></script>
    <script>
        $(function() {
            $("#submit").click(function() {
              event.preventDefault();
                var anonymous = document.getElementById('anonymous');
                //console.log(anonymous);
                if(anonymous.checked){
                    anonymous = 1;
                }else{
                    anonymous = 0;
                }
                var comment = $("#message").val();
                var article_id = $("#article_id").val();
                var dataString = 'anonymous='+ anonymous + '&comment=' + comment + '&article_id=' + article_id;

                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "post-comment.php",
                        data: dataString,
                        success: function () {
                            location.reload();
                        }
                    });
                return false;
            });
        });
    </script>
</head>
<div class="container">
<?php
if(isset($_SESSION['current_user_id'])) {
    if (isset($_POST['submitComment'])) {
        $article_id = $_POST['article_id'];
        $user_id = $_SESSION['current_user_id'];
        $sql = "SELECT username FROM users WHERE id = '$user_id'";
        $result = mysqli_query($connection, $sql);
        $username = mysqli_fetch_assoc($result);  //Kan/moet mooier
        $sql2 = "SELECT * FROM article WHERE id = '$article_id'";
        $result2 = mysqli_query($connection, $sql2);
        $subjects = mysqli_fetch_assoc($result2);
        ?>
        <div class="container">
            <h1>Original Post</h1>
            <div class="well">
                <div class="media">
                    <a class="pull-left">
                        <?php if (!empty($subjects['article_img'])) {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($subjects['article_img']) . '" height="100" width="150"/>';
                        } else {
                            echo '<img src="../includes/img/fcgroningenlogo.jpg" height="100" width="150"/>';
                        }
                        ?>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $subjects['article_title']; ?></h4>
                        <p class="text-right"><?php echo "<b>" . $username['username'] . "</b>"; ?></p>
                        <p><?php echo $subjects['article']; ?></p>
                        <ul class="list-inline list-unstyled">
                            <li><span><i
                                        class="glyphicon glyphicon-calendar"></i><?php echo $subjects['date']; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            $sql = "SELECT * FROM comment c, users u WHERE c.article_id = '$article_id'
                    AND c.user_id = u.id ORDER BY date DESC";
            $result = mysqli_query($connection, $sql);
            $subjects = mysqli_fetch_all($result, MYSQLI_BOTH);
            ?>
            <h2>Comments</h2><!-- Rounded switch -->
            <label class="switch">
                <input type="checkbox" id="commentCheck" checked>
                <span class="slider round"></span>
            </label>
            <?php
            foreach ($subjects as $subject) {
                ?>
                <div class="well">
                    <div class="media">
                        <a class="pull-left">
                            <img src="../includes/img/comment.png" height="100" width="100">
                        </a>
                        <div class="media-body">
                            <!--                    <h4 class="media-heading">MOET UIT DB KOMEN. TITEL VAN COMMENT</h4>-->
                            <p class="text-right"><?php echo $subject['username']; ?></p>
                            <p><?php echo $subject['comment']; ?></p>
                            <ul class="list-inline list-unstyled">
                                <li><span><i
                                            class="glyphicon glyphicon-calendar"></i><?php echo $subject['date']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>  <!-- END OF LAST WELL -->
                <?php
            }  //end of foraech for comment section
            ?>
            <div class="commentChecked">
                <h3>Post a reply</h3>
                <div class="col-md-5">
                    <div class="form-area">
                        <br style="clear:both">
                        <form method="post" name="post-comment">
                            <div class="form-group">
                                <label><input type="checkbox" id="anonymous" name="anonymous" class="anonymous"> Post
                                    comment anonymous</label>
                            </div>
                            <input type="hidden" id="article_id" name="article_id" value="<?php echo $article_id; ?>">
                            <div class="form-group">
                                <textarea class="form-control" name="comment" id="message"
                                          placeholder="Type your comment here..." maxlength="140" rows="7"
                                          required></textarea>
                                <span class="help-block"><p id="characterLeft" class="help-block ">You have reached the
                                        limit</p></span>
                            </div>
                            <button type="submit" id="submit" name="submitNewComment"
                                    class="btn btn-primary pull-right">Submit Comment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <a href="read.php">Ga terug</a>
        </div>     <!--END OF CONTAINER  -->

        <?php

    } //end of if submitComment
} //end of if SESSION user
else {
    $article_id = $_POST['article_id'];
    $sql = "SELECT * FROM article LEFT JOIN users ON users.id = article.user_id
            WHERE article.id = '$article_id'";
    $result = mysqli_query($connection, $sql);
    $subjects = mysqli_fetch_assoc($result);
?>
    <h1>Original Post</h1>
            <div class="well">
                <div class="media">
                    <a class="pull-left">
                        <?php if (!empty($subjects['article_img'])) {
        echo '<img src="data:image/jpeg;base64,' . base64_encode($subjects['article_img']) . '" height="100" width="150"/>';
    } else {
        echo '<img src="../includes/img/fcgroningenlogo.jpg" height="100" width="150"/>';
    }
                        ?>
    </a>
    <div class="media-body">
        <h4 class="media-heading"><?php echo $subjects['article_title']; ?></h4>
        <p class="text-right"><?php echo "<b>" . $subjects['username'] . "</b>"; ?></p>
        <p><?php echo $subjects['article']; ?></p>
        <ul class="list-inline list-unstyled">
            <li><span><i
                        class="glyphicon glyphicon-calendar"></i><?php echo $subjects['date']; ?></span>
            </li>
        </ul>
    </div>
    </div>
    </div>
    <?php

    $sql = "SELECT * FROM comment c, users u WHERE c.article_id = '$article_id'
                    AND c.user_id = u.id ORDER BY date DESC";
    $result = mysqli_query($connection, $sql);
    $subjects = mysqli_fetch_all($result, MYSQLI_BOTH);
    ?>
    <h2>Comments</h2><!-- Rounded switch -->
    <?php
    foreach ($subjects as $subject) {
        ?>
        <div class="well">
            <div class="media">
                <a class="pull-left">
                    <img src="../includes/img/comment.png" height="100" width="100">
                </a>
                <div class="media-body">
                    <p class="text-right"><?php echo $subject['username']; ?></p>
                    <p><?php echo $subject['comment']; ?></p>
                    <ul class="list-inline list-unstyled">
                        <li><span><i
                                    class="glyphicon glyphicon-calendar"></i><?php echo $subject['date']; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>  <!-- END OF LAST WELL -->
        <?php
    }
    ?><a href="read.php">Ga terug</a><?php
}
?>
</div>
<script>
$(document).ready(function(){
    $("#commentCheck").change(function(){
        if($(this).is(':checked')) $(".commentChecked").show();
        else $(".commentChecked").hide();;
    });
});

</script>
