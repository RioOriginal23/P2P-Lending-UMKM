<?php

require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/Investment.php';
require_once __DIR__.'/../models/Wallet.php';
require_once __DIR__.'/../models/Loan.php';

class InvestmentController
{
    private $db;
    private $investment;
    private $wallet;
    private $loan;

    public function __construct()
    {
        $this->db=(new Database())->connect();

        $this->investment=new Investment($this->db);

        $this->wallet=new Wallet($this->db);

        $this->loan=new Loan($this->db);
    }

    public function funding($post,$investor_id)
    {

        $loan_id=$post['loan_application_id'];

        $amount=$post['amount'];

        $loan = $this->loan->getById($loan_id);

        if($loan['borrower_id'] == $investor_id){

    return [

        'success' => false,

        'message' => 'Anda tidak dapat mendanai proposal sendiri.'

    ];

}

$sisa = $loan['amount'] - $loan['funded_amount'];

if($amount > $sisa){

    return [

        'success'=>false,

        'message'=>'Jumlah pendanaan melebihi sisa kebutuhan dana.'

    ];

}

        $wallet=$this->wallet->getByUser($investor_id);

        if($wallet['balance']<$amount){

            return [

                'success'=>false,

                'message'=>'Saldo wallet tidak mencukupi.'

            ];

        }

        try{

            $this->db->beginTransaction();

            $this->investment->create([

                'investor_id'=>$investor_id,

                'loan_application_id'=>$loan_id,

                'amount'=>$amount,

                'return_percentage'=>10

            ]);

            $saldoBaru=$wallet['balance']-$amount;

            $this->wallet->updateBalance(

                $wallet['id'],

                $saldoBaru

            );

            $this->loan->addFunding(

                $loan_id,

                $amount

            );

            $stmt=$this->db->prepare("

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

                    :wallet,

                    'funding',

                    'investment',

                    :loan,

                    :amount,

                    'success',

                    'Pendanaan Proposal'

                )

            ");

            $stmt->execute([

                ':wallet'=>$wallet['id'],

                ':loan'=>$loan_id,

                ':amount'=>$amount

            ]);

            $this->db->commit();

            return [

                'success'=>true,

                'message'=>'Pendanaan berhasil.'

            ];

        }catch(Exception $e){

            $this->db->rollBack();

            return [

                'success'=>false,

                'message'=>$e->getMessage()

            ];

        }

    }
    public function myInvestment($investor_id)
{
    return $this->investment->getByInvestor($investor_id);
}


}