<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AdminController
{
    private $db;
    private $user;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();

        $this->user = new User($this->db);
    }

    public function getUsers()
    {
        return $this->user->getAllUsers();
    }

    public function changeStatus($id, $status)
    {
        return $this->user->updateStatus($id, $status);
    }
}