<?php

require_once __DIR__ . '/controllers/AuthController.php';

$message = "";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['logout_success'])){

    $message = $_SESSION['logout_success'];

    unset($_SESSION['logout_success']);

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $auth = new AuthController();

    $result = $auth->login($_POST);

    if ($result['success']) {

        switch ($result['role']) {

            case 'admin':
                header("Location: admin/dashboard.php");
                exit();

            case 'borrower':
                header("Location: borrower/dashboard.php");
                exit();

            case 'investor':
                header("Location: investor/dashboard.php");
                exit();

            default:
                $message = "Role tidak dikenali.";
        }

    } else {

        $message = $result['message'];

    }

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="container">

<div class="row justify-content-center align-items-center" style="min-height:100vh;">

<div class="col-md-5">

<div class="card shadow">

<div class="card-body p-4">

<h2 class="text-center text-primary mb-2">

🚀 SIPPIU

</h2>

<p class="text-center text-muted mb-4">

Sistem Informasi Peer-to-Peer Investasi UMKM

</p>

<?php if(!empty($message)){ ?>

<div class="alert alert-danger">

<?= $message ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="d-grid">

<button
type="submit"
class="btn btn-primary">

🔑 Login

</button>

</div>

</form>

<hr>

<p class="text-center mb-0">

Belum punya akun?

<a href="register.php">

Daftar Sekarang

</a>

</p>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>