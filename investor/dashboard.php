<?php

require_once "../includes/session.php";
require_once "../config/database.php";
require_once "../models/Wallet.php";
require_once "../models/Investment.php";

if($_SESSION['role']!="investor"){
    header("Location: ../login.php");
    exit;
}

$db=(new Database())->connect();

$wallet=new Wallet($db);
$investment=new Investment($db);

$userWallet=$wallet->getByUser($_SESSION['user_id']);

$investments=$investment->getByInvestor($_SESSION['user_id']);

$total=0;

foreach($investments as $row){

    $total += $row['amount'];

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard Investor</title>

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

<a href="../logout.php" class="btn btn-danger btn-sm">

Logout

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<h2 class="mb-4">

Dashboard Investor

</h2>

<div class="row">

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

💰 Saldo Wallet

</h6>

<h3>

Rp <?= number_format($userWallet['balance'],0,',','.') ?>

</h3>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

💵 Total Pendanaan

</h6>

<h3>

Rp <?= number_format($total,0,',','.') ?>

</h3>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

📈 Jumlah Investasi

</h6>

<h3>

<?= count($investments) ?>

</h3>

</div>

</div>

</div>

</div>

<div class="card shadow-sm mt-3">

<div class="card-header">

Menu Investor

</div>

<div class="card-body">

<div class="d-grid gap-2">

<a href="../profile.php" class="btn btn-outline-primary">

👤 Profil Saya

</a>

<a href="topup.php" class="btn btn-outline-warning">
    💳 Top Up Wallet
</a>

<a href="proposal_list.php" class="btn btn-outline-success">

📄 Proposal Pendanaan

</a>

<a href="my_investment.php" class="btn btn-outline-warning">

📊 Riwayat Pendanaan

</a>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>