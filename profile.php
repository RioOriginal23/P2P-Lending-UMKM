<?php

require_once "includes/session.php";
require_once "controllers/ProfileController.php";

$profile = new ProfileController();

$user = $profile->getProfile($_SESSION['user_id']);

$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $_POST['id'] = $_SESSION['user_id'];

    $profile->update($_POST);

    $message = "Profil berhasil diperbarui.";

    $user = $profile->getProfile($_SESSION['user_id']);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Profil Saya</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg bg-white">

<div class="container">

<a class="navbar-brand fw-bold text-primary">

🚀 SIPPIU

</a>

<div>

<span class="me-3">

👋 <?= $_SESSION['name']; ?>

</span>

<a
href="logout.php"
class="btn btn-danger btn-sm">

Logout

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow-sm">

<div class="card-header">

<h4 class="mb-0">

👤 Profil Saya

</h4>

</div>

<div class="card-body">

<?php if($message!=""){ ?>

<div class="alert alert-success">

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
value="<?= htmlspecialchars($user['name']) ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
class="form-control"
value="<?= htmlspecialchars($user['email']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nomor HP

</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= htmlspecialchars($user['phone']) ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nama Usaha

</label>

<input
type="text"
name="business_name"
class="form-control"
value="<?= htmlspecialchars($user['business_name']) ?>">

</div>

<div class="col-12 mb-3">

<label class="form-label">

Alamat

</label>

<textarea
name="address"
rows="4"
class="form-control"><?= htmlspecialchars($user['address']) ?></textarea>

</div>

</div>

<div class="d-flex justify-content-between">

<button
type="submit"
class="btn btn-primary">

💾 Simpan Perubahan

</button>

<?php

$dashboard = "login.php";

if($_SESSION['role']=="admin"){

    $dashboard = "admin/dashboard.php";

}elseif($_SESSION['role']=="borrower"){

    $dashboard = "borrower/dashboard.php";

}elseif($_SESSION['role']=="investor"){

    $dashboard = "investor/dashboard.php";

}

?>

<a
href="<?= $dashboard ?>"
class="btn btn-secondary">

← Kembali Dashboard

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>