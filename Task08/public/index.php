<!DOCTYPE html>
<html>
    <head>
        <?php
            include("../DataContext.php");
            include("../Repository.php");
            $repository = new Repository(new DataContext("sqlite:../data/dentistry.db"));
        ?>
    </head>
    <body>
        <div class="main-container">
            <div class="table-container">
                <div class="table-name">All doctors</div>
                <table class="table" border="1px">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>surname</th>
                        <th>name</th>
                        <th>patronymic</th>
                        <th>specialization</th>
                        <th>update</th>
                        <th>delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $doctors = $repository->getAllDoctors();
                        foreach($doctors as $doctor) {
                        ?>
                        <tr>
                            <td><?=$doctor["id"]?></td>
                            <td><?=$doctor["surname"]?></td>
                            <td><?=$doctor["name"]?></td>
                            <td><?=$doctor["patronymic"]?></td>
                            <td><?=$doctor["specialization_name"]?></td>
                            <form action="update_doctor.php" method="get">
                                <input type="hidden" name="id" value=<?=$doctor['id']?>>
                                <td><input type="submit" value="update"></td>
                            </form>
                            <form action="delete_doctor.php">
                                <input type="hidden" name="id" value=<?=$doctor['id']?>>
                                <td><input type="submit" value="delete"></td>
                            </form>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <h3><a href="add_doctor.php">Add doctor</a></h3>
            <div>
                <form action="" method="post">
                    <select name="doctorId">
                        <option value="allProcedures">All procedures</option>
                        <?php
                        foreach($doctors as $doctor) {
                            ?>
                            <option value="<?=$doctor["id"]?>"><?=$doctor["id"]?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" name="submit" value="Choose id">
                </form>
            </div>
            <div>
                <div class="procedures-table-container">
                    <table class="table" border="1px">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>surname</th>
                            <th>name</th>
                            <th>patronymic</th>
                            <th>begin_date</th>
                            <th>procedure_name</th>
                            <th>price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($_POST["doctorId"] == "allProcedures") {
                                $proceduresOfSelectedDoctor = $repository->getAllProcedures();
                            } else {
                                $proceduresOfSelectedDoctor = $repository->getAllProceduresByDoctorId(intval($_POST["doctorId"]));
                            }
                            foreach($proceduresOfSelectedDoctor as $doctor) {
                            ?>
                            <tr>
                                <td><?=$doctor["id"]?></td>
                                <td><?=$doctor["surname"]?></td>
                                <td><?=$doctor["name"]?></td>
                                <td><?=$doctor["patronymic"]?></td>
                                <td><?=$doctor["begin_date"]?></td>
                                <td><?=$doctor["procedure_name"]?></td>
                                <td><?=$doctor["price"]?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
            </div>
        </div>
            <h4>Register for a procedure</h4>
            <p>Choose the procedure</p>
            <form action="register.php" method="get">
                <select name="procedure_id">
            <?php
            $ableProcedures = $repository->getAbleProcedures();
            foreach ($ableProcedures as $procedure) {
                print "<option value={$procedure['id']}>{$procedure['procedure_name']}</option>";
            }
            ?>
                </select>
                <input type="submit" value="Register">
            </form>
    </body>
</html>