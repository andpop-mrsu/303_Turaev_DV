<?php
    class Repository {
        private DataContext $dataContext;

        public function __construct(DataContext $dataContext) {
            $this->dataContext = $dataContext;
        }

        public function getAllDoctors() {
            $query = "SELECT doctors.id, doctors.surname, doctors.name, doctors.patronymic, specializations.specialization_name 
                        FROM doctors 
                        INNER JOIN specializations  
                        ON doctors.specialization_id = specializations.id;";
            return $this->dataContext->getAll($query);
        }

        public function getAllProcedures() {
            $query = "SELECT doctors.id, doctors.surname, doctors.name, doctors.patronymic, 
                        appointments.begin_date, procedures.procedure_name, procedures.price 
                        FROM appointments 
                        INNER JOIN doctors 
                        ON doctors.id = appointments.doctor_id
                        INNER JOIN procedures 
                        ON procedures.id = appointments.procedure_id
                        ORDER BY doctors.surname, appointments.begin_date;";
            return $this->dataContext->getAll($query);
        }

        public function getAllProceduresByDoctorId(int $doctor_id) {
            $query = "SELECT doctors.id, doctors.surname, doctors.name, doctors.patronymic, 
                        appointments.begin_date, procedures.procedure_name, procedures.price 
                        FROM appointments 
                        INNER JOIN doctors 
                        ON doctors.id = appointments.doctor_id
                        INNER JOIN procedures 
                        ON procedures.id = appointments.procedure_id
                        WHERE doctors.id = ". $doctor_id ."
                        ORDER BY doctors.surname, appointments.begin_date;";
            return $this->dataContext->getAll($query);
        }
    }
?>
