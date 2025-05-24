<?php
require_once __DIR__ . '/../Models/Room.php';
require_once __DIR__ . '/../Models/RoomType.php';
require_once __DIR__ . '/../Models/Hotel.php';

class RoomController {
    private $model;
    private $roomTypeModel;
    private $hotelModel;

    public function __construct() {
        $this->model = new Room();
        $this->roomTypeModel = new RoomType();
        $this->hotelModel = new Hotel();
    }

    public function index() {
        $hotels = $this->hotelModel->getAll();
        $selectedHotelId = $_GET['hotel_id'] ?? $hotels[1]->id;
        $roomTypes = $this->roomTypeModel->getByHotelId($selectedHotelId);
        $selectedRoomTypeId = $_GET['room_type_id'] ?? $roomTypes[1]->id;
        $rooms = $this->model->getByRoomTypeId($selectedRoomTypeId);
        include __DIR__ . '/../Views/room/index.php';
    }

    public function form($id = null) {
        $room = $id ? $this->model->getById($id) : null;
        $hotels = $this->hotelModel->getAll();
        $roomTypes = $this->roomTypeModel->getAll();
        include __DIR__ . '/../Views/room/form.php';
    }

    public function save() {
        $data = [
            'id' => $_POST['id'] ?? null,
            'room_type_id' => $_POST['room_type_id'],
            'room_number' => filter_input(INPUT_POST, 'room_number', FILTER_SANITIZE_STRING),
            'telephone_extension' => filter_input(INPUT_POST, 'telephone_extension', FILTER_SANITIZE_STRING),
            'room_specialization' => filter_input(INPUT_POST, 'room_specialization', FILTER_SANITIZE_STRING),
            'location' => filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING),
            'no_of_bed' => filter_input(INPUT_POST, 'no_of_bed', FILTER_SANITIZE_NUMBER_INT),
            'remark' => filter_input(INPUT_POST, 'remark', FILTER_SANITIZE_STRING),
            'change_to' => filter_input(INPUT_POST, 'change_to', FILTER_SANITIZE_STRING)
        ];

        $this->model->save($data);
        header("Location: index.php?controller=room&action=index&room_type_id=" . $data['room_type_id']);
    }

    public function delete($id) {
        $room = $this->model->getById($id);
        $roomTypeId = $room->room_type_id;
        $this->model->delete($id);
        header("Location: index.php?controller=room&action=index&room_type_id=" . $roomTypeId);
    }
}