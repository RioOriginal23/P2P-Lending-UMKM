<?php

require_once "../includes/session.php";
require_once "../controllers/LoanController.php";
require_once "../controllers/InvestmentController.php";

if($_SESSION['role']!="investor"){
    header("Location: ../login.php");
    exit;
}

$loanController=new LoanController();

$loan=$loanController->getById($_GET['id']);

$message="";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $investment=new InvestmentController();

    $result=$investment->funding($_POST,$_SESSION['user_id']);

    $message=$result['message'];

    $loan=$loanController->getById($_GET['id']);

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Danai Proposal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

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

<a href="dashboard.php" class="btn btn-secondary btn-sm">

Dashboard

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<h2 class="mb-4">

💰 Danai Proposal

</h2>

<?php if($message!=""){ ?>

<div class="alert alert-info">

<?= $message ?>

</div>

<?php } ?>

<div class="card shadow-sm">

<div class="card-header">

Informasi Proposal

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p>

<b>UMKM</b>

<br>

<?= $loan['business_name']; ?>

</p>

<p>

<b>Pemilik</b>

<br>

<?= $loan['name']; ?>

</p>

</div>

<div class="col-md-6">

<p>

<b>Target Pendanaan</b>

<br>

Rp <?= number_format($loan['amount'],0,',','.') ?>

</p>

<p>

<b>Sudah Terkumpul</b>

<br>

Rp <?= number_format($loan['funded_amount'],0,',','.') ?>

</p>

</div>

</div>

<hr>

<form method="POST">

<input
type="hidden"
name="loan_application_id"
value="<?= $loan['id']; ?>">

<div class="mb-3">

<label class="form-label">

Jumlah Pendanaan

</label>

<input
type="number"
name="amount"
class="form-control"
required>

</div>

<button
type="submit"
class="btn btn-success">

💵 Danai Sekarang

</button>

<a
href="proposal_list.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>