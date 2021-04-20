<?php

ini_set('display_errors', true);

include "Db.php";
require_once (__DIR__.'/crest.php');

$db = new Db();
$query = "SELECT * FROM apartments";
$apartments = $db->row($query);

if(isset($_POST['addDeal'])){

    $appsId = $_POST['apDeal'];

    if(empty($appsId)){
        Header("Location:/dealTab.php");
        die;
    }

    $query = "SELECT * FROM apartments where id IN(";

    for($i=0;$i<count($appsId);$i++){
        if($i == count($appsId) - 1){
            $query = $query . $appsId[$i];
        }else{
            $query = $query . $appsId[$i] . ',';
        }
    }
    $query = $query . ')';

    $aps = $db->row($query);
    $max = $db->row("SELECT max(DealId) from apartments_deals");
    $insert_id = $max[0]['max(DealId)'];
    if($insert_id == NULL){
        $insert_id = 1;
    }else{
        $insert_id += 1;
    }

    $query = "INSERT INTO apartments_deals (ApartmentId, DealId) VALUES ";
    for($i=0;$i<count($appsId);$i++){
        if($i == count($appsId)-1){
            $query = $query . '(' . $aps[$i]['Id'] . ',' . $insert_id . ')';
        }else{
            $query = $query . '(' . $aps[$i]['Id'] . ',' . $insert_id . '),';
        }
    }
    $db->query($query);

    $info = "";
    for($i=0;$i<count($aps);$i++){
        $info = $info . "Id квартиры-" . $aps[$i]['Id'] .
                        " Этаж-" . $aps[$i]['Floor'] .
                        " Площадь-" . $aps[$i]['HouseSquare'] .
                        " Количество комнат" . $aps[$i]['RoomsCount'] .
                        " Цена-" . $aps[$i]['Price'] .
                        " Номер квартиры " . $aps[$i]['Floor'] . '<br>';
    }

    $resultDeal = CRest::call('crm.deal.add', [
            'fields' => [
                    'TITLE' => 'Квартиры',
                    'ADDITIONAL_INFO' => $info
            ]
    ]);

}

if(isset($_POST['filter'])){
    $query = "SELECT apartments.Id, apartments.Floor, apartments.HouseSquare, apartments.Price, apartments.RoomsCount, apartments.ApartmentNumber FROM apartments INNER JOIN houses ON apartments.HouseId=houses.Id ";
    if(!empty($_POST['District'])){
        if($_POST['District'] != 9)
            $query = $query . "and houses.District=".$_POST['District']." ";
    }
    if(!empty($_POST['BuiltYearMin'])){
        $query = $query . "and houses.BuiltYear >=".$_POST['BuiltYearMin']." ";
    }
    if(!empty($_POST['BuiltYearMax'])){
        $query = $query . "and houses.BuiltYear <=".$_POST['BuiltYearMax']." ";
    }
    if(!empty($_POST['HouseType'])){
        if($_POST['HouseType'] != 6)
            $query = $query . "and houses.HouseType=".$_POST['HouseType']." ";
    }
    if(!empty($_POST['HouseSquareMin'])){
        $query = $query . "and apartments.HouseSquare >=".$_POST['HouseSquareMin']." ";
    }
    if(!empty($_POST['HouseSquareMax'])){
        $query = $query . "and apartments.HouseSquare <=".$_POST['HouseSquareMax']." ";
    }
    if(!empty($_POST['PriceMin'])){
        $query = $query . "and apartments.Price >=".$_POST['PriceMin']." ";
    }
    if(!empty($_POST['PriceMax'])){
        $query = $query . "and apartments.Price <=".$_POST['PriceMax']." ";
    }
    if(!empty($_POST['RoomsCount'])){
        if($_POST['RoomsCount'] != 5)
            $query = $query . "and apartments.RoomsCount=".$_POST['RoomsCount'];
    }

    $apartments = $db->row($query);
}

?>

