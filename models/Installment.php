<?php

class Installment
{

    private $conn;

    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function create($data)
    {

        $sql="INSERT INTO installments

        (

            loan_application_id,

            installment_number,

            due_date,

            amount,

            remaining_balance,

            status

        )

        VALUES

        (

            :loan,

            :number,

            :due,

            :amount,

            :remaining,

            'unpaid'

        )";

        $stmt=$this->conn->prepare($sql);

        return $stmt->execute([

            ':loan'=>$data['loan'],

            ':number'=>$data['number'],

            ':due'=>$data['due'],

            ':amount'=>$data['amount'],

            ':remaining'=>$data['remaining']

        ]);


        
    }

    public function getByLoan($loan_id)
{
    $stmt=$this->conn->prepare("

        SELECT *

        FROM installments

        WHERE loan_application_id=:id

        ORDER BY installment_number ASC

    ");

    $stmt->execute([

        ':id'=>$loan_id

    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function getById($id)
{
    $stmt=$this->conn->prepare("

        SELECT *

        FROM installments

        WHERE id=:id

    ");

    $stmt->execute([

        ':id'=>$id

    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);

}

public function pay($id)
{
    $stmt=$this->conn->prepare("

        UPDATE installments

        SET

            status='paid',

            paid_date=CURDATE()

        WHERE id=:id

    ");

    return $stmt->execute([

        ':id'=>$id

    ]);

}

}