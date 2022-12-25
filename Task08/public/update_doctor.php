<?php

require_once '../DataContext.php';
require_once '../Repository.php';

$repository = new Repository(new DataContext("sqlite:../data/dentistry.db"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: index.php');
    $repository->updateDoctor($_POST['id'], $_POST['surname'], $_POST['name'], $_POST['patronymic'], $_POST['procedure_percent'], $_POST['specialization_id']);
    exit();
}



$id = $_GET['id'];
$doctor = $repository->getDoctorById($id);
$specializations = $repository->getAllSpecializations();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UpdateDoctor</title>
</head>
<body>
    <form action="update_doctor.php" method="POST">
        <input type="hidden" name="id" value=<?=$doctor['id']?>>
        Surname: <input type="text" name="surname" value=<?=$doctor['surname']?>><br>
        Name: <input type="text" name="name" value=<?=$doctor['name']?>><br>
        Patronymic: <input type="text" name="patronymic" value=<?=$doctor['patronymic']?>><br>
        Specialisation: <select name="specialization_id">
            <?php
            foreach ($specializations as $specialization) {
                if ($specialization['specialization_name'] === $doctor['specialization_name']) {
                    print "<option value={$specialization['id']} selected>{$specialization['specialization_name']}</option><br>";
                } else {
                    print "<option value={$specialization['id']}>{$specialization['specialization_name']}</option><br>";
                }
            }
            ?>
        </select><br>
        Procedure percent: <input type="text" name="procedure_percent" value=<?=$doctor['procedure_percent']?>><br>
        <input type="submit" value="update">
    </form>
    <a href="index.php">Back</a>
</body>
</html>
