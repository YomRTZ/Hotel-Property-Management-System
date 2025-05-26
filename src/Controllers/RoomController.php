<?php
require_once __DIR__ . '/../Models/Room.php';
class RoomController {
    private $model;
    public function __construct() {
        $this->model = new Room();
    }
    public function index() {
        $rooms = $this->model->getAll() ?? [];
        $hotels = $this->model->getAllHotels();
        $roomTypes = $this->model->getAllRoomTypes() ?? [];
        $selectedHotelId = isset($_GET['hotel_id']) ? (int)$_GET['hotel_id'] : null;
        $selectedroomtypeId = isset($_GET['room_type_id']) ? (int)$_GET['room_type_id'] : null;
       $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        include __DIR__ . '/../Views/room/index.php';
    }


 public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log('POST Data: ' . print_r($_POST, true));

              $data = [
            'id' => $_POST['id'] ?? null,
            'room_type_id' => $_POST['room_type_id'],
            'room_number' => filter_input(INPUT_POST, 'room_number', FILTER_SANITIZE_STRING),
            'telephone_extension' => filter_input(INPUT_POST, 'telephone_extension', FILTER_SANITIZE_STRING),
            'room_specialization' => filter_input(INPUT_POST, 'room_specialization', FILTER_SANITIZE_STRING),
            'location' => filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING),
            'no_of_bed' => filter_input(INPUT_POST, 'no_of_bed', FILTER_SANITIZE_NUMBER_INT),
            'change_to' => filter_input(INPUT_POST, 'change_to', FILTER_SANITIZE_STRING)
        ];

        $this->model->save($data);
            header('Location: index.php?tab=room' . ($data['hotel_id'] ? '&hotel_id=' . $data['hotel_id'] : ''). ($data['room_type_id'] ? '&room_type_id=' . $data['room_type_id'] : ''));
            exit;
        }
    }



public function delete() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $this->model->deleteRoom($id);
        }
    }
    header('Location: index.php?tab=room'); 
    exit;
}

public function close() {
    header('Location: main.php');
    exit;
}
}