<?php include 'inc/header.php' ?>
<?php
$login = Session::get("cuslogin");
 if($login == false) {
	 header("Location:login.php");
 }
?>
<style>
.payment{width: 500px; min-height: 200px; text-align: center; border: 1px solid black; margin: 0 auto; padding: 50px;}
.payment h2{border-bottom: 2px solid #ddd; margin-bottom: 40px; padding-bottom:10px;}
.payment p{line-height: 25px;}
</style>

 <div class="main">
    <div class="content">
    	<div class="section group">
        <div class="payment">
            <h2>Success</h2>
            <p>Thanks for your order, Receive your order Successful. We will contact you soon. Here is your order details :<a href="order.php">Visit here</a></p>
            
        </div>
        

    </div>
 </div>
</div>
   
<?php include 'inc/footer.php' ?>