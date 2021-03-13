<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/date_picker/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/date_picker/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/noty/noty.min.css">
<style>
.table-hover tbody tr:hover {
	background-color: rgba(0, 0, 0, 0.8);
	color: white;
}
.left-col {
    float: left;
    width: 25%;
}

.center-col {
    float: left;
    width: 50%;
}

.right-col {
    float: left;
    width: 25%;
}
.readonly
{
	background-color: #ececec;
}
.amount
{
	text-align: right;
}
.hidden_td
{
	display: none;
}
</style>

<main>
<?php // $this->template->datatables() ?>
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">Direct Billing</a></li>
		<li class="breadcrumb-item active" aria-current="page">Billing</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>

<div class="row">
  <div class="col-md-4">
      <label>Select Product</label>
      <select class="form-control select2" id="sel_product" onchange="loadproduct(this.value)">
          <option value="">Select A Product</option>
          <?php LoadCombo("products","pr_id","product_name",'',"where is_deleted=0 AND display_status=1","order by product_name"); ?>
      </select>
  </div>
  <div class="col-md-2">
    <label>Date</label>
      <input readonly type="text" class="form-control form-control-sm datepicker" name="bill_date" id="from_date" value="<?php echo date('d/m/Y'); ?>"/>
  </div>
	  <div class="col-md-2">
				<br />
				<button type="button" class="btn btn-success" onclick="saveBill()">Save Bill</button>
		</div>
</div>

<br />
<?php
	if(isset($bill_master_data))
	{
			$bill_m_data=$bill_master_data->row();
			$net_qty=$bill_m_data->no_items;
			$bill_master_id =$bill_m_data->bill_master_id;
			$order_total =$bill_m_data->order_total;
			$mode_of_pay =$bill_m_data->mode_of_pay;
			$customer_name =$bill_m_data->customer_name;
			$customer_mobile =$bill_m_data->customer_mobile;
			$customer_place =$bill_m_data->customer_place;
			$reference_number =$bill_m_data->reference_number;
			$imei_number=$bill_m_data->imei_number;
	}
	else{
		$net_qty=0;
		$mode_of_pay=0;
		$bill_master_id=0;
		$customer_name="";
		$customer_mobile="";
		$order_total=0;
		$reference_number="";
		$customer_place="";
		$imei_number="";
	}
?>
<div class="row">
   <div class="col-md-12">
<!--- END OF MODEL -->
<div class="alert alert-info" style="text-align: center;padding:5px 5px 5px 5px">
		Sales Details
</div>

