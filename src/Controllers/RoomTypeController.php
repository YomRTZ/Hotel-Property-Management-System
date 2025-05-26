<?php
require_once 'src/Models/RoomType.php';

class RoomTypeController {
    private $model;

    public function __construct() {
        $this->model = new RoomTypeModel();
    }

public function index() {
    $roomTypes = $this->model->getAllRoomTypes() ?? [];
    $hotels = $this->model->getAllHotels();
     $selectedHotelId = isset($_GET['hotel_id']) ? (int)$_GET['hotel_id'] : null;
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once 'src/Views/room_type/index.php';
}

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debug incoming POST data
            error_log('POST Data: ' . print_r($_POST, true));

            $data = [
                'id' => $_POST['id'] ?? null,
                'hotel_id' => isset($_POST['hotel_id']) ? (int)$_POST['hotel_id'] : 0,
                'description' => isset($_POST['description']) ? (string)$_POST['description'] : '',
                'account' => isset($_POST['account']) ? (string)$_POST['account'] : '',
                'clip_or_picture' => isset($_POST['clip_or_picture']) ? (string)$_POST['clip_or_picture'] : '',
                'remark' => isset($_POST['remark']) ? (string)$_POST['remark'] : ''
            ];

            // Debug data before saving
            error_log('Data to Save: ' . print_r($data, true));

            $this->model->saveRoomType($data);
            header('Location: index.php?tab=roomtype' . ($data['hotel_id'] ? '&hotel_id=' . $data['hotel_id'] : ''));
            exit;
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                if ($this->model->hasRooms($id)) {
                    $_SESSION['error'] = "Cannot delete room type because it is linked to rooms.";
                } else {
                    $this->model->deleteRoomType($id);
                }
            }
        }
        header('Location: index.php?tab=roomtype');
        exit;
    }

    public function close() {
        header('Location: main.php');
        exit;
    }
}