<?php

class Wallet
{
    private $conn;

    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function getByUser($user_id)
    {
        $stmt=$this->conn->prepare("

            SELECT *

            FROM wallets

            WHERE user_id=:id

        ");

        $stmt->execute([

            ':id'=>$user_id

        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function updateBalance($wallet_id,$balance)
    {

        $stmt=$this->conn->prepare("

            UPDATE wallets

            SET balance=:balance

            WHERE id=:id

        ");

        return $stmt->execute([

            ':balance'=>$balance,

            ':id'=>$wallet_id

        ]);

    }

    public function addBalance($user_id,$amount)
{
    $stmt=$this->conn->prepare("

        UPDATE wallets

        SET balance=balance+:amount

        WHERE user_id=:user

    ");

    return $stmt->execute([

        ':amount'=>$amount,

        ':user'=>$user_id

    ]);
}

public function addBalanceByWalletId($wallet_id,$amount)
{
    $stmt=$this->conn->prepare("

        UPDATE wallets

        SET balance=balance+:amount

        WHERE id=:id

    ");

    return $stmt->execute([

        ':amount'=>$amount,

        ':id'=>$wallet_id

    ]);

}

public function getByUserId($user_id)
{
    return $this->getByUser($user_id);
}

}