<?php
require_once __DIR__ . '/../Models/RoomRate.php';
class RoomRateController {
    private $model;
    public function __construct() {
        $this->model = new RoomRate();
    }
   public function index() {
    $roomRates = $this->model->getAll() ?? [];
    $hotels = $this->model->getAllHotels();
    $roomTypes = $this->model->getAllRoomTypes() ?? [];
    $selectedHotelId = isset($_GET['hotel_id']) ? (int)$_GET['hotel_id'] : null;
    $selectedRoomTypeId = isset($_GET['room_type_id']) ? (int)$_GET['room_type_id'] : null;
    $error = $_SESSION['error'] ?? null;
    unset($_SESSION['error']);
    include __DIR__ . '/../Views/room_rate/index.php';
}

public function save() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'id' => $_POST['id'] ?? null,
            'hotel_id' => $_POST['hotel_id'] ?? null,
            'room_type_id' => $_POST['room_type_id'] ?? null,
            'season_id' => $_POST['season_id'] ?? null,
            'board_type' => filter_input(INPUT_POST, 'board_type', FILTER_SANITIZE_STRING),
            'rate' => filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_STRING),
            'currency' => filter_input(INPUT_POST, 'currency', FILTER_SANITIZE_STRING),
            'isdefault' => filter_input(INPUT_POST, 'isdefault', FILTER_SANITIZE_STRING),
            'remark' => filter_input(INPUT_POST, 'remark', FILTER_SANITIZE_STRING),
            'account' => filter_input(INPUT_POST, 'account', FILTER_SANITIZE_STRING)
        ];

        $this->model->save($data);
        header('Location: index.php?tab=roomrate' . ($data['hotel_id'] ? '&hotel_id=' . $data['hotel_id'] : '') . ($data['room_type_id'] ? '&room_type_id=' . $data['room_type_id'] : ''));
        exit;
    }
}
public function delete() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $this->model->deleteRoomRate($id);
        }
    }
    header('Location: index.php?tab=roomrate'); 
    exit;
}

public function close() {
    header('Location: main.php');
    exit;
}
}