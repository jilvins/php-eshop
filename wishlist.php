<?php include 'inc/header.php' ?>
<?php
if(isset($_GET['delwlistid'])) {
    $productId = $_GET['delwlistid'];
    $delWlist = $pd->deleteWishData($cmrId, $productId);
}
?>


 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Wishlist</h2>
					
						<table class="tblone">
							<tr>
								<th width="5%">Sl</th>
								<th width="30%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								
								<th width="10%">Action</th>
							</tr>
							<?php
                            
							$getProd = $pd->checkWishlist($cmrId);
							if($getProd) {
								$i = 0;
								
								while($result = $getProd->fetch_assoc() ) {
								$i++;
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $result['productName']; ?></td>
								<td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
								<td>€<?php echo $result['price']; ?></td>

								<td><a href="preview.php?proid=<?php echo $result['productId']; ?>">View</a> 
                                || <a href="?delwlistid=<?php echo $result['productId']; ?>">Remove</a> 
                                </td>
							</tr>
							
							<?php  } } ?>
							
						</table>
						
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
</div>
   
<?php include 'inc/footer.php' ?>