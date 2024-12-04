<?php
session_start();
if (isset($_SESSION['organizador'])) {
    header('Location: pages/tela_principal.php');
    exit;
} else {
    header('Location: pages/login.php');
    exit;
}
?>
