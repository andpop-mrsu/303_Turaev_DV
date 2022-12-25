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

        public function getDoctorById(int $doctor_id) {
            $query = "SELECT doctors.id, doctors.surname, doctors.name, doctors.patronymic, doctors.procedure_percent, specializations.specialization_name 
                        FROM doctors 
                        INNER JOIN specializations  
                        ON doctors.specialization_id = specializations.id WHERE doctors.id={$doctor_id};";
            return $this->dataContext->getItem($query);
        }

        public function getAllSpecializations() {
            $query = "SELECT * FROM specializations;";
            return $this->dataContext->getAll($query);
        }
        public function updateDoctor(int $id, string $surname, string $name, string $patronymic, int $procedure_percent, int $specialization_id) {
            $query = "UPDATE doctors SET surname=?, name=?, patronymic=?, procedure_percent=?, specialization_id=? WHERE id=?;";
            $this->dataContext->updateItems($query, [$surname, $name, $patronymic, $procedure_percent, $specialization_id, $id]);
        }

        public function deleteDoctor(int $id) {
            $query = 'DELETE FROM doctors where id=?';
            $this->dataContext->deleteItem($query, $id);
        }
        public function putDoctor(string $surname, string $name, string $patronymic, int $procedure_percent, int $specialisation_id) {
            $query = 'INSERT INTO doctors(surname, name, patronymic, status, procedure_percent, specialization_id)
                        VALUES (?, ?, ?, ?, ?, ?);';
            $this->dataContext->putItem($query, [$surname, $name, $patronymic, 'working', $procedure_percent, $specialisation_id]);
        }

        public function getAbleProcedures() {
            $query = 'SELECT * FROM procedures';
            $procedures = $this->dataContext->getAll($query);
            return $procedures;
        }

        public function getSpecializationsByProcedure(int $id) {
            $query = "SELECT specialization_id FROM specialization_procedure_mapping WHERE procedure_id={$id};";
            return $this->dataContext->getItem($query);
        }

        public function getProcedure(int $id) {
            $query = "SELECT * FROM procedures WHERE id={$id}";
            return $this->dataContext->getItem($query);
        }

        public function getDoctorsBySpecialization(int $specialization_id) {
            $query = "SELECT * FROM doctors WHERE specialization_id={$specialization_id}";
            return $this->dataContext->getAll($query);
        }

        public function putAppointment(int $doctor_id, int $procedure_id, string $begin_date, string $status) {
            $query = 'INSERT INTO appointments(doctor_id, procedure_id, begin_date, status)
                        VALUES (?, ?, ?, ?)';
            $this->dataContext->putItem($query, [$doctor_id, $procedure_id, $begin_date, $status]);
        }
    }
?>
