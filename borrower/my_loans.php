<?php

require_once "../includes/session.php";
require_once "../controllers/LoanController.php";

if($_SESSION['role']!='borrower'){
    header("Location: ../login.php");
    exit;
}

$loan=new LoanController();

$data=$loan->myLoans($_SESSION['user_id']);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Pinjaman Saya</title>

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
class="btn btn-secondary btn-sm">

Dashboard

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<h2 class="mb-4">

📄 Pinjaman Saya

</h2>

<div class="card shadow-sm">

<div class="card-header">

Daftar Pengajuan Pinjaman

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-primary">

<tr>

<th>ID</th>

<th>Jumlah</th>

<th>Bunga</th>

<th>Tenor</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php if(count($data)>0){ ?>

<?php foreach($data as $row){ ?>

<tr>

<td>

<?= $row['id'] ?>

</td>

<td>

Rp <?= number_format($row['amount'],0,',','.') ?>

</td>

<td>

<?= $row['interest_rate'] ?> %

</td>

<td>

<?= $row['duration_month'] ?> Bulan

</td>

<td>

<?php

switch($row['status']){

case 'pending':

echo "<span class='badge bg-warning text-dark'>Pending</span>";

break;

case 'approved':

echo "<span class='badge bg-primary'>Approved</span>";

break;

case 'funded':

echo "<span class='badge bg-info text-dark'>Funded</span>";

break;

case 'active':

echo "<span class='badge bg-success'>Active</span>";

break;

case 'rejected':

echo "<span class='badge bg-danger'>Rejected</span>";

break;

default:

echo "<span class='badge bg-secondary'>".$row['status']."</span>";

}

?>

</td>

</tr>

<?php } ?>

<?php }else{ ?>

<tr>

<td colspan="5" class="text-center text-muted">

Belum ada data pinjaman.

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<div class="mt-3">

<a
href="create_loan.php"
class="btn btn-success">

➕ Ajukan Pinjaman

</a>

<a
href="dashboard.php"
class="btn btn-outline-primary">

← Kembali Dashboard

</a>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>