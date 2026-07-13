<?php

require_once "../includes/session.php";
require_once "../config/database.php";
require_once "../models/Loan.php";

if($_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit;
}

$db=(new Database())->connect();

$loan=new Loan($db);

$list=$loan->getAll();

// $total=count($list);
$totalProposal = count($list);

$pending=0;
$approved=0;
$funded=0;
$active=0;
$rejected=0;

foreach($list as $row){

    switch($row['status']){

        case 'pending':
            $pending++;
            break;

        case 'approved':
            $approved++;
            break;

        case 'funded':
            $funded++;
            break;

        case 'active':
            $active++;
            break;

        case 'rejected':
            $rejected++;
            break;
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard Admin</title>

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

Dashboard Admin

</h2>

<div class="row">

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

📄 Total Proposal

</h6>

<h3>

<?= $totalProposal ?>

</h3>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

🟡 Pending

</h6>

<h3>

<?= $pending ?>

</h3>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

🟢 Approved

</h6>

<h3>

<?= $approved ?>

</h3>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

💰 Funded

</h6>

<h3>

<?= $funded ?>

</h3>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

🚀 Active

</h6>

<h3>

<?= $active ?>

</h3>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6 class="text-muted">

❌ Rejected

</h6>

<h3>

<?= $rejected ?>

</h3>

</div>

</div>

</div>

</div>

<div class="card shadow-sm mt-3">

<div class="card-header">

Menu Admin

</div>

<div class="card-body">

<div class="d-grid gap-2">

<a href="../profile.php" class="btn btn-outline-primary">

👤 Profil Saya

</a>

<a href="loan_list.php" class="btn btn-outline-success">

📋 Review Proposal

</a>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>