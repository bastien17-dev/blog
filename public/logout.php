<?php

require_once __DIR__ . '/../config/bootstrap.php';

unset($_SESSION['user']);

addFlash('info', 'Vous avez bien été deconnecté');
session_write_close();
header('Location: login.php');