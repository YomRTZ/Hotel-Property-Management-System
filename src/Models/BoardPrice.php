<?php
class BoardPrice {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        return R::findAll('board_price');
    }

    public function getById($id) {
        return R::load('board_price', $id);
    }

    public function getByRoomTypeId($roomTypeId) {
        return R::find('board_price', 'room_type_id = ?', [$roomTypeId]);
    }

    public function save($data) {
        $boardPrice = $data['id'] ? R::load('board_price', $data['id']) : R::dispense('board_price');
        $boardPrice->board_type = $data['board_type'];
        $boardPrice->room_type_id = $data['room_type_id'];
        $boardPrice->amount = $data['amount'];
        $boardPrice->currency_code = $data['currency_code'];
        $boardPrice->is_default = isset($data['is_default']);
        $boardPrice->remark = $data['remark'] ?? null;
        $boardPrice->account = $data['account'];
        return R::store($boardPrice);
    }

    public function delete($id) {
        $boardPrice = R::load('board_price', $id);
        if ($boardPrice->id) {
            R::trash($boardPrice);
            return true;
        }
        return false;
    }
}