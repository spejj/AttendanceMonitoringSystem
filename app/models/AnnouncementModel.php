<?php
require_once __DIR__ . '/../config/database.php';

class AnnouncementModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
}