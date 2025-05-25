<?php

require_once 'src/Helpers/Database.php';
use RedBeanPHP\R;
// Hotel table
$hotel = R::dispense('hotel');
$hotel->name = null;
$hotel->grade = null;
$hotel->is_default = null;
$hotel->remark = null;
R::store($hotel);

// Room Type table
try {
    $roomType = R::dispense('roomtype');
    $roomType->hotel_id = null;
    $roomType->description = null;
    $roomType->account = null;
    $roomType->clip_or_picture = null;
    R::store($roomType);
} catch (Exception $e) {
    die("Error creating roomtype: " . $e->getMessage());
}

// Room table
$room = R::dispense('room');
$room->room_number = null;
$room->room_type_id = null; 
$room->telephone_extension = null;
$room->location = null;
R::store($room);

// Board Price table
$boardPrice = R::dispense('boardprice');
$boardPrice->room_type_id = null; 
$boardPrice->board_type = null;
$boardPrice->amount = null;
$boardPrice->currency_code = null;
R::store($boardPrice);

// Room Rate table
$roomRate = R::dispense('roomrate');
$roomRate->room_type_id = null; 
$roomRate->season = null;
$roomRate->rate = null;
$roomRate->currency_code = null;
R::store($roomRate);

echo "Database 'FrontOffice' and tables created successfully!";
?>