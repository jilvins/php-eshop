<?php

include '../library/session.php';
Session::checkLogin();
include_once '../library/database.php';
include_once '../helpers/format.php';

?>

<?php

class AdminLogin {

    private $db;
    private $format;

    public function __construct(){
        $this->db = new Database();
        $this->format = new Format();
        
    }
    public function adminLogin($adminUser, $adminPass){
        $adminUser = $this->format->validation($adminUser);
        $adminPass = $this->format->validation($adminPass);

        $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
        $adminUser = mysqli_real_escape_string($this->db->link, $adminPass);

        if(empty($adminUser) || empty($adminPass)) {
            $loginmsg = "Username or Password must not be empty";
            return $loginmsg;
        }else {
            $query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' ";
            $result = $this->db->select($query);
            if($result != false) {
                $value = $result->fetch_assoc();
                Session::set("adminlogin", true);
                Session::set("adminId", $value['adminId']);
                Session::set("adminUser", $value['adminUser']);
                Session::set("adminName", $value['adminName']);
                header("Location:dashboard.php");
            } else {
                $loginmsg = "username or password are not matching";
                return $loginmsg;
            }
        }
    }
}

?>