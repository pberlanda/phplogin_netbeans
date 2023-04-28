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
$stmt = $con->prepare('SELECT password, email, nome, cognome, data_nascita FROM accounts WHERE id = ?');

// uso ID account per trovare le info
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $nome, $cognome, $data_nascita);
$stmt->fetch();
$stmt->close();

// formato della data
// 1. converto la data estratta dal db in oggetto dara pho
// 2. applico il formato
                        
$tmpDataNascita = DateTime::createFromFormat('Y-m-d H:i:s', $data_nascita);
$formatDataNascita = $tmpDataNascita->format('d-m-Y');

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
                        <td>Nome:</td>
                        <td><?=$nome?></<td>
                    </tr>
                    <tr>
                        <td>Cognome:</td>
                        <td><?=$cognome?></<td>
                    </tr>
                    <tr>
                        <td>Data di nascita:</td>
                        <td><?=$formatDataNascita?></<td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?=$email?></td>
                    </tr>
                </table>
            </div>
            
            
            <!-- inizio test -->
            <div class="content">
                    <form  method="post">
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input class="form-control" type="text" name="id" id="id" value="<?php echo $id ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input  class="form-control" type="text" name="name" id="name" placeholder="Nome e cognome" value="<?php echo $name; ?>" required maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input  class="form-control" type="text" name="email" id="email" placeholder="emailaccount@youmail.com" value="<?php echo $email; ?>" required maxlength="100">
                    </div>
                    <!-- 
                        ho aggiunto un btn per annulla che in POST richiama redirect via PHP

                    <input class="btn btn-primary mb-2" type="submit" name="btn_save" value="Salva">
                    <input class="btn btn-primary mb-2" type="submit" name="btn_cancel" value="Annulla">

                    -->

                    <!-- i btn sopra sono stati sostituiti da questo form group, con btnSave e
                        un link con aspetto di btn per annulllare
                    -->

                    <div class="form-group">
                        <label class="col-md-4 control-label" for "submit"></label>
                        <div class="col-md-8">
                            <button id="submit" name ="btn_save" class="btn btn-primary" value="1">Salva</button>
                            <a href="index.php" id="cancel" name="cancel" class="btn btn-default">Annulla</a>
                        </div>
                    </div>
                  </form>
            </div>
            <!-- fine test -->
            
            
        </div>
    </body>
</html>