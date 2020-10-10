Category<!-- Font & Icon -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Plugins -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/datatables/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/bootstrap-select/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/noty/noty.min.css">

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
    }

    .bootstrap-select .dropdown-toggle .filter-option-inner-inner {
        overflow: hidden;
        padding-left: 1.8rem;
    }

    .dropdown-menu {
        font-size: 0.8rem;
        max-height: 10rem;
    }

    .star {
        color: red;
    }
		.bigbtn{
		padding: 6px;
		font-size: 15px;
	}
</style>
<main>
    <h5>Add Product Catagory</h5>
    <table id="example" class="table table-hover table-bordered table-sm dt-responsive nowrap w-100">
        <!-- Filter columns -->
        <thead>
            <tr>
                <th>Serial No</th>
                <th>Category</th>
                <th>Display Status</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>pcid</th>
            </tr>
        </thead>
        <!-- /Filter columns -->
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <button onclick="changeUpdateToSave(); clearForm();" type="button" class="bigbtn col-md-12 btn btn-primary shadow-sm btn-xs text-center" data-toggle="modal" data-target="#verticalModal">Add Category</button>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <?php
     $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
      echo form_open('',$atributes);
    ?>

    <!-- Vertically centered -->
    <div class="modal fade" id="verticalModal" tabindex="-1" role="dialog" aria-labelledby="verticalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="verticalModalLabel"><strong> <u id="m-title">Add/Update Category </u> </strong> </h6>
                    <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
                        <i class="material-icons">close</i>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="alert alert-warning">
        <strong>Upload Instructions!</strong> <br /> Allowed Types-  png  <br />
        Upload size  256*256
      </div>
                    </div>
                  </div>

                    <div class="row">
                        <input style="display : none" id="hidscid" name="hidscid" type="text" class="form-control form-control-sm" placeholder="Place name">
                        <div class="col-md-12">
                            <label style="font-size : 15px">Category name<span class="star">*</span></label>
                            <span class="input-icon">
                                <i style="font-size : 19px" class="material-icons">add_shopping_cart</i>
                                <input id="catagoryName" name="catagoryName" type="text" class="form-control form-control-sm" placeholder="Category name">
                            </span>
                        </div>

          								<div class="col-md-12">
          		              <label style="font-size : 15px">Select Image <span class="star">*</span></label> <br />

          		              <span class="input-icon">
          		                <i style="font-size : 19px" class="material-icons">add_box</i>
          		                <input id="uploaded_file" name="uploaded_file"  type="file" class="form-control" placeholder="Tax %">
          		              </span>
          		            </div>

                        <div class="col-md-12">
                            <br />
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="displayStatus" checked name="displayStatus" value="1">
                                <label style="font-size : 14px;" class="custom-control-label" for="displayStatus">Active Status</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-xs" data-dismiss="modal">Close</button>
                    <div id="SaveOrUpdate">
                        <button onclick="AddCatagory()" type="button" class="btn btn-primary btn-xs">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</main>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/datatables/jquery.dataTables.bootstrap4.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/bootbox/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/noty/noty.min.js"></script>
