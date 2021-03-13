<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Directbilling extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_management/Order_management_m','orders');
          $this->load->model('Direct_Billing_m','billing');
    }

    public function index()
    {
        $data['page'] = 'billing';
        $data['mainpage'] = 'billingMaster';
        $data['page_title'] = 'Billing';

        $bill_id=$this->input->get('bill_id');
        if($bill_id)
        {
          $data['bill_master_data']= $this->billing->get_bills('','',$bill_id);
          $data['bill_child_data']=$this->billing->get_bills_child($bill_id);
        }

        $this->template->page_maker('directbilling/home',$data);
    }

    public function get_productRow()
    {
      $pid=$this->input->post('pid');
      $index=$this->input->post('index');
        if($pid>0)
        {
         $qry="SELECT pr_id ,product_name,selling_price,available_stock,tax_id FROM products WHERE pr_id =$pid";
          $qrry=$this->db->query($qry);
          $produtcTr="";
          $rows=$qrry->num_rows();
            if($rows>0)
            {

              $rs=$qrry->row();
              $pid=$rs->pr_id;
              $product_name=$rs->product_name;
              $selling_price=$rs->selling_price;
              $available_stock=$rs->available_stock;
              $tax_id=$rs->tax_id;
              $tax_value=getAfield("tax_value","tax_master","where id=$tax_id");

              $del_id="deleterow_$index";
              $prName="productId_$index";
              $taxid="tax_$index";
              $taxValid="taxval_$index";
              $spId="sp_$index";
              $avstockid="avstock_$index";
              $qty="qty_$index";
              $tot_amnt="total_$index";
              $imeid="imei_$index";

              $produtcTr.='<td  width="25px" style="color:red;text-align:center"> <i style="font-size : 25px"  class="material-icons btnDelete" id="'.$del_id.'">delete</i> </td>
                            <td> '.$product_name.' </td>
                            <td>
                              <input type="text" class="fom-control form-control-sm"  value="" id="'.$imeid.'" name="'.$imeid.'"  />
                            </td>
                            <td class="hidden_td">
                              <input type="text" class="fom-control form-control-sm readonly" readonly value="'.$pid.'" id="'.$prName.'" name="'.$prName.'"  />
                            </td>
                            <td class="hidden_td">
                              <input type="text" class="fom-control form-control-sm readonly" readonly value="'.$tax_id.'"  id="'.$taxid.'" name="'.$taxid.'" />
                            </td>
                            <td class="hidden_td">
                              <input type="text" class="fom-control form-control-sm readonly" readonly value="'.$tax_value.'"  id="'.$taxValid.'"  name="'.$taxValid.'" />
                            </td>
                            <td>
                              <input type="text" class="fom-control form-control-sm readonly" readonly value="'.$available_stock.'" id="'.$avstockid.'" name="'.$avstockid.'" />
                            </td>
                            <td>
                              <input type="text" class="fom-control form-control-sm readonly amount" readonly value="'.$selling_price.'" id="'.$spId.'"  name="'.$spId.'" />
                            </td>
                            <td>
                              <input type="number" class="fom-control form-control-sm" onkeyUp="calcunit(this.id)"  value="0" id="'.$qty.'" name="'.$qty.'" />
                            </td>
                            <td>
                              <input type="text" class="fom-control form-control-sm readonly amount" readonly value="0" id="'.$tot_amnt.'" name="'.$tot_amnt.'" />
                            </td>
                          </tr>';
                          echo $produtcTr;
            }
            echo $produtcTr;

        }
    }

    public function save_biil()
    {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $createduser=$this->session->userdata('userid');
      $bill_date=$this->input->post('bill_date');
      $date = str_replace('/', '-', $bill_date);
      $bill_date=date('Y-m-d', strtotime($date));
      $b_master_id=$this->input->post('bill_master_id');

      $ins_main=array(
        'order_total'=>$this->input->post('payAmount'),
        'no_items'=>0,
        'mode_of_pay'=>$this->input->post('pay_type'),
        'bill_date'=>$bill_date,
        'customer_name'=>$this->input->post('cs_name'),
        'customer_mobile'=>$this->input->post('cs_mobile'),
        'customer_place'=>$this->input->post('cs_place'),
        'reference_number'=>$this->input->post('ref_number'),
        'imei_number'=>$this->input->post('imei_number'),
        'created_by'=>$createduser,
      );
      if($b_master_id==0)
      {
          $ins=insertInDb("direct_billing_master",$ins_main);
          $bill_master_id=$ins;
          $bill_id= $this->orders->generate_bill_numer($bill_master_id,1);
          $bill_number=getAfield("bill_text","bill_number","where id=$bill_id");
          $up_data['bill_id']=$bill_id;
          $up_data['bill_number']=$bill_number;
          $where=array('bill_master_id'=>$bill_master_id);
          $ins=update("direct_billing_master",$up_data,$where);
      }
      else{
         // delete child table
         $bill_master_id=$b_master_id;
         $where=array('bill_master_id'=>$bill_master_id);
         $ins=update("direct_billing_master",$ins_main,$where);
         $get_c_data=$this->billing->get_bills_child($bill_master_id);
         foreach($get_c_data->result() as $child)
         {
           $billing_child_id=$child->billing_child_id;
           $pid_c=$child->product_id;
           $qty_val=$child->qty;
           $updateStock=$this->orders->product_stock_updates('+',$qty_val,$pid_c);
           $de="DELETE FROM direct_billing_child WHERE billing_child_id =$billing_child_id";
           $de_qry=$this->db->query($de);
         }
      }
      $is_interstate=0;
      // CHILD DATA ENTRY
      $index=$this->input->post('total_rows');
      $ins_count=0;
      for($i=0;$i<=$index;$i++)
      {
        $prName="productId_$i";
        $taxid="tax_$i";
        $taxValid="taxval_$i";
        $spId="sp_$i";
        $avstockid="avstock_$i";
        $qtyId="qty_$i";
        $tot_amnt="total_$i";
        $imeid="imei_$i";
        $product_id=$this->input->post($prName);

        if($product_id>0)
        {
          $unit_rate=$this->input->post($spId);
          $qty=$this->input->post($qtyId);
          $total_amount=$unit_rate*$qty;
          $tax_id=$this->input->post($taxid);
          /*************** TAX CALCULATION*************************/
          $tax_value=$this->input->post($taxValid);
          $taxable=$total_amount/(100+$tax_value);
          $taxable_value=$taxable*100;
          $tax_amnt=($tax_value/100)*$taxable_value;
          if($is_interstate==1){
              $igst=$tax_amnt;
              $cgst=0;
              $sgst=0;
            }
          else{
            $igst=0;
            $cgst=$tax_amnt/2;
            $sgst=$cgst;
          }
        /***********************************************************/
        $imei=$this->input->post($imeid);
        $ins_child=array(
          'bill_master_id	'=>$bill_master_id,
          'product_id'=>$product_id,
          'unit_rate'=>$unit_rate,
          'qty'=>$qty,
          'total_amount'=>$total_amount,
          'tax_id'=>$tax_id,
          'tax_value'=>$tax_value,
          'taxable_value'=>$taxable_value,
          'tax_amount'=>$tax_amnt,
          'cgst'=>$cgst,
          'sgst'=>$sgst,
          'igst'=>$igst,
          'imei_note'=>$imei
          );
            $insrted_child_id=insertInDb("direct_billing_child",$ins_child);
            if($insrted_child_id)
            {
              $updateStock=$this->orders->product_stock_updates('-',$qty,$product_id);
              $ins_count++;
            }
        } // if productid>0
      } // end of for
      if($ins_count>0)
      {
        echo "1~$bill_master_id";
      }else  { echo "2~Unable to save"; }
    }


    public function print_invoice()
    {
        $bill_id=$this->input->get('order_id');

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        $mpdf->charset_in='UTF-8';
        $data=array();

        $order_details=$this->billing->get_order_master($bill_id);
        if($order_details)
        {
          $order_child=$this->billing->get_order_child_invoce($bill_id);
          $tax_summery=$this->billing->tax_summery($bill_id);

          $data['order_details']=$order_details;
          $data['order_child']=$order_child;
          $data['order_id']=$bill_id;
          $data['tax_summery']=$tax_summery;
          $html = $this->load->view('directbilling/invoice_view',$data,true);
          $mpdf->WriteHTML($html);
          $mpdf->Output('invoice.pdf', 'I');// opens in browser
        }
        else{
          echo "oops! somthing wrong";
        }

    }

    public function manage_bills()
    {
      $data['page'] = 'manage_bill';
      $data['mainpage'] = 'billingMaster';
      $data['page_title'] = 'Manage Bills';
      $this->template->page_maker('directbilling/manage_bills',$data);
    }

    public function get_bills()
    {
      if (!$this->input->is_ajax_request()) { exit('No direct script access allowed');}
      $from_date=$this->input->post('from_date');
      $date = DateTime::createFromFormat('d/m/Y', $from_date);
      $from_date=$date->format('Y-m-d');
      $to_date=$this->input->post('to_date');
      $date = DateTime::createFromFormat('d/m/Y', $to_date);
      $to_date=$date->format('Y-m-d');
      $filldata = $this->billing->get_bills($from_date,$to_date);

      $data=$filldata->result();
      $output = array(
        "recordsTotal" => $filldata->num_rows(),
        "recordsFiltered" => $filldata->num_rows(),
        "data" => $data
    );
      echo json_encode($output);
    }

    public function sales_report()
    {
      $data['page'] = 'direct_bill_report';
      $data['mainpage'] = 'billingMaster';
      $data['page_title'] = 'Sales Report';
      $this->template->page_maker('directbilling/sales_report',$data);
    }
    public function get_sales_report()
    {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $data = array();
      $filldata = $this->billing->sales_data();
      $output = array(
        "recordsTotal" => $filldata->num_rows(),
        "recordsFiltered" => $filldata->num_rows(),
        "data" => $filldata->result()
      );
      echo json_encode($output);
    }
}
?>
