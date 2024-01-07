<?php
    class dataBase{
        private $userName = "id21694488_admin";
        private $senha = "123!aprendendoMais";

        public $conn;

        public function dbConnection(){
            $this->conn = null;
            try{

                $this->conn = new PDO('mysql:host=localhost; dbname=id21694488_aprendendomaisphp; port=3306', $this->userName, $this->senha);

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                

            }catch(PDOException $e){
                echo $e->getMessage();
            }
            
            return $this->conn;
        }
    }
?>