<?php

ini_set('display_errors', true);

include "Db.php";

$db = new Db();
$query = "SELECT * from houses where id=". $_REQUEST['house_id'];
$houseMaxFloors = $db->row($query);

if(empty($houseMaxFloors)){
    echo "<h1> Данный дом не найден </h1>";
    die;
}

if(isset($_POST['addApartment'])){
    $floor = (int)htmlspecialchars($_POST['Floor']);
    $houseSquare = (float)htmlspecialchars($_POST['HouseSquare']);
    $roomsCount = (int)htmlspecialchars($_POST['RoomsCount']);
    $price = (float)htmlspecialchars($_POST['Price']);
    $apartmentNumber = (int)htmlspecialchars($_POST['ApartmentNumber']);
    $apartmentPlane = addslashes(file_get_contents($_FILES['ApartmentPlane']['tmp_name']));

    $query = "INSERT INTO apartments (HouseId, Floor, HouseSquare, Price, RoomsCount, PlaneImage, ApartmentNumber) 
            VALUES (".$_REQUEST['house_id'].", $floor, $houseSquare, $price, $roomsCount, '$apartmentPlane', $apartmentNumber)";
    $db->query($query);

    Header("Location: apartments.php?house_id=".$_REQUEST['house_id']);
    die;
}

?>

<div class="ms-3 mt-3" style="width: 20%;">
    <a class="btn btn-primary" href="/apartments.php?house_id=<?php echo $_REQUEST['house_id']; ?>"><--</a>
    <h3 class="mb-3"> Добавление квартиры </h3>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mt-3 form-group">
            <label for="inputFloor"> Этаж </label>
            <input type="number" name="Floor" class="mt-2 form-control" id="inputFloor" min="1" max="<?php echo $houseMaxFloors[0]['Floors']; ?>" required>
            <div class="invalid-feedback"> Введите этаж </div>
        </div>
        <div class="mt-3 form-group">
            <label for="inputHouseSquare"> Площадь квартиры </label>
            <input type="number" step="0.01" name="HouseSquare" class="mt-2 form-control" id="inputHouseSquare" min="1" required>
            <div class="invalid-feedback"> Введите площадь квартиры </div>
        </div>
        <div class="mt-3 form-group">
            <label for="inputPrice"> Цена </label>
            <input type="number" name="Price" class="mt-2 form-control" id="inputPrice" min="1" required>
            <div class="invalid-feedback"> Введите цену </div>
        </div>
        <div class="mt-3 form-group">
            <label for=""> Количество комнат </label>
            <select class="mt-2 form-select" name="RoomsCount" aria-label="HouseType">
                <option value="1"> 1-2 </option>
                <option value="2"> 3-4 </option>
                <option value="3">  5-6 </option>
                <option value="4"> Другой </option>
            </select>
        </div>
        <div class="mt-3 form-group">
            <label for="inputApartmentNumber"> Номер квартиры </label>
            <input type="number" name="ApartmentNumber" class="mt-2 form-control" id="inputApartmentNumber" min="1" required>
            <div class="invalid-feedback"> Введите номер квартиры </div>
        </div>
        <div class="mt-3 form-group">
            <label for="inputApartmentPlane"> План дома </label>
            <input type="file" class="mt-2 form-control" name="ApartmentPlane" id="inputApartmentPlane" required>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" name="addApartment" class="btn btn-success"> Добавить </button>
        </div>
    </form>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>
