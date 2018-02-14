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
    <h1>Wijzig of verwijder hier een van u geplaatste artikelen.</h1>
<?php

if(isset($_SESSION['current_user_id'])) {
    $output = "";
    $user_id = $_SESSION['current_user_id'];
    $sql = "SELECT * FROM article WHERE user_id = '$user_id'";
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
        $output .= '<p> '.$row["article"].'</p>';
        $output .= '<form method="post" action="comments.php">';
        $output .= '<input type="hidden" name="article_id" value=" '.$row['id'].'">';
        $output .= '<ul class="list-inline list-unstyled">';
        $output .= '<li>';
        $output .= '<span>';
        $output .= '<i class="glyphicon glyphicon-calendar"></i>';
        $output .= ''.$row['date'].'';
        $output .= '</span></li>';
        $output .= '<li>|</li>';
        $output .= '<li>';
        $output .= '<span><a class="editArticle" href="edit-article.php?id='.$row['id'].'">Edit';
        $output .= '</a></span></li>';
        $output .= '<li>|</li>';
        $output .= '<li>';
        $output .= '<span><a class="editImage" href="edit-img.php?id='.$row['id'].'">Edit Image';
        $output .= '</a></span></li>';
        $output .= '<li>|</li>';
        $output .= '<li>';
        $output .= '<span><a class="deleteArticle" href="delete.php?id='.$row['id'].'" onclick="return confirm(\'Are you sure?\');">Delete';
        $output .= '</a></span></li>';
        $output .= '</span></li>';
        $output .= '</ul></form>';
        $output .= '</div></div></div>';
    }
    echo $output;


}?>
    <a href="../index.php">Ga terug</a>
    </div>
