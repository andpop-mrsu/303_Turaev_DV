<?php
    class Utils {
        public static function print_procedures($rows) {
            $mask = "| %-5.16s| %-30.30s| %-30.30s| %-30.30s| %-30.30s| %-50.50s| %-30.30s|\n";
            printf($mask, "id", "surname", "name", "patronymic", "begin_date", "procedure_name", "price");
            echo "----------------------------------------------------------------------------------------------------------\n";
            foreach($rows as $procedure) {
                printf($mask, $procedure['id'], $procedure['surname'], $procedure["name"], $procedure["patronymic"], $procedure["begin_date"], $procedure["procedure_name"], $procedure["price"]);
            }
            echo "\n\n";
        }
    }
?>