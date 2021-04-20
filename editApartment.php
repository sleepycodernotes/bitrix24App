<?php

ini_set('display_errors', true);

include "Db.php";

$db = new Db();

$query = "SELECT * FROM apartments WHERE id=". $_REQUEST['apartment_id'];
$apartment = $db->row($query);
$query = "SELECT * FROM houses WHERE id=".$apartment[0]['HouseId'];
$maxFloors = $db->row($query);
$apartment[0]['Floors'] = $maxFloors[0]['Floors'];

if(empty($apartment)){
    echo "<h1> Данная квартира не найдена</h1>";
    die;
}

if(isset($_POST['editApartment'])){
    $floor = (int)htmlspecialchars($_POST['Floor']);
    $houseSquare = (float)htmlspecialchars($_POST['HouseSquare']);
    $roomsCount = (int)htmlspecialchars($_POST['RoomsCount']);
    $price = (float)htmlspecialchars($_POST['Price']);
    $apartmentNumber = (int)htmlspecialchars($_POST['ApartmentNumber']);
    $apartmentPlane = addslashes(file_get_contents($_FILES['ApartmentPlane']['tmp_name']));

    $query = "UPDATE apartments SET Floor=$floor, HouseSquare=$houseSquare, Price=$price, RoomsCount=$roomsCount, PlaneImage='$apartmentPlane', ApartmentNumber=$apartmentNumber where id=".$_REQUEST['apartment_id'];
    $db->query($query);

    Header("Location:/apartments.php?house_id=".$apartment[0]['HouseId']);
    die;
}

?>

<div class="ms-3 mt-3" style="width: 20%;">
    <a class="btn btn-primary" href="/apartments.php?house_id=<?php echo $apartment[0]['HouseId']; ?>"><--</a>
    <h3 class="mb-3"> Изменение квартиры </h3>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mt-3 form-group">
            <label for="inputFloor"> Этаж </label>
            <input type="number" name="Floor" class="mt-2 form-control" id="inputFloor" placeholder="<?php echo $apartment[0]['Floor'] ?>" min="1" max="<?php echo $apartment[0]['Floors']; ?>" required>
            <div class="invalid-feedback"> Введите этаж </div>
        </div>
        <div class="mt-3 form-group">
            <label for="inputHouseSquare"> Площадь квартиры </label>
            <input type="number" step="0.01" name="HouseSquare" class="mt-2 form-control" placeholder="<?php echo $apartment[0]['HouseSquare'] ?>" id="inputHouseSquare" min="1" required>
            <div class="invalid-feedback"> Введите площадь квартиры </div>
        </div>
        <div class="mt-3 form-group">
            <label for="inputPrice"> Цена </label>
            <input type="number" name="Price" class="mt-2 form-control" placeholder="<?php echo $apartment[0]['Price'] ?>" id="inputPrice" min="1" required>
            <div class="invalid-feedback"> Введите цену </div>
        </div>
        <div class="mt-3 form-group">
            <label for=""> Количество комнат </label>
            <select class="mt-2 form-select" name="RoomsCount" aria-label="HouseType">
                <option value="1" <?php if($apartment[0]['RoomsCount'] == 1) echo 'selected'; ?>> 1-2 </option>
                <option value="2" <?php if($apartment[0]['RoomsCount'] == 2) echo 'selected'; ?>> 3-4 </option>
                <option value="3" <?php if($apartment[0]['RoomsCount'] == 3) echo 'selected'; ?>>  5-6 </option>
                <option value="4" <?php if($apartment[0]['RoomsCount'] == 4) echo 'selected'; ?>> Другой </option>
            </select>
        </div>
        <div class="mt-3 form-group">
            <label for="inputApartmentNumber"> Номер квартиры </label>
            <input type="number" name="ApartmentNumber" class="mt-2 form-control" placeholder="<?php echo $apartment[0]['ApartmentNumber'] ?>" id="inputApartmentNumber" min="1" required>
            <div class="invalid-feedback"> Введите номер квартиры </div>
        </div>
        <div class="mt-3 form-group">
            <label for="inputApartmentPlane"> План дома </label>
            <input type="file" class="mt-2 form-control" name="ApartmentPlane" id="inputApartmentPlane" required>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" name="editApartment" class="btn btn-primary"> Изменить </button>
        </div>
    </form>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>
