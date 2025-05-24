<?php
require_once __DIR__ . '/../Models/RoomType.php';
require_once __DIR__ . '/../Models/Hotel.php';

class RoomTypeController {
    private $model;
    private $hotelModel;

    public function __construct() {
        $this->model = new RoomType();
        $this->hotelModel = new Hotel();
    }

    public function index() {
        $hotels = $this->hotelModel->getAll();
        $selectedHotelId = $_GET['hotel_id'] ?? $hotels[1]->id;
        $roomTypes = $this->model->getByHotelId($selectedHotelId);
        include __DIR__ . '/../Views/room_type/index.php';
    }

    public function form($id = null) {
        $roomType = $id ? $this->model->getById($id) : null;
        $hotels = $this->hotelModel->getAll();
        include __DIR__ . '/../Views/room_type/form.php';
    }

    public function save() {
        $data = [
            'id' => $_POST['id'] ?? null,
            'hotel_id' => $_POST['hotel_id'],
            'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
            'clip_or_picture' => filter_input(INPUT_POST, 'clip_or_picture', FILTER_SANITIZE_STRING),
            'remark' => filter_input(INPUT_POST, 'remark', FILTER_SANITIZE_STRING),
            'account' => filter_input(INPUT_POST, 'account', FILTER_SANITIZE_STRING)
        ];

        $this->model->save($data);
        header("Location: index.php?controller=room_type&action=index&hotel_id=" . $data['hotel_id']);
    }

    public function delete($id) {
        $roomType = $this->model->getById($id);
        $hotelId = $roomType->hotel_id;
        $this->model->delete($id);
        header("Location: index.php?controller=room_type&action=index&hotel_id=" . $hotelId);
    }
}