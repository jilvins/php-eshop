<?php include 'inc/header.php' ?>

<?php
 $login = Session::get("cuslogin");
 if($login == true) {
	 header("Location:order.php");
 }
 
?>

                   
<?php
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        
        $customerLogin = $cmr->customerLogin($_POST);
    }

?>

 <div class="main">
    <div class="content">
    	 <div class="login_panel">
		 <?php
		if(isset($customerLogin)) {
			echo $customerLogin;
		}
		?>
        	<h3>Existing Customers</h3>
        	<p>Sign in with the form below.</p>
        	<form action="" method="post" >
                	<input name="email" type="text" placeholder="Email" >
                    <input name="pass" type="password" placeholder="Password">
					<div class="buttons"><div><button class="grey" name="login">Sign In</button></div></div>
                    </div>
                 </form>
                 
                   
<?php
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
        
        $customerReg = $cmr->customerRegistration($_POST);
    }

?>

    	<div class="register_account">
		<?php
		if(isset($customerReg)) {
			echo $customerReg;
		}
		?>
    		<h3>Register New Account</h3>
    		<form action="" method="post">
		   			 <table>
		   				<tbody>
						<tr>
						<td>
							<div>
							<input type="text" name="name" placeholder="Name" />
							</div>
							
							<div>
							   <input type="text" name="city" placeholder="city" />
							</div>
							
							<div>
								<input type="text" name="zip" placeholder="zip code" />
							<div>
								<input  type="text" name="email" placeholder="email" />
							</div>
		    			 </td>
		    			<td>
						<div>
							<input type="text" name="address" placeholder="address" />
						</div>
		    		<div>
					<input type="text" name="country" placeholder="country" />
							

		         </select>
				 </div>		        
	
		           <div>
				   <input type="text" name="phone" placeholder="phone" />
		          </div>
				  
				  <div>
				  <input type="text" name="pass" placeholder="password" />
				</div>
		    	</td>
		    </tr> 
		    </tbody></table> 
		   <div class="search"><div><button class="grey" name="register">Create Account</button></div></div>
		    <p class="terms">By clicking 'Create Account' you agree to the <a href="#">Terms &amp; Conditions</a>.</p>
		    <div class="clear"></div>
		    </form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
</div>
   
<?php include 'inc/footer.php' ?>