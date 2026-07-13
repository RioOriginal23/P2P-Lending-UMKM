<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Loan.php';

class LoanController
{
    private $loan;

    public function __construct()
    {
        $db = (new Database())->connect();

        $this->loan = new Loan($db);
    }

    public function create($data)
    {
        return $this->loan->create($data);
    }

    public function myLoans($id)
    {
        return $this->loan->getByBorrower($id);
    }

    public function getAll()
{
    return $this->loan->getAll();
}

public function getById($id)
{
    return $this->loan->getById($id);
}

public function getApproved()
{
    return $this->loan->getApproved();
}

public function getActiveLoan($borrower_id)
{
    return $this->loan->getActiveByBorrower($borrower_id);
}

}