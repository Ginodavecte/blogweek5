<?php session_start();?>
<?php include("includes/database.php");?>
<?php include("includes/functions.php");?>

<head>
    <meta charset="UTF-8">
    <title>Blog</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<div class="container">

<?php
if(isset($_SESSION['current_user_id'])){
    $sql = "SELECT * FROM users WHERE id ='".$_SESSION['current_user_id']."'";
    $result = mysqli_query($connection, $sql);
    $subjects = mysqli_fetch_assoc($result);
    $username = $subjects['username'];
    echo "<div style='float: right'>Welkom  ". $username ."</div>";
    ?>
    <div style="float: left">
    <h4>Kies hier uw gewenste keuze</h4>
    <ul>
        <li><a href="blog/read.php">Lees de geplaatste artikelen.</a></li>
        <li><a href="blog/blogger.php">Lees artikelen van u favoriete blogger.</a></li>
        <li><a href="blog/write.php">Schrijf zelf een artikel.</a></li>
        <li><a href="admin/add_category.php">Voeg een categorie toe.</a></li>
        <li><a href="blog/select-article.php">Wijzig/Verwijder een eigen geplaatst artikel.</a></li>
        <li><a href="login/logout.php">Log-out.</a></li>
    </ul>
    </div>
    <?php
}else{
    echo "<div style='float: right'>Welkom, u bent niet ingelogd."?><br><a href="login/login.php">Klik hier om in te loggen</a><br>
          <?php echo " of "?><br>
          <a href="login/register.php"> Klik hier om aan te melden.</a><?php echo "</div>";?>
    <div style="float: left">
    <h4>Kies hier uw gewenste keuze</h4>
    <ul>
        <li><a href="blog/read.php">Lees de geplaatste artikelen.</a></li>
        <li><a href="blog/blogger.php">Lees artikelen van u favoriete blogger.</a></li>
    </ul>
    </div>
<?php
}


?>
</div>