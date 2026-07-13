<?php

class CreditScore
{
    private $conn;
    private $table="credit_scores";

    public function __construct($db)
    {
        $this->conn=$db;
    }

    public function create($data)
    {

        $sql="INSERT INTO {$this->table}

        (
            loan_application_id,
            admin_id,
            monthly_income,
            business_age,
            debt_ratio,
            score,
            notes

        )

        VALUES

        (

            :loan_application_id,
            :admin_id,
            :monthly_income,
            :business_age,
            :debt_ratio,
            :score,
            :notes

        )";

        $stmt=$this->conn->prepare($sql);

        return $stmt->execute([

            ':loan_application_id'=>$data['loan_application_id'],
            ':admin_id'=>$data['admin_id'],
            ':monthly_income'=>$data['monthly_income'],
            ':business_age'=>$data['business_age'],
            ':debt_ratio'=>$data['debt_ratio'],
            ':score'=>$data['score'],
            ':notes'=>$data['notes']

        ]);

    }
public function exists($loan_id)
{
    $sql="SELECT id
          FROM credit_scores
          WHERE loan_application_id=:id";

    $stmt=$this->conn->prepare($sql);

    $stmt->execute([
        ':id'=>$loan_id
    ]);

    return $stmt->rowCount()>0;
}

public function getByLoan($loan_id)
{
    $sql="SELECT *
          FROM credit_scores
          WHERE loan_application_id=:id
          LIMIT 1";

    $stmt=$this->conn->prepare($sql);

    $stmt->execute([
        ':id'=>$loan_id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}