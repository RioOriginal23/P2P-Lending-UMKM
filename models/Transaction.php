<?php

class Transaction
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByWallet($wallet_id)
    {
        $stmt=$this->conn->prepare("

            SELECT *

            FROM transactions

            WHERE wallet_id=:id

            ORDER BY created_at DESC

        ");

        $stmt->execute([

            ':id'=>$wallet_id

        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
{
    $stmt=$this->conn->prepare("

        INSERT INTO transactions
        (
            wallet_id,
            transaction_type,
            reference_type,
            reference_id,
            amount,
            status,
            description
        )
        VALUES
        (
            :wallet_id,
            :transaction_type,
            :reference_type,
            :reference_id,
            :amount,
            :status,
            :description
        )

    ");

    return $stmt->execute([

        ':wallet_id'=>$data['wallet_id'],
        ':transaction_type'=>$data['transaction_type'],
        ':reference_type'=>$data['reference_type'],
        ':reference_id'=>$data['reference_id'],
        ':amount'=>$data['amount'],
        ':status'=>$data['status'],
        ':description'=>$data['description']

    ]);
}
}