<!-- <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script> -->
<script>
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
  csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    const BASE_URL = '<?php echo base_url(); ?>';
    var table;

    $(document).ready(function() {
        LoadDataTable();
    });

    var changeUpdateToSave = () => $('#SaveOrUpdate').html('<button onclick="AddCatagory()" type="button" class="btn btn-primary btn-xs">Save</button>');

    var clearForm = () => $('#catagoryName').val('');

    $('#example tbody').on('click', 'tr button', function() {

        if (this.id == 'Edit') {
            //alert(table.row( this.closest('tr') ).data().pcid);
            GetCatagoryById(table.row(this.closest('tr')).data().pcid);
        } else {
            //alert(table.row( this.closest('tr') ).data().pcid);
            DeleteCatagory(table.row(this.closest('tr')).data().pcid);
        }
    });

    var DeleteCatagory = pcid => {
        const confirmRemove = bootbox.confirm({
            message: 'Are you sure to delete this data permanently?',
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-danger'
                }
            },
            callback: result => {
                if (result) {
                    let ajaxval = {
                        pcid: pcid,
                        [csrfName]: csrfHash
                    };
                    $.ajax({
                        url: BASE_URL + 'webuser/category/DeleteCatagory',
                        type: 'post',
                        data: ajaxval,
                        success: function(response) {
                            if (response) {
                                reloadTable();
                                new Noty({
                                    type: 'success',
                                    text: '<h5>Success...!</h5>Data deleted successfully',
                                    timeout: 2000
                                }).show()
                            } else
                                new Noty({
                                    type: 'danger',
                                    text: '<h5>Error...!</h5>unexpected error',
                                    timeout: 2000
                                }).show()
                        }
                    });
                }
            }
        })
    }

    var GetCatagoryById = (pcid) => {

        // alert(pcid);
        let ajaxval = {
            pcid: pcid,
            [csrfName]: csrfHash
        };
        $.ajax({
            url: BASE_URL + 'webuser/category/GetCatagoryById',
            type: 'post',
            data: ajaxval,
            success: function(response) {
                // alert(response);
                Populate(JSON.parse(response));
            }
        });
    }

    var Populate = (plan) => {
        //console.log(plan);
        $('#hidscid').val(plan[0].pcid);
        $('#catagoryName').val(plan[0].product_catogory_name);
      //  $("m-title").html('Edit Category');
        $('#SaveOrUpdate').html('<button onclick="UpdateCatagory()" type="button" class="btn btn-primary btn-xs">Update</button>');
        $('#verticalModal').modal('show');
    }

    var LoadDataTable = () => {
        $(() => {
            // Run datatable

            table = $('#example').DataTable({
                ajax: {
                    url: BASE_URL + 'webuser/category/GetAllCatagoryDT',
                    type: 'post',
                    data:{[csrfName]: csrfHash},
                    complete: function(response) {
                        console.log(response);

                    }

                },
                columns: [{
                        data: 'serialNo'
                    },
                    {
                        data: 'product_catogory_name'
                    },
                    {
                        data: 'display_status'
                    },
                    {
                        data: 'editInnerHTML'
                    },
                    {
                        data: 'deleteInnerHTML'
                    },
                    {
                        data: 'pcid'
                    }
                ],
                columnDefs: [{
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }],
                drawCallback: function() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-sm') // make pagination small
                }
            })

            // Apply column filter
            $('#example .dt-column-filter th').each(function(i) {
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw()
                    }
                })
            })
            // Toggle Column filter function
            var responsiveFilter = function(table, index, val) {
                var th = $(table).find('.dt-column-filter th').eq(index)
                val === true ? th.removeClass('d-none') : th.addClass('d-none')
            }
            // Run Toggle Column filter at first
            $.each(table.columns().responsiveHidden(), function(index, val) {
                responsiveFilter('#example', index, val)
            })
            // Run Toggle Column filter on responsive-resize event
            table.on('responsive-resize', function(e, datatable, columns) {
                $.each(columns, function(index, val) {
                    responsiveFilter('#example', index, val)
                })
            })

            $('.bs-select').selectpicker({
                style: 'btn'
            })
            $('.bootstrap-select').on('show.bs.select', function() {
                this.querySelector('.dropdown-toggle').classList.add('focus')
            }).on('hide.bs.select', function() {
                this.querySelector('.dropdown-toggle').classList.remove('focus')
            })
            $('.bs-select-creatable').selectpicker({
                style: 'btn',
                liveSearch: true,
                noneResultsText: 'Press Enter to add: <b>{0}</b>'
            })

            $('.bs-select-creatable .bs-searchbox .form-control').on('keyup', function(e) {
                const bs = this.closest('.bootstrap-select')
                if (bs.querySelector('.no-results')) {
                    if (e.keyCode === 13) {
                        let el = bs.querySelector('select')
                        el.insertAdjacentHTML('afterbegin', `<option value="${$(this).val()}">${$(this).val()}</option>`)
                        let newVal = $(el).val()
                        Array.isArray(newVal) ? newVal.push(this.value) : newVal = this.value
                        console.log(newVal)
                        $(el).val(newVal)
                        $(el).selectpicker('toggle')
                        $(el).selectpicker('refresh')
                        bs.querySelector('.dropdown-toggle').focus()
                        this.value = ''
                    }
                }
            })

        })
    }
    var reloadTable = () => table.ajax.reload();

  function AddCatagory(crude=1)
  {
    let catagoryName = $('#catagoryName').val();
    let displayStatus = ($('#displayStatus').prop('checked')) ? 1 : 0;
    let uploaded_file= $('#uploaded_file')[0].files[0];

    if (catagoryName == '' || uploaded_file=="") {
      new Noty({
          type: 'warning',
          text: '<h5>Warning..!</h5>Plese fill all mandatory fields',
          timeout: 2000
      }).show()
      return false;
    }
    uploaded_file=$("#uploaded_file").val();
    var ext = uploaded_file.split('.').pop();
    if(ext!="png")
    {
      new Noty({
          type: 'warning',
          text: '<h5>Warning..!</h5>File formate must be .png',
          timeout: 2000
      }).show()
      return false;
    }


      var form = $('#frm')[0];
      var formData = new FormData(form);
      formData.append('crude', crude);
    	  $.ajax({
    	   type: "POST",
    	   url: '<?php echo admin_url() ?>category/addCatagory',
         data: formData,
    		 processData: false,
    		 contentType: false,
    	   success: function(response){
              if (response == 1) {
                   reloadTable();
                   $('#verticalModal').modal('hide');
                   new Noty({
                       type: 'success',
                       text: '<h5>Success..!</h5>Category saved successfully',
                       timeout: 2000
                   }).show()
               } else if (response == 3)
                   new Noty({
                       type: 'warning',
                       text: '<h5>Warning..!</h5>Category already exist',
                       timeout: 2000
                   }).show()
               else
                   new Noty({
                       type: 'warning',
                       text: '<h5>Error..!</h5>'+response,
                       timeout: 2000
                   }).show()

                   $("#uploaded_file").val('');
    	     }
    	 });
    }
