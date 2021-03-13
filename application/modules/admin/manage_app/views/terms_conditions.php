<main>
<?php $this->template->datatables() ?>
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">App Management</a></li>
		<li class="breadcrumb-item active" aria-current="page">Terms And Conditions</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>

    <div class="row">
        <div class="col-md-7">
  <?php 
  $terms=getAfield("app_terms","terms_conditions","where id=(select max(id) from terms_conditions)");
  ?>
            <label>Update Terms And Conditions</label>
            <textarea id="terms" name="terms"><?=$terms?></textarea>
            <br>
            <button onclick="save_terms()" type="button" class="btn btn-info">Update</button>
        </div>
    </div>

</form>

</main>

<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>

<script>
CKEDITOR.replace('terms');
CKEDITOR.config.height = '20em';

var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

function save_terms()
{
    for (instance in CKEDITOR.instances)
	  {
	    CKEDITOR.instances[instance].updateElement();
	  }
    var form = $('#frm')[0];
    var formData = new FormData(form);
    $.ajax({
	   type: "POST",
	   url: '<?php echo admin_url() ?>manage_app/save_terms',
	   data: formData,
		 processData: false,
		 contentType: false,
	    success: function(result){
            if(result==1)
            {
                notify_msg("success","<h5>Success..!</h5> ");
            }
            else{
                notify_msg("error","<h5>Error..!</h5>"+result);
            }

	     }
	 });
    
}

</script>
