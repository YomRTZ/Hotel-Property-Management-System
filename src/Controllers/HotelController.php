<?php
require_once __DIR__ . '/../Models/Hotel.php';

class HotelController {
    private $model;

    public function __construct() {
        $this->model = new Hotel();
    }

    public function index() {
        $hotels = $this->model->getAll();
        require_once __DIR__ . '/../Views/hotel/index.php';
    }

    public function form($id = null) {
        $hotel = $id ? $this->model->getById($id) : null;
        require_once __DIR__ . '/../Views/hotel/form.php';
    }

    public function save() {
        $data = [
            'id' => $_POST['id'] ?? null,
            'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
            'grade' => filter_input(INPUT_POST, 'grade', FILTER_SANITIZE_NUMBER_INT),
            'isDefault' => isset($_POST['isDefault']) ? 1 : 0,
            'remark' => filter_input(INPUT_POST, 'remark', FILTER_SANITIZE_STRING)
        ];

        if ($this->model->save($data)) {
            header("Location: /frontoffice/public/index.php?controller=hotel&action=index");
        } else {
            throw new Exception("Failed to save hotel.");
        }
    }

    public function delete($id) {
        if ($this->model->delete($id)) {
            header("Location: /frontoffice/public/index.php?controller=hotel&action=index");
        } else {
            throw new Exception("Failed to delete hotel.");
        }
    }
}