<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Public_api_model extends CI_Model {
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
    function get_banner()
    {

          $base_url=base_url();
          $image="CONCAT('$base_url',image_path) as image_path";
          $this->db->select(array('bid','heading','sub_heading',$image));
          $this->db->from('banner');
          $this->db->where(array('display_status' => 1,'is_deleted'=>0));
          $query = $this->db->get();
          return $query;
    }
    function get_disp_products($display_type,$serach_item)
    {
      $cond="";
      if($serach_item)
      {
        $cond=" AND (p.product_name LIKE '%$serach_item%' OR p.keywords LIKE '%$serach_item%' )";
      }
      $base_url=base_url();
      $offer_banner="CONCAT('$base_url',apd.banner_path) as offer_banner";
      $image_path="CONCAT('$base_url',pdi.image_path) as product_image";
      $qry="SELECT apd.display_type,$offer_banner,
      p.pr_id,p.product_name, p.product_dispn,p.mrp,p.selling_price,p.available_stock,p.product_catogory,
      $image_path,pdi.img_id
      FROM  app_product_display apd
      INNER JOIN  products p  ON p.pr_id=apd.product_id

      INNER JOIN product_catogory pc ON  p.product_catogory=pc.pcid
      INNER JOIN
         (
             SELECT product_id,  image_path,max(img_id) img_id
             FROM product_images
             GROUP BY product_id
         ) pdi ON pdi.product_id = p.pr_id

      WHERE p.display_status=1 AND p.is_deleted=0 $cond
      AND  apd.display_status=1 AND apd.is_deleted=0 AND apd.display_type=$display_type
      AND pc.display_status=1 AND pc.is_deleted=0 AND p.available_stock>0
      ";

      $query=$this->db->query($qry);
      return $query;
    }
    function get_product_details($pr_id)
    {
      $this->db->select('*');
      $this->db->from('products');
      $this->db->where(array('display_status' => 1,'is_deleted'=>0));
      $query = $this->db->get();
      return $query;
    }
    function get_product_images($pr_id)
    {
      $this->db->select('*');
      $this->db->from('product_images');
      $this->db->where(array('is_deleted'=>0,'product_id'=>$pr_id));
      $query = $this->db->get();
      return $query->result();
    }
    function get_product_list($data)
    {
        $serach_item = $data['serach_item'];
        $category_id = $data['category_id'];
        $lower_limit = $data['lower_limit'];
        $upper_limit = $data['upper_limit'];
        $order_by = $data['order_by'];
        $order_by_type=$data['order_by_type'];

        $cond="";
        $limit="";
        $orderby="";
        if($serach_item){
          $cond.=" AND (p.product_name LIKE '%$serach_item%' OR p.keywords LIKE '%$serach_item%' ) ";
        }
        if($category_id){
          $cond.=" AND p.product_catogory=$category_id";
        }

        if($order_by)
        {
              if(!$order_by_type) $order_by_type="ASC";
              if($order_by==1)  $orderby=" ORDER BY p.product_name $order_by_type";
              else  if($order_by==2)  $orderby=" ORDER BY p.selling_price $order_by_type";
        }
        if($upper_limit>0)
        {
            if(!$lower_limit) $lower_limit=0;
                $limit=" LIMIT $lower_limit,$upper_limit";
        }

        if($cond=="" && $limit==""){
            $limit=" LIMIT 0,20";
        }

        $qry="SELECT p.pr_id,p.product_name, p.product_dispn,p.mrp,p.selling_price,p.available_stock,p.product_catogory,
              pdi.image_path as product_image,pdi.img_id
              FROM products p
              INNER JOIN product_catogory pc ON  p.product_catogory=pc.pcid
              INNER JOIN
                 (
                     SELECT product_id,  image_path,max(img_id) img_id
                     FROM product_images
                     GROUP BY product_id
                 ) pdi ON pdi.product_id = p.pr_id
              WHERE  p.display_status=1 AND p.is_deleted=0 AND p.available_stock>0
              AND pc.display_status=1 AND pc.is_deleted=0
              $cond
              $orderby
              $limit
              ";
              $query=$this->db->query($qry);
              return $query;
    }
    public function get_categories()
    {
        $base_url=base_url();
        $icon="CONCAT('$base_url',icon) as icon";
        $qry="SELECT pcid,product_catogory_name,$icon FROM product_catogory WHERE display_status=1 AND is_deleted=0";
        $query=$this->db->query($qry);
        return $query;
    }
}
