<?php

class map_model extends CI_Model
{
    public function get_data()
    {
        $data = array();

        $query = $this->db->query("SELECT id,lat,lng FROM markers ORDER BY id DESC");

        if($query->num_rows() > 0)
        {
            $data = $query->result_array();
        }

        return $data;
    }

    public function insert_data($data)
    {
        $flag = false;

        if($this->db->insert('markers',$data))
        {
            $flag = true;
        }

        return $flag;
    }

    public function delete_data($id)
    {
        $flag = false;

        if($this->db->delete('markers',array('id'=>$id)))
        {
            $flag = true;
        }

        return $flag;
    }
}
?>