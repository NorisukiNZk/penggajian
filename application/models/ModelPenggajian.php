<?php

class ModelPenggajian extends CI_model{

	public function get_data($table) {
		return $this->db->get($table);
	}

	public function insert_data($data,$table){
		$this->db->insert($table, $data);
	}

	public function update_data($table, $data, $whare){
		$this->db->update($table, $data, $whare);
	}

	public function delete_data($whare,$table){
		$this->db->where($whare);
		$this->db->delete($table);
	}

	public function insert_batch($table = null, $data = array()) {
		$jumlah = count($data);
		if ($jumlah > 0) {
			$this->db->insert_batch($table, $data);
		}
	}

	public function get_data_pegawai_by_id($id) {
		return $this->db->get_where('data_pegawai', ['id_pegawai' => $id])->row();
	}
	public function cek_login()
	{
		$username = set_value('username');

		// Hanya mencari berdasarkan username, password diverifikasi di Controller menggunakan password_verify
		$result = $this->db->where('username',$username)
							->limit(1)
							->get('data_pegawai');
		if($result->num_rows()>0){
			return $result->row();
		}else{
			return FALSE;
		}
	}
}

?>