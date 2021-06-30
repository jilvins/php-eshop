<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../library/database.php');
include_once ($filepath.'/../helpers/format.php');

?>



<?php

class Product {
    private $db;
    private $format;

    public function __construct(){
        $this->db = new Database();
        $this->format = new Format();
        
    }

    public function productInsert($data, $file ) {
     //$productName = $this->format->validation($productName);
        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $catId = mysqli_real_escape_string($this->db->link, $data['catId']);
        $brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
        $body = mysqli_real_escape_string($this->db->link, $data['body']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        $permit = array('jpg','png','jpeg','gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10). '.' . $file_ext;
        $uploaded_image = "upload/".$unique_image;
        if($productName == "" || $catId == "" || $brandId == "" ||
        $body == "" || $price == "" || $type == "") {
            $msg = "<span class='error'>Field must not be empty</span>";
            return $msg;
        }else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type ) 
            values ('$productName', '$catId', '$brandId', '$body',
            '$price', '$uploaded_image', '$type')";

            $inserted_row = $this->db->insert($query);
            if ($inserted_row) {
                $msg = "<span class='success'>Product inserted Successfully</span>";
                return $msg;
            }else {
                $msg = "<span class='error'>Product not inserted</span>";
                return $msg;
            }
        }
    }

    public function getAllProducts() {
       //$query = "SELECT * from tbl_product ORDER BY productId DESC"; 

       $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
                FROM tbl_product
                INNER JOIN tbl_category
                ON tbl_product.catId = tbl_category.catId
                INNER JOIN tbl_brand
                ON tbl_product.brandId = tbl_brand.brandId
                ORDER BY tbl_product.productId DESC"; 

       $result = $this->db->select($query);
       return $result;
    }

    public function getProdById($id) {
        $query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
        $result = $this->db->select($query);
        return $result; 
    }

