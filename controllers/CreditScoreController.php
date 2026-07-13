<?php

require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/CreditScore.php';
require_once __DIR__.'/../models/Loan.php';

class CreditScoreController
{

    private $credit;
    private $loan;

    public function __construct()
    {

        $db=(new Database())->connect();

        $this->credit=new CreditScore($db);

        $this->loan=new Loan($db);

    }

    public function process($post)
    {

        $income=$post['monthly_income'];

        $age=$post['business_age'];

        $debt=$post['debt_ratio'];

        // Rumus sederhana
        $score=0;

        if($income>=5000000)
            $score+=40;
        else
            $score+=20;

        if($age>=3)
            $score+=30;
        else
            $score+=10;

        if($debt<=30)
            $score+=30;
        else
            $score+=10;

        $data=[

            'loan_application_id'=>$post['loan_application_id'],
            'admin_id'=>$_SESSION['user_id'],
            'monthly_income'=>$income,
            'business_age'=>$age,
            'debt_ratio'=>$debt,
            'score'=>$score,
            'notes'=>$post['notes']

        ];
        if($this->credit->exists($post['loan_application_id'])){

    return "Proposal sudah pernah dinilai.";

}
        $this->credit->create($data);

        if($score>=70){

            $this->loan->updateStatus(

                $post['loan_application_id'],

                'approved'

            );

        }else{

            $this->loan->updateStatus(

                $post['loan_application_id'],

                'rejected'

            );

        }

        return $score;

    }

public function getResult($loan_id)
{
    return $this->credit->getByLoan($loan_id);
}

}