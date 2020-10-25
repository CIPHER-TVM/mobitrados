<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_management_m extends CI_Model
{

  public function get_manage_orders($lstype)
  {
    $qry="SELECT DATE_FORMAT(om.created_date,'%d %M %Y - %H:%I') as order_date,om.*,
    au.name,ua.mobile_number,au.email,ua.pincode
    FROM order_master om
    INNER JOIN app_usres au on au.app_user_id=om.user_id
    INNER JOIN user_address ua on ua.address_id=om.address_id
    WHERE om.order_status=$lstype ORDER BY om.order_master_id ASC";
    return $this->db->query($qry);
  }
  public function get_order_child($order_id)
  {
    $qry="SELECT oc.* FROM order_child oc
          INNER JOIN order_master om on om.order_master_id=oc.order_master_id
          WHERE om.order_master_id=$order_id
          ORDER BY oc.order_child_id ASC";
    return $this->db->query($qry);
  }
  public function get_invoices($from_date,$to_date,$order_status)
  {
      $cond="";
      $cond.=" AND om.order_placed_date>='$from_date' AND om.order_placed_date<='$to_date'";
      if($order_status>0){
        $cond.=" om.order_status=$order_status";
      }

      $qry="SELECT DATE_FORMAT(om.created_date,'%d %M %Y - %H:%I') as order_date,om.*,
      au.name,ua.mobile_number,au.email,ua.pincode
      FROM order_master om
      INNER JOIN app_usres au on au.app_user_id=om.user_id
      INNER JOIN user_address ua on ua.address_id=om.address_id
      WHERE om.order_status!=0 $cond ORDER BY om.order_master_id DESC";
      return $this->db->query($qry);
  }

  public function get_order_master($order_id)
  {
    $qry="SELECT * FROM order_master WHERE order_master_id =$order_id";
    $qrry=$this->db->query($qry);
    return $qrry->row();
  }
  public function get_order_child_invoce($order_id)
  {
    $qry="SELECT oc.*,p.product_name FROM order_child oc
          INNER JOIN products p on p.pr_id = oc.product_id
          WHERE order_master_id =$order_id";
    $qrry=$this->db->query($qry);
    return $qrry->result();
  }
  public function tax_summery($order_id)
  {
    $qry="SELECT tax_value,sum(taxable_value) as taxable_value, sum(sgst) as sgst, sum(cgst) as cgst, sum(igst) as igst
    FROM order_child WHERE order_master_id=$order_id GROUP BY tax_value;
    ";
    $qrry=$this->db->query($qry);
    return $qrry->result();
  }
  public function get_address_details($address_id)
  {
    $qry="SELECT * FROM user_address WHERE address_id =$address_id";
    $qrry=$this->db->query($qry);
    return $qrry->row();
  }

}
