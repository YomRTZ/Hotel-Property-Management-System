<?php
require_once __DIR__ . '/../Models/BoardPrice.php';
require_once __DIR__ . '/../Models/RoomType.php';
require_once __DIR__ . '/../Models/Hotel.php';
require_once __DIR__ . '/../Models/CurrencyExchange.php';

class BoardPriceController {
    private $model;
    private $roomTypeModel;
    private $hotelModel;
    private $currencyModel;

    public function __construct() {
        $this->model = new BoardPrice();
        $this->roomTypeModel = new RoomType();
        $this->hotelModel = new Hotel();
        $this->currencyModel = new CurrencyExchange();
    }

    public function index() {
        $hotels = $this->hotelModel->getAll();
        $selectedHotelId = $_GET['hotel_id'] ?? $hotels[1]->id;
        $roomTypes = $this->roomTypeModel->getByHotelId($selectedHotelId);
        $selectedRoomTypeId = $_GET['room_type_id'] ?? $roomTypes[1]->id;
        $boardPrices = $this->model->getByRoomTypeId($selectedRoomTypeId);
        include __DIR__ . '/../Views/board_price/index.php';
    }

    public function form($id = null) {
        $boardPrice = $id ? $this->model->getById($id) : null;
        $hotels = $this->hotelModel->getAll();
        $roomTypes = $this->roomTypeModel->getAll();
        $currencies = $this->currencyModel->getAll();
        include __DIR__ . '/../Views/board_price/form.php';
    }

    public function save() {
        $data = [
            'id' => $_POST['id'] ?? null,
            'room_type_id' => $_POST['room_type_id'],
            'board_type' => filter_input(INPUT_POST, 'board_type', FILTER_SANITIZE_STRING),
            'amount' => filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'currency_code' => filter_input(INPUT_POST, 'currency_code', FILTER_SANITIZE_STRING),
            'is_default' => isset($_POST['is_default']),
            'remark' => filter_input(INPUT_POST, 'remark', FILTER_SANITIZE_STRING),
            'account' => filter_input(INPUT_POST, 'account', FILTER_SANITIZE_STRING)
        ];

        $this->model->save($data);
        header("Location: index.php?controller=board_price&action=index&room_type_id=" . $data['room_type_id']);
    }

    public function delete($id) {
        $boardPrice = $this->model->getById($id);
        $roomTypeId = $boardPrice->room_type_id;
        $this->model->delete($id);
        header("Location: index.php?controller=board_price&action=index&room_type_id=" . $roomTypeId);
    }
}