<?php

require_once "../includes/session.php";
require_once "../config/database.php";
require_once "../models/Installment.php";
require_once "../models/Wallet.php";
require_once "../models/Investment.php";
require_once "../models/Loan.php";

if($_SESSION['role']!="borrower"){
    header("Location: ../login.php");
    exit;
}

$db = (new Database())->connect();

$installment = new Installment($db);
$wallet = new Wallet($db);
$investment = new Investment($db);
$loan = new Loan($db);

$data = $installment->getById($_GET['id']);

if(!$data){
    die("Data cicilan tidak ditemukan.");
}

$userWallet = $wallet->getByUser($_SESSION['user_id']);

if(!$userWallet){
    die("Wallet tidak ditemukan.");
}

if($data['status']=="paid"){
    die("Cicilan sudah dibayar.");
}

if($userWallet['balance'] < $data['amount']){
    die("Saldo wallet tidak mencukupi.");
}

$db->beginTransaction();

try{

    // ==========================
    // Potong saldo borrower
    // ==========================
    $wallet->updateBalance(

        $userWallet['id'],

        $userWallet['balance'] - $data['amount']

    );

    // ==========================
    // Update status cicilan
    // ==========================
    $installment->pay($data['id']);

    // ==========================
    // Ambil data pinjaman
    // ==========================
    $loanData = $loan->getById($data['loan_application_id']);

    // ==========================
    // Ambil seluruh investor
    // ==========================
    $investments = $investment->getByLoan($data['loan_application_id']);

    foreach($investments as $inv){

        $walletInvestor = $wallet->getByUser($inv['investor_id']);

        if($walletInvestor){

            // Persentase investasi terhadap total pinjaman
            $persen = $inv['amount'] / $loanData['amount'];

            // Bagian cicilan investor
            $bagian = $data['amount'] * $persen;

            // Tambah saldo investor
            $wallet->addBalanceByWalletId(

                $walletInvestor['id'],

                $bagian

            );

        }

    }

    // ==========================
    // Catat transaksi
    // ==========================
    $stmt = $db->prepare("

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

            'installment',

            'installment',

            :ref,

            :amount,

            'success',

            'Pembayaran Cicilan'

        )

    ");

    $stmt->execute([

        ':wallet'=>$userWallet['id'],

        ':ref'=>$data['id'],

        ':amount'=>$data['amount']

    ]);

$db->commit();

header("Location: installments.php");
exit;

}catch(Exception $e){

    $db->rollBack();

    die($e->getMessage());

}