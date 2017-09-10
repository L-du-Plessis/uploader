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

        // get a user record from DB
        public function get_user_info($condition) 
        {
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