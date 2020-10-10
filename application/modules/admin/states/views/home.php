<!-- Font & Icon -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- Plugins -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin_template/plugins/datatables/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
<style>
  .table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
  }
</style>
<main>
<h5>Manage States</h5>
    <table id="example" class="table table-hover table-bordered table-sm dt-responsive nowrap w-100">
      <!-- Filter columns -->
      <thead>
        <tr class="column-filter dt-column-filter">
          <th></th>
          <th><input type="text" class="form-control form-control-sm" placeholder="Search State Name"></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th>Serial No</th>
          <th>State Name</th>
          <th>Display Status</th>
          <th>Edit</th>
          <th>Delete</th>
          <th>StateID</th>
          <th>CountryID</th>
        </tr>
      </thead>
      <!-- /Filter columns -->

        <tbody>
          
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <button type="button" class="col-md-12 btn btn-primary shadow-sm btn-xs text-center" data-toggle="modal" data-target="#verticalModal">Add State</button>
                </td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <!-- Vertically centered -->
    <div class="modal fade" id="verticalModal" tabindex="-1" role="dialog" aria-labelledby="verticalModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="verticalModalLabel">Add State</h5>
            <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
              <i class="material-icons">close</i>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label style="font-size : 15px">State name</label>
                    <span class="input-icon">
                        <i style="font-size : 19px" class="material-icons">add_box</i>
                        <input id="shopName" name="shopName" type="text" class="form-control form-control-sm" placeholder="State name">
                    </span>
                </div>
                <div class="col-md-12">
                    <br />
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                        <label class="custom-control-label" for="customSwitch1">Active Status</label>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light btn-xs" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-xs">Save changes</button>
          </div>
        </div>
      </div>
    </div>
</main>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/datatables/jquery.dataTables.bootstrap4.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script>
    var base_url = '<?php echo base_url(); ?>';

    $(document).ready(function() {

        GetAllStates();

    });

    var GetAllStates = () => {
        $.ajax({
            url : base_url+'webuser/States/GetAllStates',
            type: 'post',
            success : function(response) {
                //alert(response);
                //console.log(response);
                LoadDataTable(response);
            }
        })
    }

    var LoadDataTable = (data) => {
    $(() => {
        //alert(data);
        data = JSON.parse(data);
        App.checkAll()
    
        // Run datatable
         table = $('#example').DataTable({
            dom: 'lBfrtip',
            data: data,
            columns: [
                { data: 'SerialNo' },
                { data: 'StateName' },
                { data: 'DisplayStatus' },
                { data: 'EditInnerHTML' },
                { data: 'DeleteInnerHTML' },
                { data: 'StateID' },
                { data: 'CountryID' }
            ],
            columnDefs: [
                {
                    "targets": [ 5 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 6 ],
                    "visible": false,
                    "searchable": false
                }
            ],
            buttons: [
                {
                    extend : 'excel',
                    titleAttr: 'Excel'
                },
                {
                    extend : 'pdf',
                    titleAttr: 'PDF'
                }                
            ],
            drawCallback: function () {
                $('.dataTables_paginate > .pagination').addClass('pagination-sm') // make pagination small
            }
        })
        
        // Apply column filter
        $('#example .dt-column-filter th').each(function (i) {
            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                    .column(i)
                    .search(this.value)
                    .draw()
                }
            })
        })
        // Toggle Column filter function
        var responsiveFilter = function (table, index, val) {
            var th = $(table).find('.dt-column-filter th').eq(index)
            val === true ? th.removeClass('d-none') : th.addClass('d-none')
        }
        // Run Toggle Column filter at first
        $.each(table.columns().responsiveHidden(), function (index, val) {
            responsiveFilter('#example', index, val)
        })
        // Run Toggle Column filter on responsive-resize event
        table.on('responsive-resize', function (e, datatable, columns) {
            $.each(columns, function (index, val) {
                responsiveFilter('#example', index, val)
            })
        })
        
    })    
}

</script>