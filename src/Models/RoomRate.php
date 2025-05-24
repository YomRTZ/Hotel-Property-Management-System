<?php
class RoomRate {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        return R::findAll('room_rate');
    }

    public function getById($id) {
        return R::load('room_rate', $id);
    }

    public function getByRoomTypeId($roomTypeId) {
        return R::find('room_rate', 'room_type_id = ?', [$roomTypeId]);
    }

    public function save($data) {
        $roomRate = $data['id'] ? R::load('room_rate', $data['id']) : R::dispense('room_rate');
        $roomRate->season = $data['season'];
        $roomRate->rate_description = $data['rate_description'];
        $roomRate->room_type_id = $data['room_type_id'];
        $roomRate->rate = $data['rate'];
        $roomRate->is_default = isset($data['is_default']);
        $roomRate->currency_code = $data['currency_code'];
        $roomRate->board_price_id = $data['board_price_id'] ?? null;
        $roomRate->price_tag = $data['price_tag'];
        $roomRate->remark = $data['remark'] ?? null;
        return R::store($roomRate);
    }

    public function delete($id) {
        $roomRate = R::load('room_rate', $id);
        if ($roomRate->id) {
            R::trash($roomRate);
            return true;
        }
        return false;
    }
}