<main>
<?php $this->template->datatables() ?>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/date_picker/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/date_picker/css/bootstrap-datepicker.min.css">

<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">Order Management</a></li>
		<li class="breadcrumb-item active" aria-current="page">Print Invoice</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>


<div class="row">
   <div class="col-md-12">

<!-- MODAL -->

<!--  End of modal -->
<div class="row">
  <div class="col-md-2">
    <label>Order Date From</label>
      <input type="text" class="form-control datepicker" id="from_date" value="<?php echo date('d/m/Y'); ?>"/>
  </div>
  <div class="col-md-2">
    <label>Order Date To</label>
      <input type="text" class="form-control datepicker" id="to_date" value="<?php echo date('d/m/Y'); ?>"/>
  </div>
  <div class="col-md-2">
    <label>Order Status</label>
      <select class="form-control" id="order_status">
          <option value="0">Select All</option>
          <option value="1">Order Placed</option>
          <option value="2">Order Packed</option>
          <option value="3">Order Shipped</option>
          <option value="4">Order Deliverd</option>
      </select>
  </div>
    <div class="col-md-2">
      <br />
      <button type="button" class="btn btn-primary" onclick="loadTb()">Load Orders</button>
    </div>
</div>
<hr />
        <div class="table-responsive">
          <table id="example" class="table table-hover table-striped table-bordered table-sm dt-responsive nowrap w-100">
            <!-- Filter columns -->
            <thead>
              <tr>
                <th>Sl No</th>
                <th>Print</th>
                <th>Order Total</th>
                <th>Order Number</th>
                <th>Order date</th>
                <th>Customer Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Order STatus</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
   </div>
</div>

</form>

</main>
<script src="<?php echo base_url() ?>assets/plugins/date_picker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/date_picker/js/bootstrap-datepicker.min.js.js"></script>

<script>
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
	csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	$(document).ready(function() {
    view='<a href="javascript:void(0)" class="btn btn-text-secondary btn-icon view_data rounded-circle"><i class="material-icons" stile="color:blue;font-size:8px;">print</i></a>';
    iDisplayIndex=0;
		table = $('#example').DataTable({
			'ajax': {
				  url: '<?php echo admin_url() ?>order_management/get_ivoices',
					type: 'POST',
          "data": function(d) {
              d.csrf_cipher_mobtrads_name=csrfHash;
              d.from_date=$("#from_date").val();
              d.to_date=$("#to_date").val();
              d.order_status=$("#order_status").val();
            }
			},
			"columns": [
					{ "data":"",render: function (data, type, row, meta) {
        return meta.row + meta.settings._iDisplayStart + 1;
    } },
          { "data" : "" },
          { "data": "order_total" },
					{ "data": "order_number" },
					{ "data": "order_date" },
          { "data": "name" },
          { "data": "mobile_number" },
          { "data": "email" },
          { "data": "pincode" },
      	],
        "columnDefs": [ {
             "targets": 1,
             "data": null,
             "defaultContent": view
         } ],
	});

  $('#example').on('click', '.view_data ', function() {
        var data = table.row($(this).parents('tr')).data();
        order_id=data.order_master_id;
        window.open("<?php echo admin_url() ?>order_management/print_invoice?order_id="+order_id, "_blank"); 
  });

});
function loadTb()
{
  table.ajax.reload();
}
$('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
//$('.datepicker').datepicker();
</script>
