<?php include 'inc/header.php' ?>

<?php
if(!isset($_GET['search']) || $_GET['search'] == null) {
    echo "<script>window.location = '404.php'; </script>";
}else {
   $search = $_GET['search']; 
}

?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
			
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
			<?php
				$productbysearch = $pd->productBySearch($search);
				if($productbysearch) {
					while($result = $productbysearch->fetch_assoc()) {
				
			?>

				<div class="grid_1_of_4 images_1_of_4">
				<a href="preview.php?proid=<?php echo $result['productId']; ?>">
					 <img src="admin/<?php echo $result['image']; ?>" alt="" style="height:300px;"/></a>
					 <h2><?php echo $result['productName']; ?> </h2>
					 <p><?php echo $fm->textShortener($result['body'], 60) ; ?></p>
					 <p><span class="price">€<?php echo $result['price']; ?></span></p>
				     <div class="button"><span><a href="preview.php?proid=<?php echo $result['productId']; ?>" class="details">Details</a></span>
					 </div>
				</div>
				<?php } }else{
					echo "There are no products matching with your search phrase";
				} ?>
				</div>
			</div>

	
	
    </div>
 </div>
</div>
   
<?php include 'inc/footer.php' ?>