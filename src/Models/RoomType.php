<?php
class RoomType {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        return R::findAll('room_type');
    }

    public function getById($id) {
        return R::load('room_type', $id);
    }

    public function getByHotelId($hotelId) {
        return R::find('room_type', 'hotel_id = ?', [$hotelId]);
    }

    public function save($data) {
        $roomType = $data['id'] ? R::load('room_type', $data['id']) : R::dispense('room_type');
        $roomType->hotel_id = $data['hotel_id'];
        $roomType->description = $data['description'];
        $roomType->clip_or_picture = $data['clip_or_picture'] ?? null;
        $roomType->remark = $data['remark'] ?? null;
        $roomType->account = $data['account'];
        return R::store($roomType);
    }

    public function delete($id) {
        $roomType = R::load('room_type', $id);
        if ($roomType->id) {
            R::trash($roomType);
            return true;
        }
        return false;
    }
}