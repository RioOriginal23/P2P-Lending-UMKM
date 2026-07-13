<?php

class User
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ===========================
    // REGISTER USER
    // ===========================
    public function register($data)
    {
        $sql = "INSERT INTO {$this->table}
                (name,email,password,role,phone,address,business_name,is_active)
                VALUES
                (:name,:email,:password,:role,:phone,:address,:business_name,1)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([

            ':name'=>$data['name'],
            ':email'=>$data['email'],
            ':password'=>$data['password'],
            ':role'=>$data['role'],
            ':phone'=>$data['phone'],
            ':address'=>$data['address'],
            ':business_name'=>$data['business_name']

        ]);
    }

    // ===========================
    // LOGIN
    // ===========================

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE email=:email
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':email',$email);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===========================
    // CHECK EMAIL
    // ===========================

    public function emailExists($email)
    {
        $sql = "SELECT id FROM {$this->table}
                WHERE email=:email";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':email',$email);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
// ===========================
// GET USER BY ID
// ===========================

public function getUserById($id)
{
    $sql = "SELECT * FROM {$this->table}
            WHERE id = :id
            LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ===========================
// UPDATE PROFILE
// ===========================

public function updateProfile($data)
{
    $sql = "UPDATE {$this->table}
            SET
                name=:name,
                phone=:phone,
                address=:address,
                business_name=:business_name,
                updated_at=NOW()
            WHERE id=:id";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([

        ':name'=>$data['name'],
        ':phone'=>$data['phone'],
        ':address'=>$data['address'],
        ':business_name'=>$data['business_name'],
        ':id'=>$data['id']

    ]);
}
// ===========================
// GET ALL USERS
// ===========================

public function getAllUsers()
{
    $sql = "SELECT * FROM {$this->table}
            ORDER BY id ASC";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ===========================
// UPDATE STATUS USER
// ===========================

public function updateStatus($id, $status)
{
    $sql = "UPDATE {$this->table}
            SET is_active=:status,
                updated_at=NOW()
            WHERE id=:id";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        ':status'=>$status,
        ':id'=>$id
    ]);
}

}