    public function productUpdate($data, $file, $id ) {

        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
        $catId = mysqli_real_escape_string($this->db->link, $data['catId']);
        $brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
        $body = mysqli_real_escape_string($this->db->link, $data['body']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);

        $permit = array('jpg','png','jpeg','gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10). '.' . $file_ext;
        $uploaded_image = "upload/".$unique_image;
        if($productName == "" || $catId == "" || $brandId == "" ||
        $body == "" || $price == "" || $type == "") {
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
            $query = "UPDATE tbl_product SET 
            productName = '$productName',
            catId = '$catId',
            brandId = '$brandId',
            body = '$body',
            price = '$price',
            image = '$uploaded_image',
            type = '$type'
            WHERE productId = '$id' ";

            $updated_row = $this->db->update($query);
            if ($updated_row) {
                $msg = "<span class='success'>Product updated Successfully</span>";
                return $msg;
            }else {
                $msg = "<span class='error'>Product not updated</span>";
                return $msg;
            }
        }
    } else {
        move_uploaded_file($file_temp, $uploaded_image);
            $query = "UPDATE tbl_product SET 
            productName = '$productName',
            catId = '$catId',
            brandId = '$brandId',
            body = '$body',
            price = '$price',
            type = '$type'
            WHERE productId = '$id' ";

            $updated_row = $this->db->update($query);
            if ($updated_row) {
                $msg = "<span class='success'>Product updated Successfully</span>";
                return $msg;
            }else {
                $msg = "<span class='error'>Product not updated</span>";
                return $msg;
            }
        }  
    }
    }

    public function delProdById($id) {
        $query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
        $getData = $this->db->select($query);
        if ($getData) {
            while ($delImg = $getData->fetch_assoc()) {
                $delLink = $delImg['image'];
                unlink($delLink);
            }
        }
        $delquery = "DELETE FROM tbl_product WHERE productId = '$id' ";
        $deleteProduct = $this->db->delete($delquery);
       if($deleteProduct) {
        $msg = "<span class='success'>Product deleted Successfully</span>";
        return $msg;
       } else {
        $msg = "<span class='error'>Product was not deleted</span>";
        return $msg;
       }
    }

    public function getFeaturedProduct() {
        $query = "SELECT * FROM tbl_product WHERE type = '0' ORDER BY productId DESC LIMIT 4 ";
        $result = $this->db->select($query);
        return $result;
    }

    public function getNewProduct() {
        $query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4 ";
        $result = $this->db->select($query);
        return $result; 
    }

    public function getSingleProduct($id){
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
                FROM tbl_product
                INNER JOIN tbl_category
                ON tbl_product.catId = tbl_category.catId
                INNER JOIN tbl_brand
                ON tbl_product.brandId = tbl_brand.brandId
                AND tbl_product.productId = $id 
                ORDER BY tbl_product.productId DESC"; 

       $result = $this->db->select($query);
       return $result;
    }

    public function latestFromAcer(){
        $query = "SELECT * FROM tbl_product WHERE brandId ='2' ORDER BY productId DESC LIMIT 1 ";
               $result = $this->db->select($query);
               return $result;
       }
    public function latestFromSamsung() {
        $query = "SELECT * FROM tbl_product WHERE brandId = '1' ORDER BY productId DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function latestFromApple() {
        $query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }
    public function latestFromNokia() {
        $query = "SELECT * FROM tbl_product WHERE brandId = '5' ORDER BY productId DESC LIMIT 1 ";
        $result = $this->db->select($query);
        return $result;
    }

    public function productByCat($id) {
        $catId = mysqli_real_escape_string($this->db->link, $id);
        $query = "SELECT * FROM tbl_product WHERE catId = '$catId' ";
        $result = $this->db->select($query);
        return $result; 
    }

    public function productByCatName($id) {
        $query = "SELECT * FROM tbl_category WHERE catId = '$id' ";
        $result = $this->db->select($query);
        return $result; 
    }

    public function insertCompareData($productId, $cmrId) {
        $cmrId = mysqli_real_escape_string($this->db->link, $cmrId);
        $productId = mysqli_real_escape_string($this->db->link, $productId);

        $cquery = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' AND productId = '$productId' ";
        $check = $this->db->select($cquery);
        if($check) {
            $msg = "<span class='error'>Product already added to compare list</span>";
            return $msg;
        }

        $query = "SELECT * FROM tbl_product WHERE productId = '$productId' ";
        $result = $this->db->select($query)->fetch_assoc();
        if($result) {
            
                $productId = $result['productId'];
                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];

            $query = "INSERT INTO tbl_compare(cmrId, productId, productName, price, image ) 
            values ('$cmrId', '$productId', '$productName',
              '$price', '$image')";

            $inserted_row = $this->db->insert($query);

            if($inserted_row) {
                $msg = "<span class='success'>Added to compare</span>";
                return $msg;
               } else {
                $msg = "<span class='error'>Not added, some error</span>";
                return $msg;
               }
                
        }
    }

    public function getCompareProduct($cmrId) {
        $query = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' ";
        $result = $this->db->select($query);
        return $result;
    }

    public function delCompareData($cmrId) {
        $delquery = "DELETE FROM tbl_compare WHERE cmrId = '$cmrId' ";
        $deleteProduct = $this->db->delete($delquery);
       
    }

    public function saveWishListData($id, $cmrId) {
        $cquery = "SELECT * FROM tbl_wishlist WHERE cmrId = '$cmrId' AND productId = '$id' ";
        $check = $this->db->select($cquery);
        if($check) {
            $msg = "<span class='error'>Product already added to Wishlist</span>";
            return $msg;
        }

        $query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
        $result = $this->db->select($query)->fetch_assoc();
        if($result) {
            
                $productId = $result['productId'];
                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];

            $query = "INSERT INTO tbl_wishlist(cmrId, productId, productName, price, image ) 
            values ('$cmrId', '$productId', '$productName',
              '$price', '$image')";

            $inserted_row = $this->db->insert($query);

            if($inserted_row) {
                $msg = "<span class='success'>Added to Wishlist</span>";
                return $msg;
               } else {
                $msg = "<span class='error'>Not added, some error</span>";
                return $msg;
               }
                
        }

    }

    public function checkWishlist($cmrId) {
        $query = "SELECT * FROM tbl_wishlist WHERE cmrId = '$cmrId' ORDER BY id DESC ";
        $result = $this->db->select($query);
        return $result; 
    }

    public function deleteWishData($cmrId, $productId) {
        $query = "DELETE FROM tbl_wishlist WHERE cmrId = '$cmrId' AND productId = '$productId' ";
        $deleteWish = $this->db->delete($query); 
    }

    public function productBySearch($search) {
        $query = "SELECT * FROM tbl_product WHERE productName LIKE '%$search%' OR body LIKE '%$search%' ";
        $result = $this->db->select($query);
        return $result; 
    }

    
}


?>