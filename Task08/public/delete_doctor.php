<?php
require_once '../Repository.php';
require_once '../DataContext.php';
header('Location: index.php');
$repository = new Repository(new DataContext("sqlite:../data/dentistry.db"));
$id = $_GET['id'];
$repository->deleteDoctor($id);
exit();
