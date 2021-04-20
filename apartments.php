<?php

ini_set('display_errors', true);

include "Db.php";

$db = new Db();
$apartments = $db->row("SELECT * from apartments WHERE HouseId=".$_REQUEST['house_id']);
$rooms = $db->row("SELECT * from rooms");

if(!empty($apartments)) {
    for ($i = 0; $i < count($apartments); $i++) {
        for($j = 0; $j < count($rooms); $j++){
            if ($apartments[$i]['RoomsCount'] == $rooms[$j]['Id']) {
                $apartments[$i]['RoomsCount'] = $rooms[$j]['RoomsCount'];
            }
        }
    }
}

?>

<div class="mt-3 ms-3">
    <a class="btn btn-primary" href="/"><--</a>
    <h1 class="mb-4"> Квартиры </h1>
    <div style="width: 40%">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Номер дома</th>
                <th scope="col">Этаж</th>
                <th scope="col">Площадь</th>
                <th scope="col">Цена</th>
                <th scope="col">Количество комнат</th>
                <th scope="col">План дома</th>
                <th scope="col">Номер квартиры</th>
                <th scope="col">Изменить</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i=0;$i<count($apartments);$i++){
                echo '<tr><th scope="row"><a style="text-decoration: none" href="/apartmentInfo.php?apartment_id='. $apartments[$i]['Id'] .'">'. $apartments[$i]['Id'] .'</a></th><td>'.
                    $apartments[$i]['HouseId'] .'</td><td>'.
                    $apartments[$i]['Floor'] .'</td><td>'.
                    $apartments[$i]['HouseSquare'] .'</td><td>'.
                    $apartments[$i]['Price'] .'</td><td>'.
                    $apartments[$i]['RoomsCount'] .'</td><td>'.
                    '<a style="text-decoration: none" href="/apartmentPlan.php?apartment_id='.$apartments[$i]['Id'] .'">&#128269;</a></td><td>'.
                    $apartments[$i]['ApartmentNumber'] .'</td>'.
                    '<td><a style="text-decoration: none" href="/editApartment.php?apartment_id='. $apartments[$i]['Id'] .'">&#9998;</a></td>'.
                    '<td><a style="text-decoration: none" href="/deleteApartment.php?apartment_id='. $apartments[$i]['Id'] .'">&#10060;</a></td></tr>';
            }
            ?>
            </tbody>
        </table>
        <div style="width: 15%;">
            <a href="/addApartment.php?house_id=<?php echo $_REQUEST['house_id']; ?>" class="btn btn-success"> Добавить </a>
        </div>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>
