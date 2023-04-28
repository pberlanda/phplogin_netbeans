<?php
// usiamo le sessioni
session_start();
// se l'utente non è loggato lo mando alla pagina login
if (!isset($_SESSION['loggedin'])) {
    header('Location:index.html');
    exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

// crea la connessione al db
$con = mysqli_connect($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASS,$DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Connessione al db fallita! ' . mysqli_connect_errno);
};

// nella session non c'è la email, la leggo al db
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');

// uso ID account per trovare le info
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <title>Profilo utente</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    </head>
    <body class="loggedin">
        <nav class="navtop">
            <div>
                <h1>Il mio sito</h1>
                <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
            </div>
        </nav>
        <div class="content">
            <h2>Pagina profilo</h2>
            <div>
                <p>Ecco i dettagli del tuo account:</P>
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><?=$_SESSION['name']?></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><?=$password?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?=$email?></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>