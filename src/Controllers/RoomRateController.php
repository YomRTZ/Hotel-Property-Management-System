<?php
require_once __DIR__ . '/../Models/RoomRate.php';
require_once __DIR__ . '/../Models/RoomType.php';
require_once __DIR__ . '/../Models/Hotel.php';
require_once __DIR__ . '/../Models/CurrencyExchange.php';
require_once __DIR__ . '/../Models/BoardPrice.php';

class RoomRateController {
    private $model;
    private $roomTypeModel;
    private $hotelModel;
    private $currencyModel;
    private $boardPriceModel;

    public function __construct() {
        $this->model = new RoomRate();
        $this->roomTypeModel = new RoomType();
        $this->hotelModel = new Hotel();
        $this->currencyModel = new CurrencyExchange();
        $this->boardPriceModel = new BoardPrice();
    }

    public function index() {
        $hotels = $this->hotelModel->getAll();
        $selectedHotelId = $_GET['hotel_id'] ?? $hotels[1]->id;
        $roomTypes = $this->roomTypeModel->getByHotelId($selectedHotelId);
        $selectedRoomTypeId = $_GET['room_type_id'] ?? $roomTypes[1]->id;
        $roomRates = $this->model->getByRoomTypeId($selectedRoomTypeId);
        include __DIR__ . '/../Views/room_rate/index.php';
    }

    public function form($id = null) {
        $roomRate = $id ? $this->model->getById($id) : null;
        $hotels = $this->hotelModel->getAll();
        $roomTypes = $this->roomTypeModel->getAll();
        $currencies = $this->currencyModel->getAll();
        $boardPrices = $this->boardPriceModel->getAll();
        include __DIR__ . '/../Views/room_rate/form.php';
    }

    public function save() {
        $data = [
            'id' => $_POST['id'] ?? null,
            'room_type_id' => $_POST['room_type_id'],
            'season' => filter_input(INPUT_POST, 'season', FILTER_SANITIZE_STRING),
            'rate_description' => filter_input(INPUT_POST, 'rate_description', FILTER_SANITIZE_STRING),
            'rate' => filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'is_default' => isset($_POST['is_default']),
            'currency_code' => filter_input(INPUT_POST, 'currency_code', FILTER_SANITIZE_STRING),
            'board_price_id' => $_POST['board_price_id'] ?? null,
            'price_tag' => filter_input(INPUT_POST, 'price_tag', FILTER_SANITIZE_STRING),
            'remark' => filter_input(INPUT_POST, 'remark', FILTER_SANITIZE_STRING)
        ];

        $this->model->save($data);
        header("Location: index.php?controller=room_rate&action=index&room_type_id=" . $data['room_type_id']);
    }

    public function delete($id) {
        $roomRate = $this->model->getById($id);
        $roomTypeId = $roomRate->room_type_id;
        $this->model->delete($id);
        header("Location: index.php?controller=room_rate&action=index&room_type_id=" . $roomTypeId);
    }
}