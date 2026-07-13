<?php

require_once "../includes/session.php";
require_once "../controllers/LoanController.php";
require_once "../models/Installment.php";
require_once "../config/database.php";

if($_SESSION['role']!="borrower"){
    header("Location: ../login.php");
    exit;
}

$loanController = new LoanController();

$loan = $loanController->getActiveLoan($_SESSION['user_id']);

$installments=[];

if($loan){

    $db=(new Database())->connect();

    $installment=new Installment($db);

    $installments=$installment->getByLoan($loan['id']);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Cicilan Saya</title>

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

<div class="container mt-4">

<h2 class="mb-4">

💳 Daftar Cicilan

</h2>

<?php if(!$loan){ ?>

<div class="alert alert-warning">

Belum ada pinjaman yang sedang berjalan.

</div>

<?php }else{ ?>

<div class="card shadow-sm mb-4">

<div class="card-body">

<h5>

Jumlah Pinjaman

</h5>

<h3 class="text-primary">

Rp <?= number_format($loan['amount'],0,',','.') ?>

</h3>

</div>

</div>

<div class="card shadow-sm">

<div class="card-header">

Daftar Cicilan

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-primary">

<tr>

<th>No</th>

<th>Jatuh Tempo</th>

<th>Nominal</th>

<th>Status</th>

<th width="120">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php foreach($installments as $row){ ?>

<tr>

<td>

<?= $row['installment_number'] ?>

</td>

<td>

<?= $row['due_date'] ?>

</td>

<td>

Rp <?= number_format($row['amount'],0,',','.') ?>

</td>

<td>

<?php if($row['status']=="paid"){ ?>

<span class="badge bg-success">

Lunas

</span>

<?php }else{ ?>

<span class="badge bg-warning text-dark">

Belum Bayar

</span>

<?php } ?>

</td>

<td>

<?php if($row['status']=="unpaid"){ ?>

<a

href="confirm_payment.php?id=<?= $row['id'] ?>"
class="btn btn-success btn-sm">

Bayar

</a>

<?php }else{ ?>

<span class="text-success fw-bold">

✔ Lunas

</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php } ?>

<div class="mt-3">

<a
href="dashboard.php"
class="btn btn-secondary">

← Kembali Dashboard

</a>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
