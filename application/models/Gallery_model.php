<?php
class Gallery_model extends CI_Model{
	public function upload($data = array()){
        // Insert Ke Database dengan Banyak Data Sekaligus
		return $this->db->insert_batch('gambar',$data);
	}
}