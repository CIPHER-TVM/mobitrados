  <div class="sidebar-backdrop" id="sidebarBackdrop" data-toggle="sidebar"></div>
</body>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/noty/noty.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin_template/plugins/bootbox/bootbox.min.js"></script>
<script>

$('#ar_loader').hide();

function notify_msg(type,msg="")
{
  new Noty({
    type: type,
    text: msg,
    timeout: 2000
  }).show();
}
</script>
<script>
var $loading = $('#loading').hide();
//Attach the event handler to any element
$(document)
.ajaxStart(function () {
//ajax request went so show the loading image
 $(".overlay").show();
})
.ajaxStop(function () {
//got response so hide the loading image
 $(".overlay").hide();
});
</script>
</html>
