<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class ProfileController
{
    private $db;
    private $user;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->connect();

        $this->user = new User($this->db);
    }

    public function getProfile($id)
    {
        return $this->user->getUserById($id);
    }

    public function update($post)
    {
        return $this->user->updateProfile($post);
    }
}