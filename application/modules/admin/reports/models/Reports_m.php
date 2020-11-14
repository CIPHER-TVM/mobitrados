<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_m extends CI_Model
{
  public function product_data()
  {
    $cond="";
    $cat_id=$this->input->post('category');
    $product_name=$this->input->post('product_name');
    $status=$this->input->post('status');
    if($cat_id>0){
      $cond.=" AND pd.product_catogory=$cat_id" ;
    }
    if($product_name){
      $cond.=" AND pd.product_name like '%$product_name%'" ;
    }
    if($status!=""){
      $cond.=" AND pd.display_status=$status" ;
    }

    $qry="SELECT pd.*,pc.product_catogory_name FROM  products pd
    INNER JOIN product_catogory pc ON pc.pcid=pd.product_catogory
    WHERE pd.is_deleted=0 $cond ORDER BY pd.product_name ASC";
    $result=$this->db->query($qry);
    return $result;
  }
  public function basic_sales_data()
  {
    $from_date=$this->input->post('from_date');
    $date = DateTime::createFromFormat('d/m/Y', $from_date);
    $from_date=$date->format('Y-m-d');

    $to_date=$this->input->post('to_date');
    $date = DateTime::createFromFormat('d/m/Y', $to_date);
    $to_date=$date->format('Y-m-d');

    $status=$this->input->post('status');

    $qry="SELECT om.order_master_id,om.order_number,om.bill_number,ROUND(om.order_total,2) AS order_total,om.no_items,ROUND(om.shipping_charge,2) as shipping_charge,
        DATE_FORMAT(om.order_placed_date,'%d/%m/%Y') AS order_placed_date,
        oc.cgst,oc.sgst,oc.igst,
        au.name,au.mobile_number FROM order_master om
        INNER JOIN app_usres au on au.app_user_id =om.user_id
        INNER JOIN
        (
          SELECT order_master_id,ROUND(sum(cgst),3) as cgst,ROUND(sum(sgst),3) as sgst,ROUND(sum(igst),3) as igst
          FROM order_child GROUP BY order_master_id
        )oc
        ON oc.order_master_id=om.order_master_id
        WHERE order_placed_date>='$from_date' AND order_placed_date<='$to_date'
        AND order_cancel=$status ORDER BY om.order_placed_date ASC
        ";
        $result=$this->db->query($qry);
        return $result;
  }
  public function product_sales_data()
  {
    $from_date=$this->input->post('from_date');
    $date = DateTime::createFromFormat('d/m/Y', $from_date);
    $from_date=$date->format('Y-m-d');

    $to_date=$this->input->post('to_date');
    $date = DateTime::createFromFormat('d/m/Y', $to_date);
    $to_date=$date->format('Y-m-d');
    $cond="";
    $category=$this->input->post('category');
    if($category) $cond=" AND p.product_catogory=$category";
    $product_name=$this->input->post('product_name');
    if($product_name) $cond=" AND p.product_name like '%$product_name%'";

    $qry="SELECT p.pr_id,p.product_name,
    oc.qty,ROUND(oc.unit_rate,2) as  unit_rate ,ROUND(oc.total_amount,2) as total_amount,oc.tax_value,ROUND(oc.taxable_value,3) as taxable_value,
    ROUND(oc.cgst,3) as cgst,ROUND(oc.sgst,3) as sgst, ROUND(oc.igst,3) as igst,DATE_FORMAT(oc.order_placed_date,'%d/%m/%Y') AS order_placed_date
    FROM products p
    INNER JOIN
    (
      SELECT oc.product_id,oc.unit_rate,om.order_placed_date,
      sum(oc.qty) as qty,sum(oc.total_amount) as total_amount,oc.tax_value,sum(oc.taxable_value) as taxable_value,
      sum(oc.cgst) as cgst,sum(oc.sgst) as sgst,sum(oc.igst) as igst
      FROM order_child oc INNER JOIN
      order_master om on om.order_master_id =oc.order_master_id
      WHERE om.order_placed_date>='$from_date' AND om.order_placed_date<='$to_date' AND om.order_cancel=0
      GROUP BY oc.product_id,oc.unit_rate,oc.tax_value,om.order_placed_date
    )oc
    on oc.product_id=p.pr_id
    WHERE 1=1 $cond
    ";
    $result=$this->db->query($qry);
    return $result;

  }
}
