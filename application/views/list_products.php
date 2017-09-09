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
                        'table_open'            => '<table class="table table-bordered table-striped table-condensed">',

                        'thead_open'            => '<thead>',
                        'thead_close'           => '</thead>',

                        'heading_row_start'     => '<tr>',
                        'heading_row_end'       => '</tr>',
                        'heading_cell_start'    => '<th>',
                        'heading_cell_end'      => '</th>',

                        'tbody_open'            => '<tbody>',
                        'tbody_close'           => '</tbody>',

                        'row_start'             => '<tr>',
                        'row_end'               => '</tr>',
                        'cell_start'            => '<td>',
                        'cell_end'              => '</td>',

                        'row_alt_start'         => '<tr>',
                        'row_alt_end'           => '</tr>',
                        'cell_alt_start'        => '<td>',
                        'cell_alt_end'          => '</td>',

                        'table_close'           => '</table>'
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

                    for ($i=0; $i<count($result); $i++)
                    {
                        $editLink = "<a href='" . base_url() . "index.php/upload/edit_product/" . $result[$i]->id . "'>Edit</a>";
                        
                        $this->table->add_row($result[$i]->sellerName, $result[$i]->productName, $result[$i]->productBrandName, $result[$i]->publish, $editLink);
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