<?php


include_once '../library/database.php';
include_once '../helpers/format.php';

?>



<?php

class Category {
    private $db;
    private $format;

    public function __construct(){
        $this->db = new Database();
        $this->format = new Format();
        
    }

    public function catInsert($catName) {
        $catName = $this->format->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);

        if(empty($catName)) {
            $catmsg = "Category field must not be empty";
            return $catmsg;
        }else {
            $query = "INSERT INTO tbl_category(catName) values ('$catName')";
            $catInsert = $this->db->insert($query);
            if ($catInsert) {
                $catmsg = "<span class='success'>Category inserted Successfully</span>";
                return $catmsg;
            }else {
                $catmsg = "<span class='error'>Category not inserted</span>";
                return $catmsg;
            }
        }
    }

    public function getAllCat(){
        $query = "SELECT * FROM tbl_category ORDER BY catId DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getCatById($id){
        $query = "SELECT * FROM tbl_category WHERE catId = '$id' ";
        $result = $this->db->select($query);
        return $result; 
    }

    public function delCatById($id){
       $query = "DELETE from tbl_category WHERE catId = '$id' ";
       $deleteData = $this->db->delete($query);
       if($deleteData) {
        $catmsg = "<span class='success'>Category deleted Successfully</span>";
        return $catmsg;
       } else {
        $catmsg = "<span class='error'>Category was not deleted</span>";
        return $catmsg;
       }
    }

    public function catUpdate($catName, $id ) {
        $catName = $this->format->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        $id = mysqli_real_escape_string($this->db->link, $id);

        if(empty($catName)) {
            $catmsg = "<span class='error'>Category field must not be empty</span>";
            return $catmsg;
    }else {
        $query= "UPDATE tbl_category
        SET catName = '$catName'
        WHERE catId = '$id' ";
        $update_row = $this->db->update($query);
        if($update_row) {
            $catmsg = "<span class='success'>Category updated Successfully</span>";
            return $catmsg;
        }else {
            $catmsg = "<span class='error'>Category was not updated</span>";
            return $catmsg; 
        }
    }
}
}


?>