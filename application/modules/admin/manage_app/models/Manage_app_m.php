<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_app_m extends CI_Model
{

    public function banner_data()
    {
      $result= $this->db->order_by('bid', 'desc')->get_where('banner', ['is_deleted' => 0]);
      return $result;
    }
    public function offer_data($type=1)
    {
      $qry="SELECT ad.*,p.product_name,p.selling_price FROM app_product_display ad
      INNER JOIN products p on p.pr_id =ad.product_id  WHERE  ad.is_deleted=0 AND p.is_deleted=0 AND ad.display_type=$type ORDER BY ad.id  DESC";
      $result=$this->db->query($qry);
      return $result;
     }
}
