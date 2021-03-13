<main>
<?php $this->template->datatables() ?>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/date_picker/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/date_picker/css/bootstrap-datepicker.min.css">

<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">Direct Billing</a></li>
		<li class="breadcrumb-item active" aria-current="page">Manage Bills</li>
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
    <label>Bill Date From</label>
      <input type="text" class="form-control datepicker" id="from_date" value="<?php echo date('d/m/Y'); ?>"/>
  </div>
  <div class="col-md-2">
    <label>Bill Date To</label>
      <input type="text" class="form-control datepicker" id="to_date" value="<?php echo date('d/m/Y'); ?>"/>
  </div>
    <div class="col-md-2">
      <br />
      <button type="button" class="btn btn-primary" onclick="loadTb()">Load Bills</button>
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
								 <th>Edit</th>
                <th>Bill Total</th>
                <th>Bill Number</th>
                <th>Bill date</th>
                <th>Customer Name</th>
                <th>Mobile</th>
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
    edit='<a href="javascript:void(0)" class="btn btn-text-secondary btn-icon edit_data rounded-circle"><i class="material-icons" stile="color:blue;font-size:8px;">edit</i></a>';
    iDisplayIndex=0;
		table = $('#example').DataTable({
			'ajax': {
				  url: '<?php echo admin_url() ?>directbilling/get_bills',
					type: 'POST',
          "data": function(d) {
              d.csrf_cipher_mobtrads_name=csrfHash;
              d.from_date=$("#from_date").val();
              d.to_date=$("#to_date").val();

            }
			},
			"columns": [
					{ "data":"",render: function (data, type, row, meta) {
        return meta.row + meta.settings._iDisplayStart + 1;
    } },
          { "data" : "" },
          { "data" : "" },
          { "data": "order_total" },
					{ "data": "bill_number" },
					{ "data": "bill_date" },
          { "data": "customer_name" },
          { "data": "customer_mobile" }
        ],
        "columnDefs": [ {
             "targets": 1,
             "data": null,
             "defaultContent": view
         },
       {
         "targets": 2,
         "data": null,
         "defaultContent": edit
       } ],
	});

  $('#example').on('click', '.view_data ', function() {
        var data = table.row($(this).parents('tr')).data();
        order_id=data.bill_master_id ;
        window.open("<?php echo admin_url() ?>directbilling/print_invoice?order_id="+order_id, "_blank");
  });
  $('#example').on('click', '.edit_data ', function() {
        var data = table.row($(this).parents('tr')).data();
        order_id=data.bill_master_id ;
        window.open("<?php echo admin_url() ?>directbilling/index?bill_id="+order_id, "_self");
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
