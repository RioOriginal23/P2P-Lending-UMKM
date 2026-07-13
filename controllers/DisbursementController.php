<?php

require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/Loan.php';
require_once __DIR__.'/../models/Wallet.php';
require_once __DIR__.'/../models/Installment.php';

class DisbursementController
{

    private $db;
    private $loan;
    private $wallet;
    private $installment;

    public function __construct()
    {

        $this->db=(new Database())->connect();

        $this->loan=new Loan($this->db);

        $this->wallet=new Wallet($this->db);

        $this->installment=new Installment($this->db);

    }

    public function process($loan_id)
    {

        $loan=$this->loan->getById($loan_id);

        if($loan['status']!="funded"){

            return "Proposal belum funded.";

        }

        try{

            $this->db->beginTransaction();

            // tambah saldo borrower
            $this->wallet->addBalance(

                $loan['borrower_id'],

                $loan['amount']

            );

            // ubah status pinjaman
            $this->loan->updateStatus(

                $loan_id,

                "active"

            );

            // transaksi pencairan
            $wallet=$this->wallet->getByUser($loan['borrower_id']);

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

                    'disbursement',

                    'loan',

                    :loan,

                    :amount,

                    'success',

                    'Pencairan Dana Pinjaman'

                )

            ");

            $stmt->execute([

                ':wallet'=>$wallet['id'],

                ':loan'=>$loan_id,

                ':amount'=>$loan['amount']

            ]);

            // buat cicilan
            $perbulan=$loan['amount']/$loan['duration_month'];

            $sisa=$loan['amount'];

            for($i=1;$i<=$loan['duration_month'];$i++){

                $sisa-=$perbulan;

                $this->installment->create([

                    'loan'=>$loan_id,

                    'number'=>$i,

                    'due'=>date("Y-m-d",strtotime("+".$i." month")),

                    'amount'=>$perbulan,

                    'remaining'=>$sisa

                ]);

            }

            $this->db->commit();

            return "Dana berhasil dicairkan.";

        }catch(Exception $e){

            $this->db->rollBack();

            return $e->getMessage();

        }

    }

}