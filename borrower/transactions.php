<?php

require_once "../includes/session.php";
require_once "../config/database.php";
require_once "../models/Wallet.php";
require_once "../models/Transaction.php";

$db=(new Database())->connect();

$wallet=new Wallet($db);

$transaction=new Transaction($db);

$userWallet=$wallet->getByUser($_SESSION['user_id']);

$data=[];

if($userWallet){

    $data=$transaction->getByWallet($userWallet['id']);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Riwayat Transaksi</title>

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

💰 Riwayat Transaksi

</h2>

<div class="card shadow-sm">

<div class="card-header">

Daftar Transaksi

</div>

<div class="card-body">

<?php if(count($data)==0){ ?>

<div class="alert alert-warning mb-0">

Belum ada transaksi.

</div>

<?php }else{ ?>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-primary">

<tr>

<th>Tanggal</th>

<th>Jenis</th>

<th>Jumlah</th>

<th>Status</th>

<th>Keterangan</th>

</tr>

</thead>

<tbody>

<?php foreach($data as $row){ ?>

<tr>

<td>

<?= $row['created_at'] ?>

</td>

<td>

<?= ucfirst($row['transaction_type']) ?>

</td>

<td>

Rp <?= number_format($row['amount'],0,',','.') ?>

</td>

<td>

<?php if($row['status']=="success"){ ?>

<span class="badge bg-success">

Success

</span>

<?php }else{ ?>

<span class="badge bg-danger">

Failed

</span>

<?php } ?>

</td>

<td>

<?= $row['description'] ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php } ?>

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