<?php

require_once '../DataContext.php';
require_once '../Repository.php';

$repository = new Repository(new DataContext("sqlite:../data/dentistry.db"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: index.php');
    $repository->putAppointment($_POST['doctor_id'], $_POST['procedure_id'], $_POST['begin_date'], $_POST['status']);
    exit();
}

$procedure_id = $_GET['procedure_id'];
$procedure = $repository->getProcedure($procedure_id);

print "<h3>Запись на \"{$procedure['procedure_name']}\"</h3>";

$specialisation = $repository->getSpecializationsByProcedure($procedure_id);
$doctors = $repository->getDoctorsBySpecialization($specialisation['specialization_id']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RegisterOn</title>
</head>
<body>
<form action="" method="POST">
    Doctor: <select name="doctor_id">
        <?php
        foreach ($doctors as $doctor) {
            print "<option value={$doctor['id']}>{$doctor['surname']} {$doctor['name']} {$doctor['patronymic']}</option>";
        }
        ?>
    </select><br>
    DateTime: <input type="datetime-local" name="begin_date">
    <input type="hidden" name="procedure_id" value=<?=$procedure_id?>>
    <input type="hidden" name="status" value="assigned"><br>
    <input type="submit" value="Register">
</form>
<a href="index.php">Back</a>
</body>
</html>
