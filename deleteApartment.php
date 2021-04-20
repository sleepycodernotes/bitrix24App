<?php

include "Db.php";

$db = new Db();
$query = "SELECT * FROM apartments WHERE id=".$_REQUEST['apartment_id'];
$apartment = $db->row($query);
$houseId = $apartment[0]['HouseId'];
$query = "DELETE FROM apartments WHERE id=".$_REQUEST['apartment_id'];
$db->query($query);

Header("Location:apartments.php?house_id=".$houseId);
die;