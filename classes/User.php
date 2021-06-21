<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../library/database.php');
include_once ($filepath.'/../helpers/format.php');

?>



<?php

class User {
    private $db;
    private $format;

    public function __construct(){
        $this->db = new Database();
        $this->format = new Format();
        
    }


}

?>