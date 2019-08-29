<?php
include ('Database.php');
Class Model extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertToBase($sql,$values = '')
    {
        $stm = $this->pdo->prepare($sql);
               if ( $stm->execute($values)) {
        }
    }

    public function selectAllFromTable ($table)
    {
        $stmt = $this->pdo->query("select * from $table");
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function baseSelect ($nameTable)
    {
        $select = "SELECT ".$nameTable.".* 
				FROM `".$nameTable."` AS ".$nameTable."
				";
        return $select;
    }
    public function baseConnect(){
        $link = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        return $link;
    }
    public function fetchAll( $select ) {
        $mysqli = $this->baseConnect();
        $records = array();

        if ($select){
            $result	=	mysqli_query($mysqli, $select);
        }
        if ($result->num_rows>0) {
            while ($row = $result->fetch_object()){
                $records[] = $row;
            }
        }
        return $records;
    }
}
