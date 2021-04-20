<?php

include "Db.php";

$db = new Db();

if(isset($_POST['addHouse'])){
    $district = (int)htmlspecialchars($_POST['District']);
    $builtYear = (int)htmlspecialchars($_POST['BuiltYear']);
    $floors = (int)htmlspecialchars($_POST['Floors']);
    $houseType = (int)htmlspecialchars($_POST['HouseType']);

    $query = "INSERT INTO houses (District, BuiltYear, Floors, HouseType) VALUES ($district, $builtYear, $floors, $houseType)";
    $db->query($query);

    Header("Location: /");
    die;
}

?>

<div class="ms-3 mt-3" style="width: 20%;">
    <a href="/" class="btn btn-primary"><--</a>
    <h3 class="mb-3"> Добавление дома </h3>
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
            </select>
        </div>
        <div class="mt-3 form-group">
            <label for="inputBuiltYear"> Год постройки </label>
            <input type="text" name="BuiltYear" class="mt-2 form-control" id="inputBuiltYear" minlength="4" maxlength="4" required>
            <div class="invalid-feedback"> Введите год постройки </div>
        </div>
        <div class="mt-3 form-group">
            <label for="inputFloors"> Количество этажей </label>
            <input type="number" name="Floors" class="mt-2 form-control" id="inputFloors" min="1" required>
            <div class="invalid-feedback"> Введите количество этажей </div>
        </div>
        <div class="mt-3 form-group">
            <label for=""> Тип дома </label>
            <select class="mt-2 form-select" name="HouseType" aria-label="HouseType">
                <option value="1"> Дом из блока </option>
                <option value="2"> Дом из панели </option>
                <option value="3">  Монолитный дом </option>
                <option value="4"> Кирпичный дом </option>
                <option value="5"> Другой </option>
            </select>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" name="addHouse" class="btn btn-success"> Добавить </button>
        </div>
    </form>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>
