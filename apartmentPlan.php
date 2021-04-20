<?php

include "Db.php";

$db = new Db();
$query = "SELECT * FROM apartments where id=".$_REQUEST['apartment_id'];
$apartment = $db->row($query);

?>

<div class="ms-3 mt-3">
    <a class="btn btn-primary" href="/apartments.php?house_id=<?php echo $apartment[0]['HouseId']; ?>"><--</a>
    <h1> План дома </h1><br>

    <img src="data:image/jpeg;base64, <?php echo base64_encode($apartment[0]['PlaneImage']); ?>" alt="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</div>