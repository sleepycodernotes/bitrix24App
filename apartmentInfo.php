<?php

include "Db.php";

$db = new Db();
$query = "SELECT * FROM apartments where id=".$_REQUEST['apartment_id'];
$rooms = $db->row("SELECT * from rooms");
$apartment = $db->row($query);

for ($i = 0; $i < count($apartment); $i++) {
    for($j = 0; $j < count($rooms); $j++){
        if ($apartment[$i]['RoomsCount'] == $rooms[$j]['Id']) {
            $apartment[$i]['RoomsCount'] = $rooms[$j]['RoomsCount'];
        }
    }
}

?>

<div class="ms-3 mt-3">
    <?php if (empty($_REQUEST['deal'])) { ?>
        <a class="btn btn-primary" href="/apartments.php?house_id=<?php echo $apartment[0]['HouseId']; ?>"><--</a>
    <?php }else{ ?>
        <a class="btn btn-primary" href="/dealTab.php"><--</a>
    <?php } ?>
    <h1> Квартира </h1>

    <label for=""> Номер дома </label>
    <h3><?php echo $apartment[0]['HouseId']; ?></h3>
    <label for=""> Этаж </label>
    <h3><?php echo $apartment[0]['Floor']; ?></h3>
    <label for=""> Площадь квартиры </label>
    <h3><?php echo $apartment[0]['HouseSquare']; ?></h3>
    <label for=""> Количество комнат </label>
    <h3><?php echo $apartment[0]['RoomsCount']; ?></h3>
    <label for=""> Номер квартиры </label>
    <h3><?php echo $apartment[0]['ApartmentNumber']; ?></h3>
    <label for=""> План дома </label><br>
    <img src="data:image/jpeg;base64, <?php echo base64_encode($apartment[0]['PlaneImage']); ?>" alt="">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>