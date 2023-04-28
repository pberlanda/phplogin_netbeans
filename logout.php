<?php
session_start();
session_destroy();
// manda alla pagina login
header('Location: index.html');
?>