<!-- Font & Icon -->
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
  <h5>Manage Places</h5>
  <table id="example" class="table table-hover table-bordered table-sm dt-responsive nowrap w-100">
    <!-- Filter columns -->
    <thead>

      <tr>
        <th>Serial No</th>
        <th>Place Name</th>
        <th>Pin code</th>
        <th>District Name</th>
        <th>Delivery Fee</th>
        <th>Display Status</th>
        <th>Edit</th>
        <th>Delete</th>
        <th>PlaceID</th>
      </tr>
    </thead>
    <!-- /Filter columns -->

    <tbody>

    </tbody>
    <tfoot>
      <tr>
        <td colspan="8">
          <button onclick="changeUpdateToSave(); clearForm()" type="button" class="bigbtn col-md-12 btn btn-primary shadow-sm btn-xs text-center" data-toggle="modal" data-target="#verticalModal">Add Place</button>
        </td>
        <td></td>
      </tr>
    </tfoot>
  </table>
  <!-- Vertically centered -->
  <div class="modal fade" id="verticalModal" tabindex="-1" role="dialog" aria-labelledby="verticalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="verticalModalLabel"><strong> <u>Add Place </strong> </u></h6>
          <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
            <i class="material-icons">close</i>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12" style="display: none">
              <label style="font-size : 14px" for="emailGrid">State <span class="star">*</span></label>
              <span class="input-icon">
                <i style="font-size : 19px; z-index:1" class="material-icons">person_pin_circle</i>
                <select id="states" name="states" class="form-control bs-select form-control-sm" title="Choose State" data-live-search="true" onchange="GetDistrictsByStateID();">
                  <option value="1" selected>Tamil Nadu</option>
                </select>
              </span>
            </div>
            <div class="col-md-12">
              <label style="font-size : 14px" for="emailGrid">District <span class="star">*</span></label>
              <span class="input-icon">
                <i style="font-size : 19px; z-index:1" class="material-icons">gps_fixed</i>
                <select id="districts" name="districts" class="form-control bs-select form-control-sm" title="Choose District" data-live-search="true">
                <?php LoadCombo("districts","DistrictId","DistrictName",1,"where StateID in(1,2) AND DisplayStatus=1","order by DistrictId"); ?>

                </select>
              </span>
            </div>
            <input style="display : none" id="hidPlaceid" name="hidPlaceid" type="text" class="form-control form-control-sm" placeholder="Place name">
            <div class="col-md-12">
              <label style="font-size : 15px">Place name <span class="star">*</span></label>
              <span class="input-icon">
                <i style="font-size : 19px" class="material-icons">add_box</i>
                <input id="placeName" name="placeName" type="text" class="form-control form-control-sm" placeholder="Place name">
              </span>
            </div>
            <div class="col-md-12">
              <label style="font-size : 15px">Pin Code <span class="star">*</span></label>
              <span class="input-icon">
                <i style="font-size : 19px" class="material-icons">add_box</i>
                <input id="pincode" name="pincode" maxlength="6" type="number" class="form-control form-control-sm" placeholder="Pin code">
              </span>
            </div>
            <div class="col-md-12">
              <label style="font-size : 15px">Delievry Fee <span class="star">*</span></label>
              <span class="input-icon">
                <i style="font-size : 19px" class="material-icons">add_box</i>
                <input id="delivery_fee" name="delivery_fee" maxlength="5" type="number" class="form-control form-control-sm" placeholder="Delivery fee" value="0">
              </span>
            </div>
            <div class="col-md-12">
              <label style="font-size : 15px">Expected Delievry TIme <span class="star">*</span></label>
              <span class="input-icon">
                <i style="font-size : 19px" class="material-icons">add_box</i>

                <div class="input-group">
