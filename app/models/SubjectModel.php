<?php
require_once __DIR__ . '/../config/database.php';

class SubjectModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
}