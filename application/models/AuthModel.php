<?php

    class AuthModel extends CI_Model
    {
        public function __construct()
        {

        }

        public function insert($data)
        {
            $result['result'] = $this->db->insert('user', $data);
            $result['error'] = $this->db->error();
            return $result;
        }

        public function get($column='*', $data=array(1=>1))
        {
            $this->db->select($column); 
            $this->db->from('user');
            $this->db->where($data);
            $result['result'] = $this->db->get();
            $result['error'] = $this->db->error();
            return $result;
        }

        public function update($id, $data)
        {
            $this->db->where($id);
            $result['result'] = $this->db->update('user', $data);
            $result['error'] = $this->db->error();
            return $result;
        }

    }
?>