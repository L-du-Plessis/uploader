<?php

class Upload_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }
        
        // get product records from DB
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
        
        // insert product record into DB
        public function set_product($imageFileName) 
        {
                if (isset($this->session->userdata['logged_in'])) 
                {
                        $emailAddress = ($this->session->userdata['logged_in']['emailAddress']);  // get user email address from session
                } 
                    
                $price = sprintf("%01.2f", $this->input->post('price'));

                $data = array(
                        'id' => '',
                        'sellerName' => $this->input->post('sellerName'),
                        'productName' => $this->input->post('productName'),
                        'productBrandName' => $this->input->post('productBrandName'),
                        'vintage' => $this->input->post('vintage'),
                        'bottleSize' => $this->input->post('bottleSize'),
                        'price' => $price,
                        'QuantityAvailable' => $this->input->post('QuantityAvailable'),
                        'tastingNotes' => $this->input->post('tastingNotes'),
                        'productImage' => $imageFileName,
                        'publish' => 'No',
                        'emailAddress' => $emailAddress
                );

                return $this->db->insert('products', $data);
        }
}
?>