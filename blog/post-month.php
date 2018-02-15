<?php session_start();?>
<?php include("../includes/database.php");?>
<?php include("../includes/functions.php");?>
<head>
    <link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
</head>
<?php
$output = '';

if(isset($_POST["month_id"]))
{
    $month_id = $_POST['month_id'];
        $sql = "SELECT *, article.id as article_id FROM article,users
                WHERE MONTH(date) = '$month_id' AND users.id = article.user_id
                ORDER BY article.date DESC";

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
        $output .= '</span></li>';
        $output .= '</ul></form>';
        $output .= '</div></div></div>';
    }
    echo $output;
}
?>
