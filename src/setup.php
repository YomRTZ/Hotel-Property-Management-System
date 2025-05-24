<?php
require_once __DIR__ . '/src/Helpers/Database.php';

new Database(); // Initialize RedBeanPHP

// Hotel
$hotel = R::dispense('hotel');
$hotel->name = 'Central Hotel';
$hotel->is_default = true;
$hotel->grade = 4;
$hotel->remark = null;
$hotelId = R::store($hotel);

// CurrencyExchange
$currency = R::dispense('currency_exchange');
$currency->currency_code = '196_USD';
$currency->rate = 1.00;
R::store($currency);

$currency2 = R::dispense('currency_exchange');
$currency2->currency_code = '195_ETB';
$currency2->rate = 120.00;
R::store($currency2);

// RoomType
$roomType = R::dispense('room_type');
$roomType->hotel_id = $hotelId;
$roomType->description = 'Family Room';
$roomType->clip_or_picture = null;
$roomType->remark = null;
$roomType->account = '411-001';
$roomTypeId = R::store($roomType);

// Room
$room = R::dispense('room');
$room->room_number = '324';
$room->room_type_id = $roomTypeId;
$room->telephone_extension = '324';
$room->room_specialization = 'None';
$room->location = '3rd Floor';
$room->no_of_bed = 2;
$room->remark = null;
$room->change_to = 'Family Room';
R::store($room);

// BoardPrice
$boardPrice = R::dispense('board_price');
$boardPrice->board_type = 'Bed and Breakfast';
$boardPrice->room_type_id = $roomTypeId;
$boardPrice->amount = 5.00;
$boardPrice->currency_code = '196_USD';
$boardPrice->is_default = true;
$boardPrice->remark = null;
$boardPrice->account = '412-001';
$boardPriceId = R::store($boardPrice);

// RoomRate
$roomRate = R::dispense('room_rate');
$roomRate->season = '10_Normal Season';
$roomRate->rate_description = 'Normal Price';
$roomRate->room_type_id = $roomTypeId;
$roomRate->rate = 109.00;
$roomRate->is_default = true;
$roomRate->currency_code = '196_USD';
$roomRate->board_price_id = $boardPriceId;
$roomRate->price_tag = 'NONE';
R::store($roomRate);

echo "Database initialized and seeded with sample data!";
?>