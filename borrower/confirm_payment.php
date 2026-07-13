<?php

require_once "../includes/session.php";
require_once "../config/database.php";
require_once "../models/Installment.php";
require_once "../models/Wallet.php";

if($_SESSION['role']!="borrower"){
    header("Location: ../login.php");
    exit;
}

$db=(new Database())->connect();

$installment=new Installment($db);
$wallet=new Wallet($db);

if(!isset($_GET['id'])){
    die("Data tidak ditemukan.");
}

$data=$installment->getById($_GET['id']);

if(!$data){
    die("Data cicilan tidak ditemukan.");
}

$userWallet=$wallet->getByUser($_SESSION['user_id']);

$sisaSaldo=$userWallet['balance']-$data['amount'];

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Konfirmasi Pembayaran</title>

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
href="installments.php"
class="btn btn-outline-primary btn-sm">

Kembali

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

💳 Konfirmasi Pembayaran

</h4>

</div>

<div class="card-body">

<table class="table">

<tr>

<th>Nomor Cicilan</th>

<td><?= $data['installment_number'] ?></td>

</tr>

<tr>

<th>Jatuh Tempo</th>

<td><?= $data['due_date'] ?></td>

</tr>

<tr>

<th>Nominal Cicilan</th>

<td>

<b>

Rp <?= number_format($data['amount'],0,',','.') ?>

</b>

</td>

</tr>

<tr>

<th>Saldo Wallet</th>

<td>

Rp <?= number_format($userWallet['balance'],0,',','.') ?>

</td>

</tr>

<tr>

<th>Sisa Saldo</th>

<td>

<b class="<?= $sisaSaldo>=0?'text-success':'text-danger' ?>">

Rp <?= number_format($sisaSaldo,0,',','.') ?>

</b>

</td>

</tr>

</table>

<?php if($sisaSaldo<0){ ?>

<div class="alert alert-danger">

Saldo wallet tidak mencukupi untuk melakukan pembayaran.

</div>

<?php } ?>

<div class="d-flex justify-content-between">

<a
href="installments.php"
class="btn btn-secondary">

← Batal

</a>

<?php if($sisaSaldo>=0){ ?>

<a
href="pay_installment.php?id=<?= $data['id'] ?>"
class="btn btn-success">

✔ Bayar Sekarang

</a>

<?php } ?>

</div>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>