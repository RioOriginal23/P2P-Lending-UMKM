<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/controllers/AuthController.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $auth = new AuthController();

    $result = $auth->register($_POST);

    $message = $result['message'];

    if ($result['success']) {

        header("Location: login.php");
        exit;

    }

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Register</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow">

<div class="card-body p-4">

<h2 class="text-center text-primary mb-2">

🚀 SIPPIU

</h2>

<p class="text-center text-muted mb-4">

Daftar Akun SIPPIU

</p>

<?php if(!empty($message)){ ?>

<div class="alert alert-info">

<?= $message ?>

</div>

<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Nama Lengkap

</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Role

</label>

<select
name="role"
class="form-select">

<option value="borrower">

Borrower

</option>

<option value="investor">

Investor

</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nomor HP

</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nama Usaha

</label>

<input
type="text"
name="business_name"
class="form-control">

</div>

<div class="col-12 mb-3">

<label class="form-label">

Alamat

</label>

<textarea
name="address"
rows="3"
class="form-control"></textarea>

</div>

</div>

<div class="d-grid">

<button
type="submit"
class="btn btn-success">

📝 Register

</button>

</div>

</form>

<hr>

<p class="text-center mb-0">

Sudah punya akun?

<a href="login.php">

Login

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