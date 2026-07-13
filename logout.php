<?php

session_start();

session_destroy();

session_start();

$_SESSION['logout_success']="Berhasil Logout.";

header("Location: login.php");

exit();