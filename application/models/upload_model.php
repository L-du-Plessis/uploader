<?php

class Upload_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        
        // get product record list from DB
        public function get_products($condition)
        {
                $this->db->select('sellerName, productName, productBrandName, publish, id');
                $this->db->from('products');
                $this->db->where($condition);
                $query = $this->db->get();
                
                return $query->result();
        }
        
        // get a product record from DB
        public function get_product($id)
        {
                $condition = "id = " . "'" . $id . "'";
                $this->db->select('*');
                $this->db->from('products');
                $this->db->where($condition);
                $this->db->limit(1);
                $query = $this->db->get();

                if ($query->num_rows() == 1) 
                {
                        return $query->result();
                } 
                else 
                {
                        return false;
                }
        }
        
        // insert/update product record in DB
        public function set_product($imageFileName = '') 
        {
                if (isset($this->session->userdata['logged_in'])) 
                {
                        $emailAddress = ($this->session->userdata['logged_in']['emailAddress']);  // get user email address from session
                        $admin = ($this->session->userdata['logged_in']['admin']);  // check if user is admin
                } 
                    
                $id = $this->input->post('id');
                $sellerName = $this->input->post('sellerName');
                $productName = $this->input->post('productName');
                $productBrandName = $this->input->post('productBrandName');
                $vintage = $this->input->post('vintage');
                $bottleSize = $this->input->post('bottleSize');
                $price = sprintf("%01.2f", $this->input->post('price'));
                $QuantityAvailable = $this->input->post('QuantityAvailable');
                $tastingNotes = $this->input->post('tastingNotes');
                $publish = $this->input->post('publish');

                if ($id !== '0')  // edit record
                {
                        $this->db->set('sellerName', $sellerName);
                        $this->db->set('productName', $productName);
                        $this->db->set('productBrandName', $productBrandName);
                        $this->db->set('vintage', $vintage);
                        $this->db->set('bottleSize', $bottleSize);
                        $this->db->set('price', $price);
                        $this->db->set('QuantityAvailable', $QuantityAvailable);
                        $this->db->set('tastingNotes', $tastingNotes);
                        
                        if ($admin)  // if admin user
                        {
                                $this->db->set('publish', $publish);
                        }
                        
                        $this->db->where('id', $id);
                        $this->db->update('products');
                }
                else   // new record
                {
                        $data = array(
                                'id' => '',
                                'sellerName' => $sellerName,
                                'productName' => $productName,
                                'productBrandName' => $productBrandName,
                                'vintage' => $vintage,
                                'bottleSize' => $bottleSize,
                                'price' => $price,
                                'QuantityAvailable' => $QuantityAvailable,
                                'tastingNotes' => $tastingNotes,
                                'productImage' => $imageFileName,
                                'publish' => 'No',
                                'emailAddress' => $emailAddress
                        );
                
                        return $this->db->insert('products', $data);                
                }
        }
}
?>