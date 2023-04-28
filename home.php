<?php
// avvia la sessione
session_start();
// se l'utente non è loggato lo mando alla pagina di login
if (!isset($_SESSION['loggedin'])) {
    header('Location:index.html');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home page</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    </head>
    <body class="loggedin">
        <nav class="navtop">
            <div>
                <h1>Il mio sito</h1>
                <a href="profile.php"><i class="fas fa-user-circle"></i>Profilo</a>
                <a href="logout.php"><i class="fas fa-sign-out"></i>Logout</a>
            </div>
        </nav>
        <div class="content">
            <h2>Home page</h2>
            <p>Bentornato, <?=$_SESSION['name']?>!</p>
        </div>
    </bodY>
</html>