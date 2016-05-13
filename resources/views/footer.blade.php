<script type="text/javascript" src="{{url('/')}}/template/js/admin.js"></script>
<!-- Sparkline demo data -->
<script src="{{url('/')}}/template/js/sparkline.min.js"></script>
<script src="{{url('/')}}/template/js/sparkline.js"></script>
<!-- Toastr script -->
<script src="{{url('/')}}/template/js/toastr.min.js"></script>

<script>

    $(document).ready(function(){
           

            var i = -1;
            var toastCount = 0;

            <?php if(isset($error)){ ?>
                var getMessage = function () {
                   
                    var msg = '<?=$error?>';
                    return msg;
                };
               
                var msg = "";
                var title = "";
                
                var toastIndex = toastCount++;
                 
                toastr.options = {
                    closeButton: true,
                    debug: true,
                    progressBar: true,
                    preventDuplicates: true,
                    positionClass: "toast-top-right",
                    onclick: null
                };
              
                toastr.options.showDuration = 1000;              
                toastr.options.hideDuration = 1000;               
                toastr.options.timeOut = 7000;
                toastr.options.extendedTimeOut = 1000;
                toastr.options.showEasing = "swing";
                toastr.options.hideEasing = "linear";
                toastr.options.showMethod = "fadeIn";
                toastr.options.hideMethod = "fadeOut";
                if (!msg) {
                    msg = getMessage();
                }
               
                toastr['error'](msg); // Wire up an event handler to a button in the toast, if it exists
               
            <?php } else if(isset($success)){?> 
        	 	var getMessage = function () {
                   
                    var msg = '<?=$success?>';
                    return msg;
                };
               
                var msg = "";
                var title = "";
                
                var toastIndex = toastCount++;
                 
                toastr.options = {
                    closeButton: true,
                    debug: true,
                    progressBar: true,
                    preventDuplicates: true,
                    positionClass: "toast-top-right",
                    onclick: null
                };
              
                toastr.options.showDuration = 1000;              
                toastr.options.hideDuration = 1000;               
                toastr.options.timeOut = 10000;
                toastr.options.extendedTimeOut = 1000;
                toastr.options.showEasing = "swing";
                toastr.options.hideEasing = "linear";
                toastr.options.showMethod = "fadeIn";
                toastr.options.hideMethod = "fadeOut";
                if (!msg) {
                    msg = getMessage();
                }
               
                toastr['info'](msg);
            <?php }?>
     });
</script>

</body>
</html>
