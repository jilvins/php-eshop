<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Brand.php'; ?>

<?php
    $cat = new Brand();
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $copyright = $_POST['copyright'];
        
    
        $updateCopyright = $cat->copyrightUpdate($copyright);
    }

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Copyright Text</h2>
        <div class="block copyblock"> 
        <?php
            if(isset($updateCopyright)){
            echo $updateCopyright;
            }
        ?>
        <?php
            $brand = new Brand();
            $getcopy = $brand->getCopyById();
            
            if($getcopy) {
            while ($result = $getcopy->fetch_assoc()) {

        ?>
         <form action="" method="post">
            <table class="form">					
                <tr>
                    <td>
                        <input type="text" value="<?php echo $result['copyright']; ?>" name="copyright" class="large" />
                    </td>
                </tr>
				
				 <tr> 
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
            <?php } } ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php';?>