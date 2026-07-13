<?php

class Investment
{
    private $conn;
    private $table = "investments";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($data)
    {
        $sql = "INSERT INTO investments
                (
                    investor_id,
                    loan_application_id,
                    amount,
                    return_percentage,
                    status
                )
                VALUES
                (
                    :investor_id,
                    :loan_application_id,
                    :amount,
                    :return_percentage,
                    'active'
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([

            ':investor_id'=>$data['investor_id'],
            ':loan_application_id'=>$data['loan_application_id'],
            ':amount'=>$data['amount'],
            ':return_percentage'=>$data['return_percentage']

        ]);
    }

    // ===========================
// RIWAYAT INVESTASI
// ===========================

public function getByInvestor($investor_id)
{
    $sql = "SELECT
                investments.*,
                users.name,
                users.business_name,
                loan_applications.amount AS target,
                loan_applications.status
            FROM investments
            JOIN loan_applications
                ON loan_applications.id = investments.loan_application_id
            JOIN users
                ON users.id = loan_applications.borrower_id
            WHERE investments.investor_id = :id
            ORDER BY investments.id DESC";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':id' => $investor_id
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getByLoan($loan_id)
{
    $stmt=$this->conn->prepare("

        SELECT *

        FROM investments

        WHERE loan_application_id=:id

    ");

    $stmt->execute([

        ':id'=>$loan_id

    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

}