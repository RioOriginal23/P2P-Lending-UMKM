<?php

require_once "../includes/session.php";
require_once "../controllers/LoanController.php";

if($_SESSION['role']!='borrower'){
    header("Location: ../login.php");
    exit;
}

$loan=new LoanController();

$message="";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $data=[

        'borrower_id'=>$_SESSION['user_id'],
        'amount'=>$_POST['amount'],
        'interest_rate'=>$_POST['interest_rate'],
        'duration_month'=>$_POST['duration_month'],
        'purpose'=>$_POST['purpose'],
        'document'=>$_POST['document']

    ];

    $loan->create($data);

    $message="Pengajuan pinjaman berhasil dikirim.";

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Ajukan Pinjaman</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

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

<a href="dashboard.php" class="btn btn-outline-primary btn-sm">

Dashboard

</a>

</div>

</div>

</nav>

<div class="container mt-4">

<div class="row justify-content-center">

<div class="col-lg-8">

<h2 class="mb-4">

📝 Ajukan Pinjaman

</h2>

<?php if($message!=""){ ?>

<div class="alert alert-success">

<?= $message ?>

</div>

<?php } ?>

<div class="card shadow-sm">

<div class="card-header">

Form Pengajuan Pinjaman

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label class="form-label">

Jumlah Pinjaman

</label>

<input
type="number"
name="amount"
class="form-control"
required>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Bunga (%)

</label>

<input
type="number"
step="0.01"
name="interest_rate"
value="10"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Tenor (Bulan)

</label>

<input
type="number"
name="duration_month"
class="form-control"
required>

</div>

</div>

<div class="mb-3">

<label class="form-label">

Tujuan Pinjaman

</label>

<textarea
name="purpose"
rows="4"
class="form-control"
required></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Dokumen Proposal

</label>

<input
type="text"
name="document"
class="form-control"
placeholder="proposal.pdf">

</div>

<div class="d-flex gap-2">

<button class="btn btn-primary">

📤 Ajukan Pinjaman

</button>

<a
href="my_loans.php"
class="btn btn-success">

📄 Pinjaman Saya

</a>

<a
href="dashboard.php"
class="btn btn-secondary">

← Dashboard

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>