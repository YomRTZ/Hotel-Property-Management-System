<?php
use RedBeanPHP\R;
class Room {
    public function getAll() {
        return R::findAll('room');
    }

    public function getById($id) {
        return R::load('room', $id);
    }

    public function getAllHotels() {
        return array_values(R::findAll('hotel'));
    }
    public function getAllRoomTypes() {
        return array_values(R::findAll('roomtype'));
    }

    public function save($data) {
        $id = $data['id'] ?? null;
        $room = $data['id'] ? R::load('room', $data['id']) : R::dispense('room');
        $room->room_number = $data['room_number'];
        $room->room_type_id = $data['room_type_id'];
        $room->telephone_extension = $data['telephone_extension'];
        $room->room_specialization = $data['room_specialization'];
        $room->location = $data['location'];
        $room->no_of_bed = $data['no_of_bed'];
        $room->change_to = $data['change_to'];
        return R::store($room);
    }


    public function deleteRoom($id) {
        $room = R::load('room', $id);
        if ($room->id) {
            R::trash($room);
            return true;
        }
        return false;
    }
}