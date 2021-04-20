<?php

include "Db.php";

$db = new Db();
$query = "DELETE FROM houses WHERE id=".$_REQUEST['house_id'];
$db->query($query);
$query = "DELETE FROM apartments WHERE HouseId=".$_REQUEST['house_id'];
$db->query($query);

Header("Location:/");
die;