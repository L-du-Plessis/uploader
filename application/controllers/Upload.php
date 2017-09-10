<?php

if (!isset($_SESSION)) 
{ 
        //session_start();
} 

class Upload extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper(array('form', 'url'));
                
                $this->load->model('upload_model');
                $this->load->model('login_database');
                
                $this->load->library('form_validation');
                $this->load->library('session');
                $this->load->library('email');
                
                $this->load->view('header');
        }

        public function index()
        {
                if (isset($this->session->userdata['logged_in']))  // logged in
                {
                        $this->load->view('upload_form', array('error' => '', 'edit' => ''));
                } 
                else  // not logged in
                {
                        $this->load->view('login_form');
                }
        }

        // check for user login process
        public function user_login_process() 
        {
                $this->load->helper('security');
                
                // set login form fields validation rules
                $this->form_validation->set_rules('emailAddress', 'Email Address', 'trim|required|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

                if ($this->form_validation->run() == FALSE)  // validation errors exist
                {
                        $this->load->view('login_form');
                } 
                else  // no validation errors
                {
                        $data = array(
                                'emailAddress' => $this->input->post('emailAddress'),
                                'password' => $this->input->post('password')
                        );
                        $result = $this->login_database->login($data);
                        if ($result == TRUE) 
                        {
                                $emailAddress = $this->input->post('emailAddress');
                                $result = $this->login_database->get_user_info("emailAddress = '$emailAddress'");
                                if ($result != false) 
                                {
                                        $session_data = array(
                                                'name' => $result[0]->name,
                                                'emailAddress' => $result[0]->emailAddress,
                                                'admin' => $result[0]->admin,
                                        );
                                        // add user data in session
                                        $this->session->set_userdata('logged_in', $session_data);
                                        $this->load->view('upload_form', array('error' => '', 'edit' => ''));
                                }
                        } 
                        else  // user record not found
                        {
                                $data = array(
                                        'error_message' => 'Invalid Email Address or Password'
                                );
                                $this->load->view('login_form', $data);
                        }
                }
        }

        public function logout() 
        {
                // Remove session data
                $sess_array = array(
                        'emailAddress' => ''
                );
                $this->session->unset_userdata('logged_in', $sess_array);
                $data['logout_message'] = 'Logout Successful';
                $this->load->view('login_form', $data);
        }
        
        // list uploaded products
        public function list_products()
        {
                $this->load->library('table');
                
                $this->load->view('list_products');
        }
        
        // edit a product
        public function edit_product($id)
        {
                $result = $this->upload_model->get_product($id);
                if ($result != false) 
                {
                        $data = array(
                                'error' => '',
                                'edit' => '1',
                                'id' => $id,
                                'sellerName' => $result[0]->sellerName,
                                'productName' => $result[0]->productName,
                                'productBrandName' => $result[0]->productBrandName,
                                'vintage' => $result[0]->vintage,
                                'bottleSize' => $result[0]->bottleSize,
                                'price' => $result[0]->price,
                                'QuantityAvailable' => $result[0]->QuantityAvailable,
                                'tastingNotes' => $result[0]->tastingNotes,
                                'publish' => $result[0]->publish,
                        );
                        $this->load->view('upload_form', $data);
                }
        }
        
        public function do_upload()
        {
                $admin = ($this->session->userdata['logged_in']['admin']);  // check if user is admin
                
                if ($this->input->post('id') !== '0')  // editing record
                {
                        $edit = '1';
                }
                else  // adding record
                {
                        $edit = '';
                }
                
                // set upload form fields validation rules
                $this->form_validation->set_rules('sellerName', 'Seller name', 'required');
                $this->form_validation->set_rules('productName', 'Product name', 'required');
                $this->form_validation->set_rules('productBrandName', 'Product brand name', 'required');

                if ($this->form_validation->run() == FALSE)  // validation errors exist
                {
                        $this->load->view('upload_form', array('error' => '', 'edit' => $edit));
                        return;
                }
                
                if ($edit === '1')  // editing record                  
                {
                        $this->load->library('table');
                
                        $this->upload_model->set_product();  // update product record in DB
                        
                        if ($admin && $this->input->post('publish') == "Yes")
                        {
                                $this->send_publish_email();  // send email to uploader
                        }
                
                        $this->load->view('list_products');
                        return;
                }
                
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 1024;  // kilobytes
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;

                $this->load->library('upload', $config);
                
                if ( ! $this->upload->do_upload('productImage'))
                {
                        $data = array('error' => $this->upload->display_errors(), 'edit' => '');

                        $this->load->view('upload_form', $data);
                }
                else  // upload successfull
                {
                        $data = array('upload_data' => $this->upload->data());  // upload product image to folder
                        $imageFileName = $this->upload->data('file_name');
                        $this->upload_model->set_product($imageFileName);  // insert product info into DB
                        $this->send_upload_email();  // send email to admin

                        $this->load->view('upload_success', $data);
                }
        }
        
        // send new product email to admin
        public function send_upload_email()
        {
                $name = ($this->session->userdata['logged_in']['name']);
                $emailAddress = ($this->session->userdata['logged_in']['emailAddress']);
                
                $result = $this->login_database->get_user_info("admin = '1'");  // get admin user email address
                if ($result != false)
                {
                        $adminEmail = $result[0]->emailAddress;
                }
                
                $this->email->from('louhelmdp@gmail.com', 'Product Uploader');
                $this->email->to($adminEmail);
                
                $message = "$name ($emailAddress) submitted a new product with the following details: " . 
                        "\n\n Seller name: " . $this->upload_model->input->post('sellerName') . 
                        "\n Product name: " . $this->upload_model->input->post('productName') . 
                        "\n Product brand name: " . $this->upload_model->input->post('productBrandName');

                $this->email->subject('New product uploaded');
                $this->email->message($message);

                $this->email->send();
        }
        
        // send email to uploader of published product
        public function send_publish_email()
        {
                $name = ($this->session->userdata['logged_in']['name']);
                $emailAddress = ($this->session->userdata['logged_in']['emailAddress']);
                
                $id = $this->input->post('id');
                
                $result = $this->upload_model->get_product($id);  // get upload user email address
                if ($result != false)
                {
                        $uploadEmail = $result[0]->emailAddress;
                }
                
                $this->email->from('louhelmdp@gmail.com', 'Product Uploader');
                $this->email->to($uploadEmail);
                
                $message = "$name ($emailAddress) published a product with the following details: " . 
                        "\n\n Seller name: " . $this->upload_model->input->post('sellerName') . 
                        "\n Product name: " . $this->upload_model->input->post('productName') . 
                        "\n Product brand name: " . $this->upload_model->input->post('productBrandName');

                $this->email->subject('Product published');
                $this->email->message($message);

                $this->email->send();
        }
}
?>