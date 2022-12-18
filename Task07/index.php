<!DOCTYPE html>
<html>
    <head>
        <?php
            include("DataContext.php");
            include("Repository.php");
            $repository = new Repository(new DataContext("sqlite:dentistry.db"));
        ?>
    </head>
    <body>
        <div class="main-container">
            <div class="table-container">
                <div class="table-name">All doctors</div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>surname</th>
                        <th>name</th>
                        <th>patronymic</th>
                        <th>specialization</th>
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
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
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
                    <table class="table">
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
    </body>
</html>