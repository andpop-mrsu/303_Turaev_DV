<?php

require_once '../DataContext.php';
require_once '../Repository.php';

$repository = new Repository(new DataContext("sqlite:../data/dentistry.db"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: index.php');
    $repository->putDoctor($_POST['surname'], $_POST['name'], $_POST['patronymic'], $_POST['procedure_percent'], $_POST['specialization_id']);
    exit();
}

$specializations = $repository->getAllSpecializations();
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AddDoctor</title>
</head>
<body>
    <form action="" method="POST">
        Surname: <input type="text" name="surname"><br>
        Name: <input type="text" name="name"><br>
        Patronymic: <input type="text" name="patronymic"><br>
        Specialisation: <select name="specialization_id">
            <?php
            foreach ($specializations as $specialization) {
                print "<option value={$specialization['id']}>{$specialization['specialization_name']}</option><br>";
            }
            ?>
        </select><br>
        Procedure percent: <input type="text" name="procedure_percent"><br>
        <input type="submit" value="add_doctor">
    </form>
    <a href="index.php">Back</a>
</body>
</html>
