<?php 
    class DataContext {
        private PDO $dataContext;
        
        public function __construct(string $connectionString) {
            try {
                $this->dataContext = new PDO($connectionString);
            } catch(PDOException $e) {
                exit("Error when connecting to database: ". $e->getMessage());
            }
        }

        public function getAll(string $query) {
            $statement = $this->dataContext->query($query);
            $rows = $statement->fetchAll();
            return $rows;
        }
        public function getItem(string $query) {
            $statement = $this->dataContext->query($query);
            $item = $statement->fetch();
            return $item;
        }
        public function updateItems(string $query, array $values) {
            $statement = $this->dataContext->prepare($query);
            $statement->execute($values);
        }

        public function deleteItem(string $query, int $id) {
            $statement = $this->dataContext->prepare($query);
            $statement->execute([$id]);
        }

        public function putItem(string $query, array $args) {
            $statement = $this->dataContext->prepare($query);
            $statement->execute($args);
        }
    }
 ?>