<div class="mt-3 ms-3">
    <form action="" method="post">
    <h1> Квартиры </h1>
    <div class="mt-3">
        <div style="width: 40%">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Номер квартиры</th>
                    <th scope="col">Номер дома</th>
                    <th scope="col">Этаж</th>
                    <th scope="col">Площадь</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Количество комнат</th>
                    <th scope="col">Номер квартиры</th>
                    <th scope="col">Сделка</th>
                </tr>
                </thead>
                <tbody>
                <?php
                for($i=0;$i<count($apartments);$i++){
                    echo '<tr><th scope="row"><a style="text-decoration: none" href="/apartmentInfo.php?apartment_id='. $apartments[$i]['Id'] .'&deal=1">'. $apartments[$i]['Id'] .'</a></th><td>'.
                        $apartments[$i]['HouseId'] .'</td><td>'.
                        $apartments[$i]['Floor'] .'</td><td>'.
                        $apartments[$i]['HouseSquare'] .'</td><td>'.
                        $apartments[$i]['Price'] .'</td><td>'.
                        $apartments[$i]['RoomsCount'] .'</td><td>'.
                        $apartments[$i]['ApartmentNumber'] .'</td><td>'.
                        '<input class="form-check-input" type="checkbox" name="apDeal[]" value="'. $apartments[$i]['Id'] .'"></td></tr>';
                }
                ?>
                </tbody>
            </table>
            <div class="mt-3">
                <button type="submit" name="addDeal" class="btn btn-success"> Добавить в сделку </button>
            </div>
    </form>
    </div>
    <div style="width: 20%">
        <h1> Фильтр </h1>
        <form action="" method="post">
            <div class="form-group">
                <label for=""> Район </label>
                <select class="mt-2 form-select" name="District" aria-label="District">
                    <option value="1"> Тракторозаводский </option>
                    <option value="2"> Краснооктябрьский </option>
                    <option value="3"> Дзержинский </option>
                    <option value="4"> Центральный </option>
                    <option value="5"> Ворошиловский </option>
                    <option value="6"> Советский </option>
                    <option value="7"> Кировский </option>
                    <option value="8"> Красноармейский </option>
                    <option value="9" selected> Любой </option>
                </select>
            </div>
            <div class="mt-3 form-group">
                <label for="inputBuiltYear"> Год постройки </label>
                <div class="d-flex flex-row">
                    <label for="">От:<input type="text" name="BuiltYearMin" class="mt-2 form-control" id="inputBuiltYearMin" minlength="4" maxlength="4"></label>
                    <label class="ms-3" for="">До:<input type="text" name="BuiltYearMax" class="mt-2 form-control" id="inputBuiltYearMax" minlength="4" maxlength="4"></label>
                </div>
                <div class="invalid-feedback"> Введите год постройки </div>
            </div>
            <div class="mt-3 form-group">
                <label for=""> Тип дома </label>
                <select class="mt-2 form-select" name="HouseType" aria-label="HouseType">
                    <option value="1"> Дом из блока </option>
                    <option value="2"> Дом из панели </option>
                    <option value="3">  Монолитный дом </option>
                    <option value="4"> Кирпичный дом </option>
                    <option value="5"> Другой </option>
                    <option value="6" selected> Любой </option>
                </select>
            </div>
            <div class="mt-3 form-group">
                <label for="inputHouseSquare"> Площадь квартиры </label>
                <div class="d-flex flex-row">
                    <label for="">От:<input type="number" step="0.01" name="HouseSquareMin" class="mt-2 form-control" id="inputHouseSquareMin" min="1" ></label>
                    <label class="ms-3" for="">До:<input type="number" step="0.01" name="HouseSquareMax" class="mt-2 form-control" id="inputHouseSquareMax" min="1" ></label>
                </div>
                <div class="invalid-feedback"> Введите площадь квартиры </div>
            </div>
            <div class="mt-3 form-group">
                <label for="inputPrice"> Цена </label>
                <div class="d-flex flex-row">
                    <label for="">От:<input type="number" name="PriceMin" class="mt-2 form-control" id="inputPriceMin" min="1" ></label>
                    <label class="ms-3" for="">До:<input type="number" name="PriceMax" class="mt-2 form-control" id="inputPriceMax" min="1" ></label>
                </div>
                <div class="invalid-feedback"> Введите цену </div>
            </div>
            <div class="mt-3 form-group">
                <label for=""> Количество комнат </label>
                <select class="mt-2 form-select" name="RoomsCount" aria-label="HouseType">
                    <option value="1"> 1-2 </option>
                    <option value="2"> 3-4 </option>
                    <option value="3">  5-6 </option>
                    <option value="4"> Другой </option>
                    <option value="5" selected> Любой </option>
                </select>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" name="filter" class="btn btn-primary"> Применить </button>
            </div>
        </form>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>
