<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../library/database.php');
include_once ($filepath.'/../helpers/format.php');

?>



<?php

class Cart {
    private $db;
    private $format;

    public function __construct(){
        $this->db = new Database();
        $this->format = new Format();
        
    }

    public function addToCart($quantity, $id ) {
        $quantity = $this->format->validation($quantity);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $productId = mysqli_real_escape_string($this->db->link, $id);
        $sId = session_id();

        $squery = "SELECT * FROM tbl_product WHERE productId = '$productId' ";
        $result = $this->db->select($squery)->fetch_assoc();

        $productName = $result['productName'];
        $price = $result['price'];
        $image = $result['image'];

        $chquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId' ";
        $getProd = $this->db->select($chquery);
        if ($getProd) {
            $msg = "Product already added!";
            return $msg;
        }else {

        

        $query = "INSERT INTO tbl_cart(sId, productId, productName,  price, quantity, image ) 
            values ('$sId', '$productId', '$productName',
            '$price', '$quantity', '$image')";

            $inserted_row = $this->db->insert($query);
            if ($inserted_row) {
                header("Location:cart.php");
            }else {
                header("Location:404.php");
            }
        }
    }
    public function getCartProduct() {
        $sId = session_id();

        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
        $result = $this->db->select($query);
        return $result; 
    }

    public function updateCartQuantity($cartId, $quantity) {
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);  

        $query= "UPDATE tbl_cart
        SET quantity = '$quantity'
        WHERE cartId = '$cartId' ";
        $update_row = $this->db->update($query);
        if($update_row) {
           // $msg = "<span class='success'>Quantity changed Successfully</span>";
           // return $msg;
           header("Location:cart.php");
        }else {
            $msg = "<span class='error'>Quantity was not updated</span>";
            return $msg; 
        }
    }

    public function deleteCartProduct($delid) {
        $query = "DELETE from tbl_cart WHERE cartId = '$delid' ";
       $deleteData = $this->db->delete($query);
       if($deleteData) {
           echo "<script>window.location = 'cart.php' </script> ";
       } else {
        $msg = "<span class='error'>Product was not removed from cart</span>";
        return $msg;
       }
    }

    public function checkCartTable() {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
        $result = $this->db->select($query);
        return $result;
    }
    
    public function delCustomerCart() {
        $sId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId = '$sId' ";
        $this->db->select($query);
    }

    public function orderProduct($cmrId){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
        $getProd = $this->db->select($query);
        if($getProd) {
            while($result= $getProd->fetch_assoc()) {
                $productId = $result['productId'];
                $productName = $result['productName'];
                $quantity = $result['quantity'];
                $price = $result['price'];
                $image = $result['image'];

            $query = "INSERT INTO tbl_order(cmrId, productId, productName, quantity, price, image ) 
            values ('$cmrId', '$productId', '$productName',
             '$quantity', '$price', '$image')";

            $inserted_row = $this->db->insert($query);
                
            }
            
        }
    }
    public function getOrderProducts($cmrId){
        $query = "SELECT * FROM tbl_order WHERE cmrId = '$cmrId' ORDER BY productId DESC ";
        $result = $this->db->select($query);
        return $result;
    }

    public function checkOrder($cmrId){
        $query = "SELECT * FROM tbl_order WHERE cmrId = '$cmrId' ";
        $result = $this->db->select($query);
        return $result;

    }

    public function getAllOrderProucts(){
        $query = "SELECT * FROM tbl_order ORDER BY date ";
        $result = $this->db->select($query);
        return $result;

    }

    public function productShipped($id, $date, $price) {
        $id = mysqli_real_escape_string($this->db->link, $id);
        $date = mysqli_real_escape_string($this->db->link, $date);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $query= "UPDATE tbl_order
        SET status = '1'
        WHERE cmrId = '$id' AND date='$date' AND price='$price' ";
        $update_row = $this->db->update($query);
        if($update_row) {
            $msg = "<span class='success'>Updated Successfully</span>";
            return $msg; 
        }else {
            $msg = "<span class='error'>Was not updated</span>";
            return $msg; 
        }
    }

    public function delProductShipped($id, $date, $price) {
        $id = mysqli_real_escape_string($this->db->link, $id);
        $date = mysqli_real_escape_string($this->db->link, $date);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $query = "DELETE from tbl_order 
        WHERE cmrId = '$id' AND date='$date' AND price='$price' ";
       $deleteData = $this->db->delete($query);
       if($deleteData) {
        $msg = "<span class='success'>Data deleted Successfully</span>";
        return $msg;
       } else {
        $msg = "<span class='error'>Data was not deleted</span>";
        return $msg;
       }
    }

    

}

?>