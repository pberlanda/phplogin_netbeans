<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
    exit('Connessione fallita a MYSQL:' . mysqlli_connect_errno());
}

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Inserisci username e password!');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // salva i risultati della query per controllare che l'username esista nel db
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        // account esistente, ora controllo la password
        $userPassword = $_POST['password'];
        
        // password crittografata
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //if ($_POST['password'] === $password) {  // questo funziona con password non crittografata

        // controlla la password. Con questa funzione confronto la password immessa dall'utente nel form con quella letta dalla query e crittografata
        if (password_verify($userPassword, $hashedPassword)) {
            // verifica completata con successo
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['name'] = $id;
            $_SESSION['id'] = $id;
            // echo 'Welcome ' . $_SESSION['name'] . '!'; serve per test autenticazione
            header('Location: home.php');
        } else {
            // password non corretta
            echo 'Nome utente e/o password non valida!';
        } 
        
    } else {
        // nome utente non corretto
        echo 'Nome utente non corretto!';
    }

    $stmt->close();

}
?>