<?php
use RedBeanPHP\R;

class RoomTypeModel {
    public function getAllRoomTypes() {
        return R::findAll('roomtype');
    }
    public function getRoomTypeById($id) {
        return R::load('roomtype', $id);
    }
 public function getAllHotels() {
        return array_values(R::findAll('hotel'));
    }

    public function saveRoomType($data) {
        $id = $data['id'] ?? null;
        $roomType = $id ? R::load('roomtype', $id) : R::dispense('roomtype');
        $roomType->hotel_id = $data['hotel_id'];
        $roomType->description = $data['description'];
        $roomType->account = $data['account'];
        $roomType->clip_or_picture = $data['clip_or_picture'];
        $roomType->remark = $data['remark'] ?? '';
        R::store($roomType);
        return $roomType;
    }
    public function deleteRoomType($id) {
        $roomType = R::load('roomtype', $id);
        if ($roomType->id) {
            R::trash($roomType);
            return true;
        }
        return false;
    }

    // Check if room type has associated rooms
    public function hasRooms($id) {
        $rooms = R::find('room', 'room_type_id = ?', [$id]);
        return count($rooms) > 0;
    }
}