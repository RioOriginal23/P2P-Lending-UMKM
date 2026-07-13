<?php

require_once "config/database.php";

$db = (new Database())->connect();

$password = password_hash("admin123", PASSWORD_BCRYPT);

$stmt = $db->prepare("
UPDATE users
SET password = :password
WHERE email = 'admin@p2plending.com'
");

$stmt->execute([
    ':password' => $password
]);

echo "Password admin berhasil diperbarui.";