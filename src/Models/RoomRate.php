<?php
use RedBeanPHP\R;
class RoomRate {
    public function getAll() {
        return R::findAll('roomrate');
    }

    public function getById($id) {
        return R::load('roomrate', $id);
    }

    public function getAllHotels() {
        return array_values(R::findAll('hotel'));
    }
    public function getAllRoomTypes() {
        return array_values(R::findAll('roomtype'));
    }

    public function save($data) {
        $id = $data['id'] ?? null;
        $roomrate = $data['id'] ? R::load('roomrate', $data['id']) : R::dispense('roomrate');
        $roomrate->tagtype = $data['tagtype'];
        $roomrate->rate = $data['rate'];
        $roomrate->currency = $data['currency'];
        $roomrate->isdefault = $data['isdefault'];
        $roomrate->pricetag = $data['pricetag'];
        $roomrate->description = $data['description'];
        $roomrate->room_type_id = $data['room_type_id'] ?? null;
        $roomrate->season = $data['season'] ?? null;
        return R::store($roomrate);
    }


    public function deleteRoomRate($id) {
        $roomrate = R::load('roomrate', $id);
        if ($roomrate->id) {
            R::trash($roomrate);
            return true;
        }
        return false;
    }
}