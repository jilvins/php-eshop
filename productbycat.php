<?php include 'inc/header.php' ?>

<?php
if(!isset($_GET['catId']) || $_GET['catId'] == null) {
    echo "<script>window.location = '404.php'; </script>";
}else {
   $id = $_GET['catId']; 
}

?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
			<?php
				$productbycat = $pd->productByCatName($id);
				if($productbycat) {
					while($result = $productbycat->fetch_assoc()) {
				
			?>
    		<h3>Latest from <?php echo $result['catName']; ?> Category</h3>
			<?php } } ?>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
			<?php
				$productbycat = $pd->productByCat($id);
				if($productbycat) {
					while($result = $productbycat->fetch_assoc()) {
				
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
					echo "There are no products in this category for now";
				} ?>
				</div>
			</div>

	
	
    </div>
 </div>
</div>
   
<?php include 'inc/footer.php' ?>