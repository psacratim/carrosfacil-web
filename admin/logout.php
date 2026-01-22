<?php
// Iniciando sessão
if (!isset($_SESSION)) {
    session_start();
}

if (!empty($_SESSION['id'])) {
    unset($_SESSION['id']);
    unset($_SESSION['name']);
    unset($_SESSION['user']);
    unset($_SESSION['type']);
}