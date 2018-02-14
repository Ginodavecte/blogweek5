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
<body>
<?php

?>
    <div class="container">
        <h1>Extra! Extra! Read All About It!</h1>
        <h3>
            <?php
            $output = "";
            if(isset($_POST['searchArticle'])){

                ?><form method="post">
                     <input style="float: right" type="search" name="searchArticle" placeholder="search here..."><br>
                </form>

                <?php
                $searchArticle = $_POST['searchArticle'];
                $sql = "SELECT *, article.id as article_id FROM article, users
                        WHERE users.id = article.user_id
                        AND article.article_title LIKE '%".$searchArticle."%'
                        OR article.article LIKE '%".$searchArticle."%'
                        ORDER BY article.id DESC";
                $result = mysqli_query($connection, $sql);
                while($row = mysqli_fetch_array($result))
                {
                    $output .= '<div class="well">';
                    $output .= '<div class="media">';
                    $output .=     '<a class="pull-left">';
                    if(!empty($row['article_img'])){
                        $output .=  '<img src="data:image/jpeg;base64,'.base64_encode( $row['article_img'] ).'"';
                        $output .=   'height="100" width="150"/>';
                    }else {
                        $output .= '<img src = "../includes/img/fcgroningenlogo.jpg" height = "100" width = "150" />';
                    }
                    $output .= '</a>';
                    $output .= '<div class="media-body">';
                    $output .= '<h4 class="media-heading"> '. $row["article_title"]. '</h4>';
                    $output .= '<p class="text-right"><b>'.$row['username'].'</b></p>';
                    $output .= '<p> '.$row["article"].'</p>';
                    $output .= '<form method="post" action="comments.php">';
                    $output .= '<input type="hidden" name="article_id" value=" '.$row['article_id'].'">';
                    $output .= '<ul class="list-inline list-unstyled">';
                    $output .= '<li>';
                    $output .= '<span>';
                    $output .= '<i class="glyphicon glyphicon-calendar"></i>';
                    $output .= ''.$row['date'].'';
                    $output .= '</span></li>';
                    $output .= '<li>|</li>';
                    $output .= '<li><span>';
                    $output .= '<span class="glyphicon glyphicon-comment blue"></span>';
                    $output .= '<input class="submitComment" type="submit" value="Comments" name="submitComment">';
                    $output .= '<li>|</li>';
                    $output .= '<li>';
                    $output .= '<span><a class="deleteArticle" href="delete.php?id='.$row['article_id'].'" onclick="return confirm(\'Are you sure?\');">Delete';
                    $output .= '</a></span></li>';
                    $output .= '</span></li>';
                    $output .= '</ul></form>';
                    $output .= '</div></div></div>';
                }
                echo $output;
                ?> <a href="read.php">Ga terug naar alle artikelen</a>
            <?php
                exit();
            }


            ?>
            <form method="post">
            <select name="category" id="category">
                <option value="">Show All Articles</option>
                <?php echo fill_category($connection); ?>
            </select>
            <input style="float: right" type="search" name="searchArticle" placeholder="search here...">
            </form>
                <br /><br />
            <div class="row" id="show_articles">

            </div>
        </h3>
        <a href="../index.php">Ga terug</a>
    </div> <!--eind div container -->

</body>
<script>
    function loadData(select){
        var category_id = select.val();
        $.ajax({
            url:"post-read.php",
            method:"POST",
            data:{category_id:category_id},
            success:function(data){
                $('#show_articles').html(data);
            }
        });
    }
    $(document).ready(function(){
        $('#category').change(function(){
            loadData($(this));
        });

        loadData($("#category"));
    });
</script>
