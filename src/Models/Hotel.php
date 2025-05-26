<?php
use RedBeanPHP\R;

class HotelModel {
    // Get all hotels
    public function getAllHotels() {
        return array_values(R::findAll('hotel'));
    }

    // Get a hotel by ID
    public function getHotelById($id) {
        return R::load('hotel', $id);
    }

    // Save a hotel (create or update)
public function saveHotel($data) {
    $id = $data['id'] ?? null;
    $hotel = $id ? R::load('hotel', $id) : R::dispense('hotel');

    $hotel->name = $data['name'] ?? '';
    $hotel->grade = $data['grade'] ?? '';
    $hotel->is_default = isset($data['is_default']) ? (int)$data['is_default'] : 0;
    $hotel->remark = $data['remark'] ?? '';

    R::store($hotel);
    return $hotel;
}


    // Delete a hotel
    public function deleteHotel($id) {
        $hotel = R::load('hotel', $id);
        if ($hotel->id) {
            R::trash($hotel);
            return true;
        }
        return false;
    }

    // Check if hotel has associated room types
    public function hasRoomTypes($id) {
        $roomTypes = R::find('roomtype', 'hotel_id = ?', [$id]);
        return count($roomTypes) > 0;
    }
}