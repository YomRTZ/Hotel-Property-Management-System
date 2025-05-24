<?php
require_once __DIR__ . '/../Helpers/Database.php';

class Hotel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        return R::findAll('hotel');
    }

    public function getById($id) {
        return R::load('hotel', $id);
    }

    public function save($data) {
        $hotel = $data['id'] ? R::load('hotel', $data['id']) : R::dispense('hotel');
        $hotel->name = $data['name'];
        $hotel->grade = $data['grade'];
        $hotel->is_default = isset($data['is_default']);
        $hotel->remark = $data['remark'] ?? null;
        return R::store($hotel);
    }

    public function delete($id) {
        $hotel = R::load('hotel', $id);
        if ($hotel->id) {
            R::trash($hotel);
            return true;
        }
        return false;
    }
}