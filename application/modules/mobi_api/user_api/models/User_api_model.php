<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_api_model extends CI_Model {
    public function insert($table,$data)
    {
      $query=$this->db->insert($table,$data);
      return $query;
    }
    public function update($table,$data, $where)
    {
      $query=$this->db->update($table,$data,$where);
      return $query;
    }
    public function delete($table,$where)
    {
        $query=$this->db->delete($table,$where);
        return $query;
    }
    public function random_num($size=12)
    {
        $alpha_key = 'CIPHER';
        $keys = range('A', 'Z');
          for ($i = 0; $i < 2; $i++)
          {
            $alpha_key .= $keys[array_rand($keys)];
          }
        $length = $size - 2;
        $key = '';
        $keys = range(0, 9);
          for ($i = 0; $i < $length; $i++)
          {
            $key .= $keys[array_rand($keys)];
          }
        return $alpha_key . $key;
  }
  function get_SelectedRow($selectField,$whereCond,$tableName)
  {
      $this->db->select($selectField);
      $this->db->from($tableName);
      $this->db->where($whereCond);
      $query = $this->db->get();
      if($query){
          if($query->num_rows() > 0)
          {

              return $query->result();
          }
          else
          {
              return FALSE;
          }
      }
      else{
          return false;
      }

  }
   public function loginUsr($mobile_number, $password)
   {
     $qry="SELECT app_user_id,name,mobile_number,email,account_verified FROM app_usres WHERE mobile_number='$mobile_number' AND password='$password' AND is_deleted=0";
     $query=$this->db->query($qry);
     $rows=$query->num_rows();
     if($rows>0)
        {
          $row = $query->row();
          if (isset($row))
          {
            return $query->row_array();
          }
          else
          {
            return  FALSE;
          }
        }
        else {
          return FALSE;
        }
   }
    public function get_profile($userid)
    {
      $this->db->select('*');
      $this->db->from('app_usres');
      $this->db->where(array('app_user_id ' => $userid,'is_deleted'=>0));
      $query = $this->db->get();
      return $query->row_array();
    }
    public function get_wishlist_products($userid)
    {
      $base_url=base_url();
      $qry="SELECT  p.pr_id,p.product_name, p.product_dispn,p.mrp,p.selling_price,p.available_stock,p.product_catogory,
      CONCAT('$base_url',pdi.image_path) as product_image,pdi.img_id
      FROM  wish_list wl
      INNER JOIN  products p  ON p.pr_id=wl.product_id
      INNER JOIN product_catogory pc ON  p.product_catogory=pc.pcid
      INNER JOIN
         (
             SELECT product_id,  image_path,max(img_id) img_id
             FROM product_images
             GROUP BY product_id
         ) pdi ON pdi.product_id = p.pr_id

      WHERE p.display_status=1 AND p.is_deleted=0
      AND pc.display_status=1 AND pc.is_deleted=0 AND wl.user_id=$userid ORDER BY wl.id  DESC ";

      $query=$this->db->query($qry);
      return $query;
    }
    public function get_cart_products($userid)
    {

        $base_url=base_url();
        $qry="SELECT  p.pr_id,p.product_name,ct.qty as cart_qty, p.product_dispn,p.mrp,p.selling_price,p.available_stock,p.product_catogory,
        CONCAT('$base_url',pdi.image_path) as product_image,pdi.img_id
        FROM  cart ct
        INNER JOIN  products p  ON p.pr_id=ct.product_id
        INNER JOIN product_catogory pc ON  p.product_catogory=pc.pcid
        INNER JOIN
           (
               SELECT product_id,  image_path,max(img_id) img_id
               FROM product_images
               GROUP BY product_id
           ) pdi ON pdi.product_id = p.pr_id

        WHERE p.display_status=1 AND p.is_deleted=0
        AND pc.display_status=1 AND pc.is_deleted=0 AND ct.user_id=$userid ORDER BY ct.id  ASC ";

        $query=$this->db->query($qry);
        return $query;
    }

}