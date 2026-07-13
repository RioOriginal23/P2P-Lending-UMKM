<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Wallet.php";
require_once __DIR__ . "/../models/Transaction.php";

class WalletController
{
    private $db;
    private $wallet;
    private $transaction;

    public function __construct()
    {
        $this->db = (new Database())->connect();

        $this->wallet = new Wallet($this->db);
        $this->transaction = new Transaction($this->db);
    }

    public function topup($user_id, $amount)
    {
        if($amount <= 0){

            return [

                'success'=>false,

                'message'=>'Nominal Top Up tidak valid.'

            ];

        }

        $wallet = $this->wallet->getByUser($user_id);

        if(!$wallet){

            return [

                'success'=>false,

                'message'=>'Wallet tidak ditemukan.'

            ];

        }

        $this->db->beginTransaction();

        try{

            $saldoBaru = $wallet['balance'] + $amount;

            $this->wallet->updateBalance(

                $wallet['id'],

                $saldoBaru

            );

            $this->transaction->create([

                'wallet_id'=>$wallet['id'],

                'transaction_type'=>'topup',

                'reference_type'=>'wallet',

                'reference_id'=>$wallet['id'],

                'amount'=>$amount,

                'status'=>'success',

                'description'=>'Top Up Wallet'

            ]);

            $this->db->commit();

            return [

                'success'=>true,

                'message'=>'Top Up berhasil.'

            ];

        }catch(Exception $e){

            $this->db->rollBack();

            return [

                'success'=>false,

                'message'=>$e->getMessage()

            ];

        }

    }

}