<br>
<div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Product List</h3>
            </div>
            <div class="panel-body">
                <?php
                    if (isset($this->session->userdata['logged_in'])) 
                    {
                        $emailAddress = ($this->session->userdata['logged_in']['emailAddress']);  // get user email address from session
                        $admin = ($this->session->userdata['logged_in']['admin']);  // check if user is admin
                    } 
    
                    $template = array(
                        'table_open' => '<table class="table table-bordered table-striped table-condensed">',
                    );

                    $this->table->set_template($template);
                    $this->table->set_heading(array('Seller name', 'Product name', 'Product brand name', 'Publish', ''));

                    echo "<p>" . anchor('/upload/', 'Upload Product / Back') . "</p>";
                    
                    if ($admin)  // if admin user
                    {
                        $result = $this->upload_model->get_products("id != 0");
                    }
                    else  // not admin user
                    {
                        $result = $this->upload_model->get_products("emailAddress = '$emailAddress'");
                    }

                    // add table rows
                    for ($i=0; $i<count($result); $i++)
                    {
                        $editLink = "<a href='" . base_url() . "index.php/upload/edit_product/" . $result[$i]->id . "'>Edit</a>";
                        $editCell = array('data' => $editLink, 'align' => 'center');
                        
                        $this->table->add_row($result[$i]->sellerName, $result[$i]->productName, $result[$i]->productBrandName, $result[$i]->publish, $editCell);
                    }
                    
                    echo $this->table->generate();
                    
                    echo anchor('/upload/', 'Upload Product / Back');
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
    </div>
</div>

</body>
</html>