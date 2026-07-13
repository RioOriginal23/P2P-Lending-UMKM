<?php

require_once "../includes/session.php";
require_once "../controllers/InvestmentController.php";

if($_SESSION['role']!="investor"){
    header("Location: ../login.php");
    exit;
}

$controller=new InvestmentController();

$data=$controller->myInvestment($_SESSION['user_id']);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Riwayat Pendanaan</title>

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

💼 Riwayat Pendanaan Saya

</h2>

<div class="card shadow-sm">

<div class="card-header">

Daftar Investasi

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-primary">

<tr>

<th>ID</th>

<th>UMKM</th>

<th>Target Pinjaman</th>

<th>Dana Saya</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php if(count($data)>0){ ?>

<?php foreach($data as $row){ ?>

<tr>

<td>

<?= $row['id']; ?>

</td>

<td>

<?= $row['business_name']; ?>

</td>

<td>

Rp <?= number_format($row['target'],0,',','.') ?>

</td>

<td>

Rp <?= number_format($row['amount'],0,',','.') ?>

</td>

<td>

<?php

if($row['status']=="active"){

echo "<span class='badge bg-success'>Active</span>";

}elseif($row['status']=="finished"){

echo "<span class='badge bg-primary'>Finished</span>";

}else{

echo "<span class='badge bg-secondary'>".ucfirst($row['status'])."</span>";

}

?>

</td>

</tr>

<?php } ?>

<?php }else{ ?>

<tr>

<td colspan="5" class="text-center text-muted">

Belum ada riwayat pendanaan.

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