<input type="hidden" name="bill_master_id" id="bill_master_id" value="<?=$bill_master_id?>" />
        <div class="table-responsive">
          <table id="productdetails" class="table table-striped table-bordered table-sm dt-responsive nowrap w-100 table-hover">
            <thead>
              <tr style="background-color: #d7c2ff;">
							<th width="25px">Remove</th>
              <th>Product Name</th>
							<th>IMEI/Note</th>
              <th>In Stock</th>
              <th>Rate</th>
							<th>Qty</th>
							<th>Total Price</th>
							</tr>
            </thead>
            <tbody id="">
							<?php
							$produtcTr="";
							$index=0;
							$tq=0;
							$tp=0;

							if(isset($bill_child_data))
							{
								foreach($bill_child_data->result() as $child)
								{
								//	print_r($child); exit;
									$product_name=$child->product_name;
									$pid=$child->product_id;
									$tax_id=$child->tax_id;
									$tax_value=$child->tax_value;
									$qty_val=$child->qty;
									$tq=$tq+$qty_val;
									$ext_stock=getAfield("available_stock","products","where pr_id =$pid");
									$available_stock=$ext_stock+$qty_val;
									$selling_price=$child->unit_rate;
									$tot_amnt_val=$child->total_amount;
									$tp=$tp+$tot_amnt_val;
									$imei_note=$child->imei_note;
									$del_id="deleterow_$index";
		              $prName="productId_$index";
		              $taxid="tax_$index";
		              $taxValid="taxval_$index";
		              $spId="sp_$index";
		              $avstockid="avstock_$index";
		              $qty="qty_$index";
		              $tot_amnt="total_$index";
									$imeid="imei_$index";
									$produtcTr.='
									<tr id="'.$index.'">
									<td  width="25px" style="color:red;text-align:center"> <i style="font-size : 25px"  class="material-icons btnDelete" id="'.$del_id.'">delete</i> </td>
		                            <td> '.$product_name.' </td>
																<td>
																	<input type="text" class="fom-control form-control-sm"  value="'.$imei_note.'" id="'.$imeid.'" name="'.$imeid.'"  />
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
		                              <input type="number" class="fom-control form-control-sm" onkeyUp="calcunit(this.id)"  value="'.$qty_val.'" id="'.$qty.'" name="'.$qty.'" />
		                            </td>
		                            <td>
		                              <input type="text" class="fom-control form-control-sm readonly amount" readonly value="'.$tot_amnt_val.'" id="'.$tot_amnt.'" name="'.$tot_amnt.'" />
		                            </td>
		                          </tr>';
										$index++;
								}
								echo $produtcTr;
							}
							?>
            </tbody>
						<tfoot>
								<tr>
										<td colspan="4">Total</td>
										<td style="width:100px;"><input type="text"  class="form-control form-control-sm" readonly id="netQty"  name="netQty" value="<?=$tq?>" /></td>
										<td style="width:100px;"><input type="text"  class="form-control form-control-sm" readonly id="netAmount" name="netAmount" value="<?=$tp?>" style="text-align: right" /></td>
								</tr>
						</tfoot>

          </table>
        </div>
				<input type="hidden" name="total_rows" id="total_rows" value="<?=$index?>" />
				<div class="alert alert-info" style="text-align: center;padding:5px 5px 5px 5px">
						Bill Details
				</div>
				<div class="row">
						<div class="col-md-6" style="border:1px solid #CCC">
								<div class="form-group" style="display: none">
									<label>IMEI Numbers </label>
									<input type="text" class="form-control form-control-sm" name="imei_number" id="imei_number" value="<?=$imei_number?>" />
									</div>
										<div class="form-group">
											<label>Customer's Name <span class="star">*</span></label>
											<input type="text" class="form-control form-control-sm" name="cs_name" id="cs_name" value="<?=$customer_name?>" />

										</div>

								<div class="form-group">
											<label>Customer's Mobile</label>
											<input type="text" class="form-control form-control-sm" name="cs_mobile" id="cs_mobile" value="<?=$customer_mobile?>" />
								</div>

								<div class="form-group">
										<label>Customer's Place</label>
										<input type="text" class="form-control form-control-sm" name="cs_place" id="cs_place" value="<?=$customer_place?>"  />
								</div>
						</div>
						<div class="col-md-6" style="border:1px solid #CCC">
							<div class="form-group">
									<label>Total Bill Amount</label>
									<input type="text" class="form-control form-control-sm"  readonly id="payAmount" value="<?=$order_total?>" name="payAmount" style="text-align: right"/>
							</div>
							<div class="form-group">
									<label>Mode Of Pay</label>
									<select  class="form-control form-control-sm" name="pay_type" id="pay_type" />
										<option  value="1" <?php if($mode_of_pay==1) echo"selected"; ?>>Cash</option>
										<option  value="2" <?php if($mode_of_pay==2) echo"selected"; ?>>Card</option>
										<option  value="3" <?php if($mode_of_pay==3) echo"selected"; ?>>Cheque</option>
										<option  value="4" <?php if($mode_of_pay==4) echo"selected"; ?>>UPI</option>
									</select>
							</div>
							<div class="form-group">
									<label>Reference Number</label>
									<input type="text" class="form-control form-control-sm" name="ref_number" id="ref_number"  value="<?=$reference_number?>"/>
							</div>
						</div>
				</div>
   </div>
