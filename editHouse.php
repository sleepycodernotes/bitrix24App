<?php

include "Db.php";

$db = new Db();

$query = "SELECT * from houses WHERE id=". $_REQUEST['house_id'];
$house = $db->row($query);

if(empty($house)){
    echo "<h1> Данный дом не найден </h1>";
    die;
}

if(isset($_POST['editHouse'])){
    $district = (int)htmlspecialchars($_POST['District']);
    $builtYear = (int)htmlspecialchars($_POST['BuiltYear']);
    $floors = (int)htmlspecialchars($_POST['Floors']);
    $houseType = (int)htmlspecialchars($_POST['HouseType']);

    $query = "UPDATE houses SET District=$district, BuiltYear=$builtYear, Floors=$floors, HouseType=$houseType where id=".$_REQUEST['house_id'];
    $db->query($query);

    Header("Location:/");
    die;
}

?>

<div class="ms-3 mt-3" style="width: 15%;">
    <a href="/" class="btn btn-primary"><--</a>
    <h3 class="mb-3"> Изменение дома </h3>
    <form action="" method="post">
        <div class="form-group">
            <label for=""> Район </label>
            <select class="mt-2 form-select" name="District" aria-label="District">
                <option value="1" <?php if($house[0]['District'] == 1) echo 'selected'; ?>> Тракторозаводский </option>
                <option value="2" <?php if($house[0]['District'] == 2) echo 'selected'; ?>> Краснооктябрьский </option>
                <option value="3" <?php if($house[0]['District'] == 3) echo 'selected'; ?>> Дзержинский </option>
                <option value="4" <?php if($house[0]['District'] == 4) echo 'selected'; ?>> Центральный </option>
                <option value="5" <?php if($house[0]['District'] == 5) echo 'selected'; ?>> Ворошиловский </option>
                <option value="6" <?php if($house[0]['District'] == 6) echo 'selected'; ?>> Советский </option>
                <option value="7" <?php if($house[0]['District'] == 7) echo 'selected'; ?>> Кировский </option>
                <option value="8" <?php if($house[0]['District'] == 8) echo 'selected'; ?>> Красноармейский </option>
            </select>
        </div>
        <div class="mt-3 form-group">
            <label for="inputBuiltYear"> Год постройки </label>
            <input type="text" name="BuiltYear" class="mt-2 form-control" placeholder="<?php echo $house[0]['BuiltYear'] ?>" id="inputBuiltYear" minlength="4" maxlength="4" required>
            <div class="invalid-feedback"> Введите год постройки </div>
        </div>
        <div class="mt-3 form-group">
            <label for="inputFloors"> Количество этажей </label>
            <input type="number" name="Floors" class="mt-2 form-control" placeholder="<?php echo $house[0]['Floors'] ?>" id="inputFloors" min="1" required>
            <div class="invalid-feedback"> Введите количество этажей </div>
        </div>
        <div class="mt-3 form-group">
            <label for=""> Тип дома </label>
            <select class="mt-2 form-select" name="HouseType" aria-label="HouseType">
                <option value="1" <?php if($house[0]['HouseType'] == 1) echo 'selected'; ?>> Дом из блока </option>
                <option value="2" <?php if($house[0]['HouseType'] == 2) echo 'selected'; ?>> Дом из панели </option>
                <option value="3" <?php if($house[0]['HouseType'] == 3) echo 'selected'; ?>>  Монолитный дом </option>
                <option value="4" <?php if($house[0]['HouseType'] == 4) echo 'selected'; ?>> Кирпичный дом </option>
                <option value="5" <?php if($house[0]['HouseType'] == 5) echo 'selected'; ?>> Другой </option>
            </select>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" name="editHouse" class="btn btn-primary"> Изменить </button>
        </div>
    </form>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>
