<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Direct_Billing_m extends CI_Model
{
    public function get_order_master($bill_id)
    {
      $qry="SELECT * FROM direct_billing_master WHERE bill_master_id  =$bill_id";
      $qrry=$this->db->query($qry);
      return $qrry->row();
    }

    public function get_order_child_invoce($bill_id)
    {
      $qry="SELECT oc.*,p.product_name FROM direct_billing_child oc
            INNER JOIN products p on p.pr_id = oc.product_id
            WHERE bill_master_id =$bill_id";
      $qrry=$this->db->query($qry);
      return $qrry->result();
    }

    public function tax_summery($bill_id)
    {
      $qry="SELECT tax_value,sum(taxable_value) as taxable_value, sum(sgst) as sgst, sum(cgst) as cgst, sum(igst) as igst
      FROM direct_billing_child WHERE bill_master_id=$bill_id GROUP BY tax_value;
      ";
      $qrry=$this->db->query($qry);
      return $qrry->result();
    }

    public function get_bills($from_date,$to_date,$bill_id=0)
    {
      $cond="";
      if($from_date && $to_date)
      {
          $cond.=" AND bill_date>='$from_date' AND bill_date<='$to_date'";
      }

      if($bill_id)
      {
        $cond.=" AND bill_master_id=$bill_id";
      }
      $qry="SELECT bill_master_id , DATE_FORMAT(bill_date,'%d %M %Y - %H:%I') as bill_date,direct_billing_master.*
        FROM direct_billing_master
        WHERE is_canceled=0 $cond
        ";
      return $this->db->query($qry);
    }

    public function get_bills_child($bil_id=0)
    {
      $qry="SELECT dc.*,p.product_name FROM direct_billing_child dc
          INNER JOIN products p on p.pr_id =dc.product_id WHERE dc.bill_master_id=$bil_id
      ";
        return $this->db->query($qry);
    }
    public function sales_data()
    {
      $from_date=$this->input->post('from_date');
      $date = DateTime::createFromFormat('d/m/Y', $from_date);
      $from_date=$date->format('Y-m-d');

      $to_date=$this->input->post('to_date');
      $date = DateTime::createFromFormat('d/m/Y', $to_date);
      $to_date=$date->format('Y-m-d');

    //  $qry="SELECT * FROM direct_billing_master where bill_date>='$from_date' and bill_date<='$to_date' and is_canceled=0 order by bill_date ASC";
$cond="";
    $mode_of_pay=$this->input->post('mode_of_pay');
    if($mode_of_pay)
    {
      $cond.= " AND om.mode_of_pay=$mode_of_pay";
    }

      $qry="SELECT om.bill_master_id ,om.bill_number,ROUND(om.order_total,2) AS order_total,
          DATE_FORMAT(om.bill_date,'%d/%m/%Y') AS order_placed_date,
          oc.cgst,oc.sgst,oc.igst,oc.total_items,
          om.customer_name,om.customer_mobile,
CASE om.mode_of_pay
WHEN 1 then 'Cash'
WHEN 2 then 'Card'
WHEN 3 then 'Cheque'
WHEN 4 then 'UPI'
end as mode_of_pay
          FROM direct_billing_master om
          INNER JOIN
          (
            SELECT bill_master_id,ROUND(sum(cgst),3) as cgst,ROUND(sum(sgst),3) as sgst,ROUND(sum(igst),3) as igst,count(billing_child_id) as total_items
            FROM direct_billing_child GROUP BY bill_master_id
          )oc
          ON oc.bill_master_id=om.bill_master_id
          WHERE bill_date>='$from_date' AND bill_date<='$to_date' $cond
          ORDER BY om.bill_date ASC
          ";
      return $this->db->query($qry);
    }
}