function UpdateCatagory()
{

    let catagoryName = $('#catagoryName').val();
    let displayStatus = ($('#displayStatus').prop('checked')) ? 1 : 0;
    let uploaded_file= $('#uploaded_file')[0].files[0];

    if (catagoryName == '') {
      new Noty({
          type: 'warning',
          text: '<h5>Warning..!</h5>Plese fill all mandatory fields',
          timeout: 2000
      }).show()
      return false;
    }
    uploaded_file=$("#uploaded_file").val();
    if(uploaded_file)
    {
      var ext = uploaded_file.split('.').pop();
      if(ext!="png")
      {
        new Noty({
            type: 'warning',
            text: '<h5>Warning..!</h5>File formate must be .png',
            timeout: 2000
        }).show()
        return false;
      }
    }

      var form = $('#frm')[0];
      var formData = new FormData(form);
    	  $.ajax({
    	   type: "POST",
    	   url: '<?php echo admin_url() ?>category/updateCatagory',
         data: formData,
    		 processData: false,
    		 contentType: false,
    	   success: function(response){
              if (response == 1) {
                   reloadTable();
                   $('#verticalModal').modal('hide');
                   new Noty({
                       type: 'success',
                       text: '<h5>Success..!</h5>Category updated successfully',
                       timeout: 2000
                   }).show()
               } else if (response == 3)
                   new Noty({
                       type: 'warning',
                       text: '<h5>Warning..!</h5>Category already exist',
                       timeout: 2000
                   }).show()
               else
                   new Noty({
                       type: 'warning',
                       text: '<h5>Error..!</h5>'+response,
                       timeout: 2000
                   }).show()

                   $("#uploaded_file").val('');
    	     }
    	 });
}

</script>
