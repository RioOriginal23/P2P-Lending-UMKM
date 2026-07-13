<?php

require_once "../includes/session.php";
require_once "../controllers/LoanController.php";

if($_SESSION['role']!="investor"){
    header("Location: ../login.php");
    exit;
}

$loan=new LoanController();

$loans=$loan->getApproved();

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Proposal Pendanaan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-expand-lg bg-white">

<div class="container">

<a class="navbar-brand fw-bold text-primary" href="#">

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

📋 Proposal Pendanaan UMKM

</h2>

<div class="card shadow-sm">

<div class="card-header">

Daftar Proposal

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-primary">

<tr>

<th>ID</th>

<th>UMKM</th>

<th>Usaha</th>

<th>Target Dana</th>

<th>Terkumpul</th>

<th>Progress</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php foreach($loans as $row){ ?>

<?php

$progress=0;

if($row['amount']>0){

$progress=($row['funded_amount']/$row['amount'])*100;

}

?>

<tr>

<td>

<?= $row['id'] ?>

</td>

<td>

<?= $row['name'] ?>

</td>

<td>

<?= $row['business_name'] ?>

</td>

<td>

Rp <?= number_format($row['amount'],0,',','.') ?>

</td>

<td>

Rp <?= number_format($row['funded_amount'],0,',','.') ?>

</td>

<td width="220">

<div class="progress">

<div

class="progress-bar bg-success"

role="progressbar"

style="width: <?= min($progress,100) ?>%;">

<?= round($progress) ?>%

</div>

</div>

</td>

<td>

<a

href="funding.php?id=<?= $row['id'] ?>"

class="btn btn-success btn-sm">

💰 Danai

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<div class="mt-3">

<a href="dashboard.php" class="btn btn-primary">

← Kembali Dashboard

</a>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>