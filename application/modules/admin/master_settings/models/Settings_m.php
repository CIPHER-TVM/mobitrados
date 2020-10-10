<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings_m extends CI_Model
{

    public function tax_data()
    {
      $result= $this->db->order_by('id', 'desc')->get_where('tax_master', ['is_deleted' => 0]);
      return $result;
    }
}
