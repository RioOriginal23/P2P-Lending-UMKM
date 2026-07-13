<?php

require_once "../includes/session.php";
require_once "../controllers/LoanController.php";

if($_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit;
}

$loan = new LoanController();

$data = $loan->getAll();

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Review Proposal</title>

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

📋 Review Proposal Pinjaman

</h2>

<div class="card shadow-sm">

<div class="card-header">

Daftar Proposal

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-primary">

<tr>

<th>ID</th>

<th>Nama Borrower</th>

<th>Nama Usaha</th>

<th>Jumlah Pinjaman</th>

<th>Status</th>

<th width="220">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php foreach($data as $row): ?>

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

<?php

switch($row['status']){

case 'pending':

echo '<span class="badge bg-warning text-dark">Pending</span>';

break;

case 'approved':

echo '<span class="badge bg-primary">Approved</span>';

break;

case 'funded':

echo '<span class="badge bg-info text-dark">Funded</span>';

break;

case 'active':

echo '<span class="badge bg-success">Active</span>';

break;

case 'rejected':

echo '<span class="badge bg-danger">Rejected</span>';

break;

default:

echo ucfirst($row['status']);

}

?>

</td>

<td>

<a
href="loan_detail.php?id=<?= $row['id'] ?>"
class="btn btn-primary btn-sm">

👁 Review

</a>

<?php if($row['status']=="funded"){ ?>

<a
href="disbursement.php?id=<?= $row['id'] ?>"
class="btn btn-success btn-sm">

💰 Cairkan

</a>

<?php } ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

</div>

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