<?php
session_start();
require_once 'src/Models/Hotel.php';

class HotelController {
    private $model;

    public function __construct() {
        $this->model = new HotelModel();
    }

    public function index() {
        $hotels = $this->model->getAllHotels();
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once 'src/Views/hotel/index.php';
    }

    public function save() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log('POST Data: ' . print_r($_POST, true));

        $data = [
            'id' => $_POST['id'] ?? null,
            'name' => isset($_POST['name']) ? (string)$_POST['name'] : '',
            'grade' => isset($_POST['grade']) ? (string)$_POST['grade'] : '',
            'is_default' => isset($_POST['is_default']) ? (int)$_POST['is_default'] : 0,
            'remark' => isset($_POST['remark']) ? (string)$_POST['remark'] : ''
        ];
        error_log('Data to Save: ' . print_r($data, true));

        $this->model->saveHotel($data);
        header('Location: index.php');
        exit;
    }
}

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                if ($this->model->hasRoomTypes($id)) {
                    $_SESSION['error'] = "Cannot delete hotel because it is linked to room types.";
                } else {
                    $this->model->deleteHotel($id);
                }
            }
        }
        header('Location: index.php');
        exit;
    }

    public function close() {
        // header('Location: main.php'); 
        exit;
    }
}