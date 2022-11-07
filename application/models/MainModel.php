<?php

    class MainModel extends CI_Model
    {
        public function __construct()
        {

        }

        public function insert($data)
        {
            $result['result'] = $this->db->insert('cuaca', $data);
            $result['error'] = $this->db->error();
            return $result;
        }

        public function get($column='*', $data=array(1=>1))
        {
            $this->db->select($column); 
            $this->db->from('cuaca');
            $this->db->where($data);
            $result['result'] = $this->db->get();
            $result['error'] = $this->db->error();
            return $result;
        }

        public function getWeather($column='*', $data=array(1=>1))
        {
            $this->db->select($column); 
            $this->db->from('cuaca');
            $this->db->where($data);
            $this->db->order_by('created_at', 'desc');
            $this->db->limit(1);
            $result['result'] = $this->db->get();
            $result['error'] = $this->db->error();
            return $result;
        }

        public function update($id, $data)
        {
            $this->db->where($id);
            $result['result'] = $this->db->update('cuaca', $data);
            $result['error'] = $this->db->error();
            return $result;
        }

    }
?>