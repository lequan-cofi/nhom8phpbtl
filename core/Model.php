<?php
class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    protected function query($sql, $params = []) {
        return $this->db->query($sql, $params);
    }

    protected function fetch($sql, $params = []) {
        return $this->db->fetch($sql, $params);
    }

    protected function fetchAll($sql, $params = []) {
        return $this->db->fetchAll($sql, $params);
    }

    protected function insert($table, $data) {
        return $this->db->insert($table, $data);
    }

    protected function update($table, $data, $where) {
        return $this->db->update($table, $data, $where);
    }

    protected function delete($table, $where) {
        return $this->db->delete($table, $where);
    }
} 