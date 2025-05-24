<?php
class Room {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        return R::findAll('room');
    }

    public function getById($id) {
        return R::load('room', $id);
    }

    public function getByRoomTypeId($roomTypeId) {
        return R::find('room', 'room_type_id = ?', [$roomTypeId]);
    }

    public function save($data) {
        $room = $data['id'] ? R::load('room', $data['id']) : R::dispense('room');
        $room->room_number = $data['room_number'];
        $room->room_type_id = $data['room_type_id'];
        $room->telephone_extension = $data['telephone_extension'];
        $room->room_specialization = $data['room_specialization'];
        $room->location = $data['location'];
        $room->no_of_bed = $data['no_of_bed'];
        $room->remark = $data['remark'] ?? null;
        $room->change_to = $data['change_to'];
        return R::store($room);
    }

    public function delete($id) {
        $room = R::load('room', $id);
        if ($room->id) {
            R::trash($room);
            return true;
        }
        return false;
    }
}