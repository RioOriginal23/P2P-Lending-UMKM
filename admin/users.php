<?php

require_once "../includes/session.php";
require_once "../controllers/AdminController.php";

// Hanya Admin
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$admin = new AdminController();

// Tombol aktif/nonaktif
if(isset($_GET['id']) && isset($_GET['status'])){

    $admin->changeStatus($_GET['id'], $_GET['status']);

    header("Location: users.php");
    exit;

}

$users = $admin->getUsers();

?>

<!DOCTYPE html>

<html>

<head>

<title>Kelola Pengguna</title>

</head>

<body>

<h2>Kelola Pengguna</h2>

<table border="1" cellpadding="10">

<tr>

<th>ID</th>

<th>Nama</th>

<th>Email</th>

<th>Role</th>

<th>Status</th>

<th>Aksi</th>

</tr>

<?php foreach($users as $user): ?>

<tr>

<td><?= $user['id'] ?></td>

<td><?= htmlspecialchars($user['name']) ?></td>

<td><?= htmlspecialchars($user['email']) ?></td>

<td><?= ucfirst($user['role']) ?></td>

<td>

<?= $user['is_active'] ? "Aktif" : "Nonaktif"; ?>

</td>

<td>

<?php if($user['role'] != 'admin'): ?>

<?php if($user['is_active']): ?>

<a href="?id=<?= $user['id'] ?>&status=0">

Blokir

</a>

<?php else: ?>

<a href="?id=<?= $user['id'] ?>&status=1">

Aktifkan

</a>

<?php endif; ?>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</table>

<br>

<a href="dashboard.php">

Kembali Dashboard

</a>

</body>

</html>