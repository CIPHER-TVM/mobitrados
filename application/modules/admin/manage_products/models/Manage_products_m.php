<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_products_m extends CI_Model
{

    public function product_data()
    {
      $qry="SELECT pd.*,pc.product_catogory_name FROM  products pd
      INNER JOIN product_catogory pc ON pc.pcid=pd.product_catogory
      WHERE pd.is_deleted=0 ORDER BY pd.pr_id DESC";
      $result=$this->db->query($qry);
      return $result;
    }
    public function product_images($pro_id=0)
    {
      $result= $this->db->order_by('img_id', 'desc')->get_where('product_images', ['is_deleted' => 0,'product_id'=>$pro_id]);
      return $result;
    }
    public function product_stock_history($pr_id=0)
    {
      $qry="SELECT sh.*,p.product_name,pc.product_catogory_name FROM stock_history sh
          INNER JOIN products p on p.pr_id = sh.product_id
          INNER JOIN product_catogory pc on pc.pcid = p.product_catogory
       where sh.product_id=$pr_id AND sh.is_intial_stock=0 AND sh.is_deleted=0 order by sh.stock_id  desc";
      return $this->db->query($qry);
    }

}
