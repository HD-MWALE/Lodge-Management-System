<?php
ob_start();
date_default_timezone_set("Africa/Blantyre");

$action = $_GET['action'];

include './class/customer_class.php';
include './class/staff_class.php';
include './class/room_type_class.php';
include './class/room_class.php';
include './class/bookings_class.php';

$crud_Staff = new Staff_Action();
$crud_Customer = new Customer_Action();
$crud_Room_Type = new Room_Type_Action();
$crud_Room = new Room_Action();
$crud_Bookings = new Bookings_Action();

//
// Staff
//

if($action == 'login'){
	$login = $crud_Staff->login();
	if($login)
		echo $login;
}

if($action == 'logout'){
	$logout = $crud_Staff->logout();
	if($logout)
		echo $logout;
}

if($action == 'save_staff'){
	$save = $crud_Staff->save_staff();
	if($save)
		echo $save;
}

if($action == 'change_password'){
	$change = $crud_Staff->change_password_staff();
	if($change)
		echo $change;
}

if($action == 'delete_staff'){
	$delete = $crud_Staff->delete_staff();
	if($delete)
		echo $delete;
}

if($action == 'notification'){
	$notification = $crud_Staff->notify_staff();
	if($notification)
		echo $notification;
}
//-----------------------------------------------------------//

//
// Customer
//

if($action == 'customer_login'){
	$login = $crud_Customer ->login_customer();
	if($login)
		echo $login;
}

if($action == 'register_customer'){
	$register = $crud_Customer ->register_customer();
	if($register)
		echo $register;
}

if($action == 'save_customer'){
	$save = $crud_Customer ->save_customer();
	if($save)
		echo $save;
}

if($action == 'delete_customer'){
	$delete = $crud_Customer ->delete_customer();
	if($delete)
		echo $delete;
}

if($action == 'search_customer'){
	$search = $crud_Customer ->search_customer();
	if($search)
		echo $search;
}

//-----------------------------------------------------------//

//
// Room Type
//

if($action == 'update_room_type'){
	$update = $crud_Room_Type ->update_room_type();
	if($update)
		echo $update;
}

if($action == 'getprice'){
	$select = $crud_Room_Type ->select_price();
	if($select)
		echo $select;
}

//-----------------------------------------------------------//

//
// Room
//

if($action == 'save_room'){
	$save = $crud_Room ->save_room();
	if($save)
		echo $save;
}

if($action == 'getroom'){
	$select = $crud_Room ->select_room();
	if($select)
		echo $select;
}

if($action == 'delete_room'){
	$delete = $crud_Room ->delete_room();
	if($delete)
		echo $delete;
}

//-----------------------------------------------------------//

//
// Bookings
//

if($action == 'save_checkin'){
	$save = $crud_Bookings ->check_in();
	if($save)
		echo $save;
}

if($action == 'checkout'){
	$checkout = $crud_Bookings ->checkout();
	if($checkout)
		echo $checkout;
}

//-----------------------------------------------------------//

ob_end_flush();