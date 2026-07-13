<?php

class Loan
{
    private $conn;
    private $table = "loan_applications";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ===========================
    // CREATE LOAN
    // ===========================
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
        (
            borrower_id,
            amount,
            interest_rate,
            duration_month,
            purpose,
            document,
            status
        )
        VALUES
        (
            :borrower_id,
            :amount,
            :interest_rate,
            :duration_month,
            :purpose,
            :document,
            'pending'
        )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([

            ':borrower_id'    => $data['borrower_id'],
            ':amount'         => $data['amount'],
            ':interest_rate'  => $data['interest_rate'],
            ':duration_month' => $data['duration_month'],
            ':purpose'        => $data['purpose'],
            ':document'       => $data['document']

        ]);
    }

    // ===========================
    // PINJAMAN SAYA
    // ===========================
    public function getByBorrower($id)
    {
        $sql = "SELECT *
                FROM {$this->table}
                WHERE borrower_id = :id
                ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===========================
    // SEMUA PINJAMAN (ADMIN)
    // ===========================
    public function getAll()
    {
        $sql = "SELECT
                    loan_applications.*,
                    users.name,
                    users.business_name
                FROM loan_applications
                JOIN users
                    ON users.id = loan_applications.borrower_id
                ORDER BY loan_applications.id DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===========================
    // DETAIL PINJAMAN
    // ===========================
    public function getById($id)
    {
        $sql = "SELECT
                    loan_applications.*,
                    users.name,
                    users.business_name,
                    users.email,
                    users.phone
                FROM loan_applications
                JOIN users
                    ON users.id = loan_applications.borrower_id
                WHERE loan_applications.id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===========================
    // UPDATE STATUS
    // ===========================
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE loan_applications
                SET status = :status
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([

            ':status' => $status,
            ':id'     => $id

        ]);
    }

    // ===========================
    // TAMBAH DANA PENDANAAN
    // ===========================
    public function addFunding($loan_id, $amount)
    {
        $stmt = $this->conn->prepare("
            UPDATE loan_applications
            SET funded_amount = funded_amount + :amount
            WHERE id = :id
        ");

        $stmt->execute([

            ':amount' => $amount,
            ':id'     => $loan_id

        ]);

        $loan = $this->getById($loan_id);

        if ($loan['funded_amount'] >= $loan['amount']) {

            $this->updateStatus($loan_id, 'funded');

        }
    }

    // ===========================
    // PROPOSAL APPROVED
    // ===========================
    public function getApproved()
    {
        $sql = "SELECT
                    loan_applications.*,
                    users.name,
                    users.business_name
                FROM loan_applications
                JOIN users
                    ON users.id = loan_applications.borrower_id
                WHERE loan_applications.status = 'approved'
                ORDER BY loan_applications.id DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveByBorrower($borrower_id)
{
    $stmt=$this->conn->prepare("

        SELECT *

        FROM loan_applications

        WHERE borrower_id=:id

        AND status='active'

        LIMIT 1

    ");

    $stmt->execute([

        ':id'=>$borrower_id

    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);

}

}