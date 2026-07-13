<?php

require_once "../includes/session.php";
require_once "../controllers/WalletController.php";
require_once "../config/database.php";
require_once "../models/Wallet.php";

if($_SESSION['role']!="investor"){
    header("Location: ../login.php");
    exit;
}

$db=(new Database())->connect();

$wallet=new Wallet($db);

$userWallet=$wallet->getByUser($_SESSION['user_id']);

$message="";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $controller=new WalletController();

    $result=$controller->topup(

        $_SESSION['user_id'],

        $_POST['amount']

    );

    $message=$result['message'];

    $userWallet=$wallet->getByUser($_SESSION['user_id']);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Top Up Wallet</title>

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

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

💳 Top Up Wallet

</h4>

</div>

<div class="card-body">

<?php if($message!=""){ ?>

<div class="alert alert-success">

<?= $message ?>

</div>

<?php } ?>

<h5>

Saldo Saat Ini

</h5>

<h2 class="text-primary mb-4">

Rp <?= number_format($userWallet['balance'],0,',','.') ?>

</h2>

<form method="POST">

<label class="form-label">

Nominal Top Up

</label>

<input
type="number"
name="amount"
class="form-control mb-3"
required>

<div class="mb-3">

<button
type="button"
class="btn btn-outline-secondary nominal"
data-value="100000">

100K

</button>

<button
type="button"
class="btn btn-outline-secondary nominal"
data-value="250000">

250K

</button>

<button
type="button"
class="btn btn-outline-secondary nominal"
data-value="500000">

500K

</button>

<button
type="button"
class="btn btn-outline-secondary nominal"
data-value="1000000">

1 Juta

</button>

</div>

<button
type="submit"
class="btn btn-success">

💰 Top Up Sekarang

</button>

<a
href="dashboard.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</div>

</div>

<script>

document.querySelectorAll(".nominal").forEach(function(btn){

    btn.onclick=function(){

        document.querySelector("input[name='amount']").value=this.dataset.value;

    }

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>