<?php
require_once __DIR__ . '/../config/database.php';

class ClassSectionModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
}