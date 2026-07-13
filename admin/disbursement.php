<?php

require_once "../includes/session.php";
require_once "../controllers/DisbursementController.php";

if($_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit;
}

$message="";

if(isset($_GET['id'])){

    $controller=new DisbursementController();

    $message=$controller->process($_GET['id']);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Pencairan Dana</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="../assets/css/style.css">

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
href="dashboard.php"
class="btn btn-outline-primary btn-sm">

Dashboard

</a>

</div>

</div>

</nav>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow">

<div class="card-header bg-success text-white">

💰 Pencairan Dana

</div>

<div class="card-body text-center">

<?php

if(stripos($message,"berhasil")!==false){

?>

<div class="alert alert-success">

<h4>

✅ Berhasil

</h4>

<p class="mb-0">

<?= $message ?>

</p>

</div>

<?php

}else{

?>

<div class="alert alert-warning">

<h4>

⚠ Informasi

</h4>

<p class="mb-0">

<?= $message ?>

</p>

</div>

<?php

}

?>

<div class="mt-4">

<a
href="loan_list.php"
class="btn btn-primary">

📋 Kembali ke Review Proposal

</a>

<a
href="dashboard.php"
class="btn btn-secondary">

🏠 Dashboard

</a>

</div>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>