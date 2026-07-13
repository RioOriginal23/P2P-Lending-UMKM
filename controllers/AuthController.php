<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $db;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
    }

    // ===========================
    // REGISTER
    // ===========================

    public function register($post)
    {

        $name = trim($post['name']);
        $email = trim($post['email']);
        $password = trim($post['password']);
        $role = trim($post['role']);
        $phone = trim($post['phone']);
        $address = trim($post['address']);
        $business_name = trim($post['business_name']);

        // Validasi
        if (
            empty($name) ||
            empty($email) ||
            empty($password) ||
            empty($role)
        ) {

            return [
                'success' => false,
                'message' => 'Semua field wajib diisi.'
            ];
        }

        // Email sudah ada?
        if ($this->user->emailExists($email)) {

            return [
                'success' => false,
                'message' => 'Email sudah digunakan.'
            ];
        }

        // Hash Password
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);

        $data = [

            'name'=>$name,
            'email'=>$email,
            'password'=>$hashPassword,
            'role'=>$role,
            'phone'=>$phone,
            'address'=>$address,
            'business_name'=>$business_name

        ];

        try {

            $this->db->beginTransaction();

            // Simpan user
            $this->user->register($data);

            // Ambil ID user
            $user = $this->user->getUserByEmail($email);

            // Buat wallet otomatis
            $stmt = $this->db->prepare("
                INSERT INTO wallets(user_id,balance)
                VALUES(:user_id,0)
            ");

            $stmt->execute([
                ':user_id'=>$user['id']
            ]);

            $this->db->commit();

            return [

                'success'=>true,
                'message'=>'Registrasi berhasil.'

            ];

        } catch(Exception $e){

            $this->db->rollBack();

            return [

                'success'=>false,
                'message'=>$e->getMessage()

            ];

        }

    }
// ===========================
// LOGIN
// ===========================

public function login($post)
{
    $email = trim($post['email']);
    $password = trim($post['password']);

    if (empty($email) || empty($password)) {

        return [
            'success' => false,
            'message' => 'Email dan Password wajib diisi.'
        ];
    }

    $user = $this->user->getUserByEmail($email);

    if (!$user) {

        return [
            'success' => false,
            'message' => 'Email tidak ditemukan.'
        ];
    }

    if (!$user['is_active']) {

        return [
            'success' => false,
            'message' => 'Akun tidak aktif.'
        ];
    }

    if (!password_verify($password, $user['password'])) {

        return [
            'success' => false,
            'message' => 'Password salah.'
        ];
    }

    session_start();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    return [
        'success' => true,
        'role' => $user['role']
    ];
}

}