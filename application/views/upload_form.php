<?php
    if (isset($this->session->userdata['logged_in'])) 
    {
        $emailAddress = ($this->session->userdata['logged_in']['emailAddress']);  // get user email address from session
        $admin = ($this->session->userdata['logged_in']['admin']);  // check if user is admin
    } 

    if (validation_errors())  // validation errors exist
    {
        echo "<div class='alert alert-danger' role='alert'>";
        echo validation_errors();
        echo "</div>";
    }
    
    if ($error !== '')  // upload errors exist
    {
        echo "<div class='alert alert-danger' role='alert'>";
        echo $error;
        echo "</div>";
    }
    
    if ($edit === '')  // record not being edited
    {
        $panelTitle = 'Upload Product Information';
        
        $sellerName = '';
        $productName = '';
        $productBrandName = '';
        $vintage = '';
        $bottleSize = '';
        $price = '';
        $QuantityAvailable = '';
        $tastingNotes = '';
        $publish = '';
    }
    else  // record being edited
    {
        $panelTitle = 'Edit Product Information';
    }
    
    echo form_open_multipart('/upload/do_upload');
?>

<br>
<div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $panelTitle; ?></h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="sellerName">Seller name:</label>
                    <input type="text" id="sellerName" name="sellerName" value="<?php echo set_value('sellerName', $sellerName, TRUE); ?>" class="form-control input-sm">
                </div>
                <div class="form-group">
                    <label for="productName">Product name:</label>
                    <input type="text" id="productName" name="productName" value="<?php echo set_value('productName', $productName, TRUE); ?>" class="form-control input-sm">
                </div>
                <div class="form-group">
                    <label for="productBrandName">Product brand name:</label>
                    <input type="text" id="productBrandName" name="productBrandName" value="<?php echo set_value('productBrandName', $productBrandName, TRUE); ?>" class="form-control input-sm">
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="vintage">Vintage:</label>
                            <input type="text" id="vintage" name="vintage" value="<?php echo set_value('vintage', $vintage, TRUE); ?>" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="bottleSize">Bottle Size:</label>
                            <input type="text" id="bottleSize" name="bottleSize" value="<?php echo set_value('bottleSize', $bottleSize, TRUE); ?>" class="form-control input-sm">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="text" id="price" name="price" value="<?php echo set_value('price', $price, TRUE); ?>" class="form-control input-sm" style="text-align:right" onkeypress='return isNumber(event)'>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="QuantityAvailable">Quantity Available:</label>
                            <input type="number" id="QuantityAvailable" name="QuantityAvailable" value="<?php echo set_value('QuantityAvailable', $QuantityAvailable, TRUE); ?>" class="form-control input-sm">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="tastingNotes">Tasting Notes:</label>
                    <textarea rows="5" id="tastingNotes" name="tastingNotes" class="form-control input-sm"><?php echo set_value('tastingNotes', $tastingNotes, TRUE); ?></textarea>
                </div>
                <div class="form-group">
                    <?php
                        if ($edit === '')  // record not being edited
                        {
                            echo '<label for="productImage">Image:</label>';
                            echo '<input type="file" id="productImage" name="productImage" class="form-control input-sm">';
                        }
                        else  // record being edited
                        {
                            if ($admin)  // if admin user
                            {
                                echo '<div class="row">';
                                echo '<div class="col-sm-6">';
                                echo '<label for="publish">Publish:</label>';
                                echo '<select class="form-control" id="publish">' . 
                                     '<option>No</option>' . 
                                     '<option>Yes</option>' . 
                                     '</select>';
                                echo '</div>';
                                echo '<div class="col-sm-6">';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <?php
                            if ($edit === '')  // record not being edited
                            {
                                echo '<button type="submit" class="btn btn-primary btn-block">Upload</button>';
                            }
                            else  // record being edited
                            {
                                echo "<a href='" . base_url() . "index.php/upload/list_products' class='btn btn-success btn-block'>Save</a>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo base_url(); ?>index.php/upload/list_products" class="btn btn-warning btn-block">Products</a>
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo base_url(); ?>index.php/upload/logout" class="btn btn-danger btn-block">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
    </div>
</div>

</form>
</body>
</html>
