<?php
    include("Utils.php");
    include("DataContext.php");
    include("Repository.php");

    $repository = new Repository(new DataContext("sqlite:dentistry.db"));

    $allDoctors = $repository->getAllDoctors();
    
    $mask = "| %-5.16s| %-30.30s| %-30.30s| %-30.30s| %-50.50s|\n";
    echo "--------------------------------------------------------------\n";
    printf($mask, "id", "surname", "name", "patronymic", "specialization_name");
    echo "--------------------------------------------------------------\n";
    foreach($allDoctors as $doctor) {
        printf($mask, $doctor['id'], $doctor['surname'], $doctor["name"], $doctor["patronymic"], $doctor["specialization_name"]);
    }
    echo "--------------------------------------------------------------\n";

    while(true) {
        $command = readline("Enter the doctor id (to see all info) or press enter (to see info about all doctors) or enter \"exit\" to close program");
        if($command == "exit") {
            break;
        } else if (is_numeric($command) && intval($command) > 0) {
            $selected_doctor = array_filter($allDoctors,
            function($x) use ($command) {
                return $x['id'] == $command;
            });
            if (sizeof($selected_doctor) > 0) {
                $doctorProcedures = $repository->getAllProceduresByDoctorId(intval($command));
                if (sizeof($doctorProcedures) == 0) {
                    echo "This doctor has not completed any procedure yet\n\n";
                    continue;
                }
                Utils::print_procedures($doctorProcedures);
            } else {
                echo "Doctor with this id not found\n\n";
            }
        } else if ($command == "") {
            $allProcedures = $repository->getAllProcedures();
            Utils::print_procedures($allProcedures);
        } else {
            echo "Unknown command!\n\n";
        }
    }
?>





