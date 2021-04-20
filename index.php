<?php

include "Db.php";

$db = new Db();

$houses = $db->row("SELECT * from houses");
$districts = $db->row("SELECT * FROM districts");
$housesType = $db->row("SELECT * FROM housesTypes");

if(!empty($houses)) {
    for ($i = 0; $i < count($houses); $i++) {
        for ($j = 0; $j < count($districts); $j++) {
            if ($houses[$i]['District'] == $districts[$j]['Id']) {
                $houses[$i]['District'] = $districts[$j]['DistrictName'];
            }
        }
        for ($k = 0; $k < count($housesType); $k++) {
            if ($houses[$i]['HouseType'] == $housesType[$k]['Id']) {
                $houses[$i]['HouseType'] = $housesType[$k]['TypeName'];
            }
        }
    }
}

require_once (__DIR__.'/crest.php');


$result = CRest::call('profile');

$deal = CRest::call('placement.bind',[
    'PLACEMENT' => 'CRM_DEAL_DETAIL_TAB',
    'HANDLER' => 'https://first.ivserv1.tmweb.ru/dealTab.php',
    'TITLE' => 'Квартиры',
]);

/*
echo '<pre>';
	print_r($deal);
echo '</pre>';
*/

?>

<div class="mt-3 ms-3">
    <h1 class="mb-4"> Дома </h1>
    <div style="width: 40%">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Район</th>
                <th scope="col">Год постройки</th>
                <th scope="col">Этажи</th>
                <th scope="col">Тип дома</th>
                <th scope="col">Изменить</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i=0;$i<count($houses);$i++){
                echo '<tr><th scope="row"><a style="text-decoration: none" href="/apartments.php?house_id='. $houses[$i]['Id'] .'">'. $houses[$i]['Id'] .'</a></th><td>'. $houses[$i]['District'] .'</td><td>'.
                    $houses[$i]['BuiltYear'] .'</td><td>'.
                    $houses[$i]['Floors'] .'</td><td>'.
                    $houses[$i]['HouseType'] .'</td>'.
                    '<td><a style="text-decoration: none" href="/editHouse.php?house_id='. $houses[$i]['Id'] .'">&#9998;</a></td>'.
                    '<td><a style="text-decoration: none" href="/deleteHouse.php?house_id='. $houses[$i]['Id'] .'">&#10060;</a></td></tr>';
            }
            ?>
            </tbody>
        </table>
        <div style="width: 15%;">
            <a href="/addHouse.php" class="btn btn-success"> Добавить </a>
        </div>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>


