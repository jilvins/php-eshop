<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../library/database.php');
include_once ($filepath.'/../helpers/format.php');

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
public function getCopyById() {
    $query = "SELECT * FROM tbl_copyrights";
    $result = $this->db->select($query);
    return $result;
}

public function copyrightUpdate($copyright) {
    $copyright = $this->format->validation($copyright);
    $copyright = mysqli_real_escape_string($this->db->link, $copyright);

    if(empty($copyright)) {
        $msg = "<span class='error'>Copyright field must not be empty</span>";
        return $msg;
}else {
    $query= "UPDATE tbl_copyrights
    SET copyright = '$copyright' 
    WHERE id = '1' ";
    
    $update_row = $this->db->update($query);
    if($update_row) {
        $msg = "<span class='success'>Copyright updated Successfully</span>";
        return $msg;
    }else {
        $msg = "<span class='error'>Copyright was not updated</span>";
        return $msg; 
    }
}
}

public function getSocial() {
    $query = "SELECT * FROM tbl_social";
    $result = $this->db->select($query);
    return $result;
}

public function socMedUpdate($fb, $tw, $ln, $gp) {
    $fb = $this->format->validation($fb);
    $tw = $this->format->validation($tw);
    $ln = $this->format->validation($ln);
    $gp = $this->format->validation($gp);

    $fb = mysqli_real_escape_string($this->db->link, $fb);
    $tw = mysqli_real_escape_string($this->db->link, $tw);
    $ln = mysqli_real_escape_string($this->db->link, $ln);
    $gp = mysqli_real_escape_string($this->db->link, $gp);

    if(empty($fb && $tw && $ln && $gp )) {
        $msg = "<span class='error'>Social media field must not be empty</span>";
        return $msg;
}else {
    $query= "UPDATE tbl_social
    SET 
    fb = '$fb',
    tw = '$tw',
    ln = '$ln',
    gp = '$gp' 
    WHERE id = '1' ";
    
    $update_row = $this->db->update($query);
    if($update_row) {
        $msg = "<span class='success'>Social media updated Successfully</span>";
        return $msg;
    }else {
        $msg = "<span class='error'>Social media was not updated</span>";
        return $msg; 
    }
}
}

public function getAllImages() {
    $query = "SELECT * FROM tbl_image";
    $result = $this->db->select($query);
    return $result;
}

public function imageInsert($data, $file ) {
    $title = mysqli_real_escape_string($this->db->link, $data['title']);
        
    $permit = array('jpg','png','jpeg','gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10). '.' . $file_ext;
    $uploaded_image = "upload/".$unique_image;
    if($title == "" ) {
        $msg = "<span class='error'>Field must not be empty</span>";
        return $msg;
    }else { 
        if(!empty($file_name)) {
    if ($file_size > 1054589) {
        echo "<span class='error'>Image size should be less then 1mb</span>";
    }elseif (in_array($file_ext, $permit) === false) {
        echo "<span class='error'>You can upload only " .implode('', $permit). "</span>";
    }else {
        move_uploaded_file($file_temp, $uploaded_image);
        $query = "INSERT INTO tbl_image (title, image)
        VALUES ('$title', '$uploaded_image' ) ";

        $inserted_row = $this->db->insert($query);
        if ($inserted_row) {
            $msg = "<span class='success'>Image uploaded Successfully</span>";
            return $msg;
        }else {
            $msg = "<span class='error'>Image not inserted</span>";
            return $msg;
        }
    }
} 
    }
}


}

?>