</div>

</form>

</main>
<script src="<?php echo base_url() ?>assets/plugins/date_picker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/date_picker/js/bootstrap-datepicker.min.js.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/noty/noty.min.js"></script>
<script>
$(".select2").select2();
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
$('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });

function loadproduct(pid)
{
	var index=Number($("#total_rows").val());
	for(var j=0;j<=index;j++)
	{
			if(document.getElementById("qty_"+j))
			{
					dup_pr_id=$("#productId_"+j).val();
					if(dup_pr_id==pid)
					{
						alert("Product Already added");
						return false;
					}
			}

	}

	let ajaxval = {
    pid: pid,
		index:index,
    [csrfName]: csrfHash
  };
//	index=1;
	$.ajax({
	 type: "POST",
	 url: '<?php echo admin_url() ?>directbilling/get_productRow',
	 data: ajaxval,
	 	success: function(data){
			//productdetails
			var newRow = $("<tr id="+index+">");
			newRow.append(data);
			newRow.id=index;
	 	 	$("#productdetails tr:first").after(newRow);  //open after  scroll
			index++;
			$("#total_rows").val(index);
		 }
 });
}
function calcunit(eid)
{
	eid=eid.split('_');
	index=eid[1];
	qty=Number($("#qty_"+index).val());
	if(!qty || isNaN(qty)) qty=0;

	sp=Number($("#sp_"+index).val());
	avstock=Number($("#avstock_"+index).val());

	if(qty>avstock)
	{
		qty=0;
		$("#qty_"+index).val(0);
		alert("Qty cannot be larger than available stock");
	}

	unitprice=qty*sp;
	unitprice=unitprice.toFixed(2);
	$("#total_"+index).val(unitprice);
	calcnet();

}
function calcnet()
{
	index=Number($("#total_rows").val());
	totqty=0;
	totprice=0;
	for(var i=0;i<=index;i++)
	{
		if(document.getElementById("qty_"+i))
		{
			qty=Number($("#qty_"+i).val());
			unit_total=Number($("#total_"+i).val());
			totqty=totqty+qty;
			totprice=totprice+unit_total;
		}

	}
	totprice=totprice.toFixed(2);
	$("#payAmount").val(totprice);
	$("#netAmount").val(totprice);
	$("#netQty").val(totqty);

}

$("#productdetails").on('click', '.btnDelete', function () {
	$(this).closest('tr').remove();
	calcnet();
})

function saveBill()
{
	var netQty=$("#netQty").val();
	cs_mobile=$("#cs_mobile").val();

	if(netQty>0)
	{
		csname=$("#cs_name").val();
			if(csname=="")
			{
				new Noty({
						type: 'warning',
						text: '<h5>Warning..!</h5>Customer Name Required',
						timeout: 2000
				}).show()

				return false;
			}


			/// save bill

			var form = $('#frm')[0];
			var formData = new FormData(form);


				$.ajax({
				 type: "POST",
				 url: '<?php echo admin_url() ?>directbilling/save_biil',
				 data: formData,
				 processData: false,
				 contentType: false,
				 success: function(result){
					 		result=result.split('~');
							op=result[0];

							if(op==1)
							{
								msg="Bill saved Successfully";
								notify_msg("success","<h5>Success..!</h5> "+msg);
								billid=result[1];
								window.open("<?php echo admin_url() ?>directbilling/print_invoice?order_id="+billid, "_blank");
								alert("Bill saved Successfully");

								location.reload();
							}
							else{
								notify_msg("error","<h5>Error..!</h5>"+result);
							}

					 }
			 });

	}
	else{
		new Noty({
				type: 'warning',
				text: '<h5>Warning..!</h5>Minimum one qty is required to save the bill',
				timeout: 2000
		}).show()
	}

}
</script>
