<?php
require_once __DIR__ . '/../Models/Hotel.php';

class HotelController {
    private $model;

    public function __construct() {
        $this->model = new Hotel();
    }

    public function index() {
        $hotels = $this->model->getAll();
        include __DIR__ . '/../Views/hotel/index.php';
    }

    public function form($id = null) {
        $hotel = $id ? $this->model->getById($id) : null;
        include __DIR__ . '/../Views/hotel/form.php';
    }

    public function save() {
        $data = [
            'id' => $_POST['id'] ?? null,
            'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
            'grade' => filter_input(INPUT_POST, 'grade', FILTER_SANITIZE_NUMBER_INT),
            'is_default' => isset($_POST['is_default']),
            'remark' => filter_input(INPUT_POST, 'remark', FILTER_SANITIZE_STRING)
        ];

        $this->model->save($data);
        header("Location: index.php?controller=hotel&action=index");
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?controller=hotel&action=index");
    }
}