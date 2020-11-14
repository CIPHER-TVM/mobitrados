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
        $qry="SELECT  p.pr_id,p.product_name,ct.qty as cart_qty, p.product_dispn,p.mrp,p.selling_price,p.available_stock,p.product_catogory,  p.tax_id,
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
    public function get_address($userid,$deafult_flag,$address_id=0,$fororder=0)
    {
      $cond="";
      if($deafult_flag) $cond.=" AND is_default=1";
      if($address_id>0) $cond.=" AND address_id=$address_id";
      if($fororder==0) $cond.="  AND is_deleted=0 ";
      $qry="SELECT address_id, name, mobile_number, pincode, locality, full_address, city_town, state_id, district_id, land_mark, alternative_mobile, address_type,is_default
        FROM user_address WHERE user_id=$userid $cond";

        $query=$this->db->query($qry);
        return $query;
    }
    public function product_stock_updates($operator,$stock,$prod_id)
    {
      $existstoc=getAfield("available_stock","products","where pr_id='$prod_id'");
      if($operator=='-')
      {
            $newstock=$existstoc-$stock;
      }
      else if($operator=="+")
      {
         $newstock=$existstoc+$stock;
      }
      $update=array('available_stock'=>$newstock);
      $where=array('pr_id'=>$prod_id);
      $ins=update("products",$update,$where);
      if($ins) return true; else return false;
    }

    public function list_orders($userid)
    {
      $qry="SELECT order_master_id ,order_number,address_id,place_id,order_total,no_items,order_status,order_placed_date,order_cancel,payment_type,payment_confirm
            FROM order_master WHERE user_id=$userid ORDER BY order_master_id DESC";
        $qrry=$this->db->query($qry);
      return $qrry;
    }
    public function order_details($userid,$order_master_id)
    {
      $base_url=base_url();
      $qry="SELECT oc.product_id,oc.unit_rate,oc.qty,oc.total_amount,p.product_name,p.product_dispn,
      CONCAT('$base_url',pdi.image_path) as product_image,pdi.img_id
        FROM order_child oc
        INNER JOIN products p  ON p.pr_id =oc.product_id
        INNER JOIN
           (
             SELECT product_id,  image_path,max(img_id) img_id
             FROM product_images
             GROUP BY product_id
           ) pdi ON pdi.product_id = p.pr_id
        INNER JOIN order_master om on om.order_master_id =oc.order_master_id
        WHERE om.order_master_id=$order_master_id AND user_id=$userid
        ORDER BY oc.order_child_id  ASC
      ";

      $query=$this->db->query($qry);
      return $query;
    }
    public function track_order($order_master_id)
    {
      $qry="SELECT status,status_text, DATE_FORMAT(created_date,'%d/%m/%Y %h:%i %p') AS status_date,created_date as status_date_24_formate
            FROM order_delivery_management
            WHERE order_master_id=$order_master_id ORDER BY id  ASC";
          $query=$this->db->query($qry);
          return $query;
    }
}
