<?php

class Login_Database extends CI_Model {

        // read user data using email address and password
        public function login($data) 
        {
                $condition = "emailAddress =" . "'" . $data['emailAddress'] . "' AND " . "password =" . "'" . $data['password'] . "'";
                $this->db->select('*');
                $this->db->from('users');
                $this->db->where($condition);
                $this->db->limit(1);
                $query = $this->db->get();

                if ($query->num_rows() == 1) 
                {
                        return true;
                } 
                else 
                {
                        return false;
                }
        }

        // get user data from DB to use on page
        public function read_user_information($emailAddress) 
        {
                $condition = "emailAddress =" . "'" . $emailAddress . "'";
                $this->db->select('*');
                $this->db->from('users');
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
        
        // get admin user email address
        public function get_admin_email() 
        {
                $condition = "admin = '1'";
                $this->db->select('*');
                $this->db->from('users');
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
}
?>