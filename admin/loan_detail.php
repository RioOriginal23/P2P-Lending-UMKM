<?php

require_once "../includes/session.php";
require_once "../controllers/LoanController.php";
require_once "../controllers/CreditScoreController.php";

if($_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit;
}

$loan=new LoanController();

$data=$loan->getById($_GET['id']);

$credit=new CreditScoreController();

$result=$credit->getResult($_GET['id']);

$message="";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $controller=new CreditScoreController();

    $score=$controller->process($_POST);

    $message="Credit Score = ".$score;

    $data=$loan->getById($_GET['id']);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Detail Proposal</title>

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
href="loan_list.php"
class="btn btn-outline-primary btn-sm">

Kembali

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<h2 class="mb-4">

📑 Detail Proposal Pinjaman

</h2>

<?php if($message!=""){ ?>

<div class="alert alert-success">

<?= $message ?>

</div>

<?php } ?>

<div class="row">

<div class="col-md-5">

<div class="card shadow-sm mb-4">

<div class="card-header">

👤 Data UMKM

</div>

<div class="card-body">

<table class="table table-borderless">

<tr>

<th>Nama</th>

<td><?= $data['name']; ?></td>

</tr>

<tr>

<th>Email</th>

<td><?= $data['email']; ?></td>

</tr>

<tr>

<th>No HP</th>

<td><?= $data['phone']; ?></td>

</tr>

<tr>

<th>Usaha</th>

<td><?= $data['business_name']; ?></td>

</tr>

<tr>

<th>Jumlah</th>

<td>

Rp <?= number_format($data['amount'],0,',','.') ?>

</td>

</tr>

<tr>

<th>Bunga</th>

<td>

<?= $data['interest_rate']; ?> %

</td>

</tr>

<tr>

<th>Tenor</th>

<td>

<?= $data['duration_month']; ?> Bulan

</td>

</tr>

<tr>

<th>Status</th>

<td>

<?php

switch($data['status']){

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

echo ucfirst($data['status']);

}

?>

</td>

</tr>

</table>

<hr>

<h6>

Tujuan Pinjaman

</h6>

<p>

<?= nl2br($data['purpose']); ?>

</p>

<h6>

Dokumen

</h6>

<p>

<?= $data['document']; ?>

</p>

</div>

</div>

</div>

<div class="col-md-7">

<?php if(!$result){ ?>

<div class="card shadow-sm">

<div class="card-header">

📊 Credit Scoring

</div>

<div class="card-body">

<form method="POST">

<input
type="hidden"
name="loan_application_id"
value="<?= $data['id'] ?>">

<div class="mb-3">

<label class="form-label">

Pendapatan per Bulan

</label>

<input
type="number"
name="monthly_income"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Lama Usaha (Tahun)

</label>

<input
type="number"
name="business_age"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Debt Ratio (%)

</label>

<input
type="number"
step="0.01"
name="debt_ratio"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Catatan

</label>

<textarea
name="notes"
rows="4"
class="form-control"></textarea>

</div>

<button
type="submit"
class="btn btn-success">

📈 Proses Credit Score

</button>

</form>

</div>

</div>

<?php }else{ ?>

<div class="card shadow-sm">

<div class="card-header">

✅ Hasil Credit Scoring

</div>

<div class="card-body">

<h2 class="text-success">

<?= $result['score']; ?>

</h2>

<p>

<?= nl2br($result['notes']); ?>

</p>

</div>

</div>

<?php } ?>

</div>

</div>

<div class="mt-3">

<a
href="loan_list.php"
class="btn btn-secondary">

← Kembali ke Review Proposal

</a>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>