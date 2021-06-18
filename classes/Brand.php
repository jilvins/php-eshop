<?php


include_once '../library/database.php';
include_once '../helpers/format.php';

?>



<?php

class Brand {
    private $db;
    private $format;

    public function __construct(){
        $this->db = new Database();
        $this->format = new Format();
        
    }

public function brandInsert($brandName) {
    $brandName = $this->format->validation($brandName);
    $brandName = mysqli_real_escape_string($this->db->link, $brandName);

    if(empty($brandName)) {
        $brandmsg = "Brand field must not be empty";
        return $brandmsg;
    }else {
        $query = "INSERT INTO tbl_brand(brandName) values ('$brandName')";
        $brandInsert = $this->db->insert($query);
        if ($brandInsert) {
            $brandmsg = "<span class='success'>Brand inserted Successfully</span>";
            return $brandmsg;
        }else {
            $brandmsg = "<span class='error'>Brand not inserted</span>";
            return $brandmsg;
        }
    }
}

public function getAllBrand(){
    $query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
    $result = $this->db->select($query);
    return $result;
}

public function getBrandById($id){
    $query = "SELECT * FROM tbl_brand WHERE brandId = '$id' ";
    $result = $this->db->select($query);
    return $result; 
}

public function delBrandById($id){
   $query = "DELETE from tbl_brand WHERE brandId = '$id' ";
   $deleteData = $this->db->delete($query);
   if($deleteData) {
    $msg = "<span class='success'>Brand deleted Successfully</span>";
    return $msg;
   } else {
    $msg = "<span class='error'>Brand was not deleted</span>";
    return $msg;
   }
}

public function brandUpdate($brandName, $id ) {
    $brandName = $this->format->validation($brandName);
    $brandName = mysqli_real_escape_string($this->db->link, $brandName);
    $id = mysqli_real_escape_string($this->db->link, $id);

    if(empty($brandName)) {
        $msg = "<span class='error'>Brand field must not be empty</span>";
        return $msg;
}else {
    $query= "UPDATE tbl_brand
    SET brandName = '$brandName'
    WHERE brandId = '$id' ";
    $update_row = $this->db->update($query);
    if($update_row) {
        $msg = "<span class='success'>Brand updated Successfully</span>";
        return $msg;
    }else {
        $msg = "<span class='error'>Brand was not updated</span>";
        return $msg; 
    }
}
}



}

?>