<div class="input-group-prepend">
<span class="input-group-text form-control-sm" id="">Hour : Min</span>
</div>
<select  class="form-control form-control-sm"name="hour" id="hour">
      <?php
        for($i=0;$i<24;$i++)
        {
          echo '<option value="'.$i.'">'.$i.'</option>';
        }
        ?>
</select>
<select  class="form-control form-control-sm"name="minutes" id="minutes">
    <?php
    for($i=0;$i<=55;$i=$i+5)
    {
      echo '<option value="'.$i.'">'.$i.'</option>';
    }
      ?>
    </select>
</div>
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
            <button onclick="SavePlace()" type="button" class="btn btn-primary btn-xs">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/datatables/jquery.dataTables.bootstrap4.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/bootbox/bootbox.min.js"></script>

<script>
  const BASE_URL = '<?php echo base_url(); ?>';
  var table;
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  $(document).ready(function() {
    LoadDataTable();
  });

  var clearForm = () => {
    $('#placeName').val('');
    //$('#states').val(0);
  //  $('#states').selectpicker('refresh');
  //  $('#districts').val(0);
  //  $('#districts').selectpicker('refresh');
  }

  var changeUpdateToSave = () => {
    $('#SaveOrUpdate').html('<button onclick="SavePlace()" type="button" class="btn btn-primary btn-xs">Save</button>');
  }

  var SavePlace = () => {
    let place = $('#placeName').val();
    let district = $('#districts').val();
    let pincode = $('#pincode').val();
    let state = $('#states').val();
    var delivery_fee=$("#delivery_fee").val();
    let displayStatus = ($('#displayStatus').prop('checked')) ? 1 : 0;
    var minutes=$("#minutes").val();
    var hour=$("#hour").val();
    let ajaxval = {
      place: place,
      district: district,
      state: state,
      pincode: pincode,
      displayStatus: displayStatus,
      delivery_fee:delivery_fee,
      minutes:minutes,
      hour:hour,
      [csrfName]: csrfHash
    };
    if (place != '' && district > 0 && state > 0 && pincode != '' && delivery_fee!='') {
      $.ajax({
        url: BASE_URL + 'webuser/localPlaces/SavePlace',
        type: 'post',
        data: ajaxval,
        success: function(response) {
          if (response == 1) {
            reloadTable();
            $('#verticalModal').modal('hide');
            new Noty({
              type: 'success',
              text: '<h5>Success..!</h5>Place saved successfully',
              timeout: 2000
            }).show()
          } else if (response == 3)
            new Noty({
              type: 'warning',
              text: '<h5>Warning..!</h5>Place already exist',
              timeout: 2000
            }).show()
          else
            new Noty({
              type: 'danger',
              text: '<h5>Error..!</h5>unexpected error',
              timeout: 2000
            }).show()
        }
      });
    } else {
      new Noty({
        type: 'warning',
        text: '<h5>Warning..!</h5>Plese fill all mandatory fields',
        timeout: 2000
      }).show()
    }
  }

  var DeletePlace = placeID => {
    const confirmRemove = bootbox.confirm({
      message: 'Are you sure to delete this data permenantly?',
      buttons: {
        confirm: {
          label: 'Yes',
          className: 'btn-danger'
        }
      },
      callback: result => {
        if (result) {
          let ajaxval = {
            placeID: placeID,
            [csrfName]: csrfHash
          };
          $.ajax({
            url: BASE_URL + 'webuser/localPlaces/DeletePlace',
            type: 'post',
            data: ajaxval,
            success: function(response) {
              if (response) {
                reloadTable();
                new Noty({
                  type: 'success',
                  text: '<h5>Success...!</h5>Place deleted successfully',
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

  var UpdatePlace = () => {
    let place = $('#placeName').val();
    let hidPlaceid = $('#hidPlaceid').val();
    let district = $('#districts').val();
    let state = $('#states').val();
    let pincode = $('#pincode').val();
    var delivery_fee=$("#delivery_fee").val();
    var minutes=$("#minutes").val();
    var hour=$("#hour").val();
    let displayStatus = ($('#displayStatus').prop('checked')) ? 1 : 0;
    let ajaxval = {
      place: place,
      district: district,
      state: state,
      pincode: pincode,
      displayStatus: displayStatus,
      hidPlaceid: hidPlaceid,
      delivery_fee:delivery_fee,
      minutes:minutes,
      hour:hour,
      [csrfName]: csrfHash
    };

    if (place != '' && district > 0 && state > 0 && pincode != '' && delivery_fee!='') {
      $.ajax({
        url: BASE_URL + 'webuser/localPlaces/UpdatePlace',
        type: 'post',
        data: ajaxval,
        success: function(response) {
          if (response == 1) {
            reloadTable();
            $('#verticalModal').modal('hide');
            new Noty({
              type: 'success',
              text: '<h5>Success..!</h5>Place updated successfully',
              timeout: 2000
            }).show()
          } else if (response == 3)
            new Noty({
              type: 'warning',
              text: '<h5>Warning..!</h5>Place already exist',
              timeout: 2000
            }).show()
          else
            new Noty({
              type: 'danger',
              text: '<h5>Error..!</h5>unexpected error',
              timeout: 2000
            }).show()
        }
      });
    } else {
      new Noty({
        type: 'warning',
        text: '<h5>Warning..!</h5>Plese fill all mandatory fields',
        timeout: 2000
      }).show()
    }
  }

  var Populate = (places) => {
    $('#hidPlaceid').val(places.PlaceID);
    $('#placeName').val(places.PlaceName);
    $('#states').val(places.StateID);
    $('#pincode').val(places.pincode);
    $('#delivery_fee').val(places.delivery_fee);

    var time=places.expected_delivery_time;
    if(time)
    {
      var split_time=time.split(":");
      var hour=parseInt(split_time[0]);
      var min=parseInt(split_time[1]);
      $("#hour").val(hour);
      $("#minutes").val(min);
    }
    else{
      $("#hour").val(0);
      $("#minutes").val(0);
    }



    $('#states').selectpicker('refresh');
    $('#SaveOrUpdate').html('<button onclick="UpdatePlace()" type="button" class="btn btn-primary btn-xs">Update</button>');
    $('#displayStatus').prop("checked", parseInt(places.DisplayStatus) ? true : false);
    $('#verticalModal').modal('show');

  }

  var GetAllPlaceById = (placeID) => {
    //alert(placeID);
    let ajaxval = {
      placeID: placeID,
      [csrfName]: csrfHash
    };
    $.ajax({
      url: BASE_URL + 'webuser/localPlaces/GetAllPlaceById',
      type: 'post',
      data: ajaxval,
      success: function(response) {
        //alert(response);
        Populate(JSON.parse(response));
      }
    });
  }

  $('#example tbody').on('click', 'tr button', function() {

    if (this.id == 'Edit') {
      GetAllPlaceById(table.row(this.closest('tr')).data().PlaceID);
    } else {
      DeletePlace(table.row(this.closest('tr')).data().PlaceID);
    }
  });

  var LoadDataTable = () => {
    $(() => {
      // Run datatable
      table = $('#example').DataTable({
        ajax: {
          url: BASE_URL + 'webuser/localPlaces/GetAllDistrictsForDT',
          type: 'post',
          data : {[csrfName]: csrfHash}
        },
        columns: [{
            data: 'SerialNo'
          },
          {
            data: 'PlaceName'
          },
          {
            data: 'pincode'
          },
          {
            data: 'DistrictName'
          },
          {
            data: 'delivery_fee'
          },
          {
            data: 'DisplayStatus'
          },
          {
            data: 'EditInnerHTML'
          },
          {
            data: 'DeleteInnerHTML'
          },
          {
            data: 'PlaceID'
          }
        ],
        columnDefs: [{
          "targets": [8],
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
</script>
