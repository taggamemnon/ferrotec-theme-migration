
<link rel="stylesheet" href="/wp-content/plugins/Customer%20Accounts/dist/remodal.css">
<link rel="stylesheet" href="/wp-content/plugins/Customer%20Accounts/dist/remodal-default-theme.css">
<!--script src="//ferrotec.com/wp-content/themes/remodal/remodal.js"></script-->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
<!--script>window.jQuery || document.write('<script src="../libs/jquery/dist/jquery.min.js"><\/script>')</script-->
<script src="/wp-content/plugins/Customer%20Accounts/dist/remodal.js"></script>

<!-- Events -->
<script>
jQuery(function($){

  $(document).on('opening', '.remodal', function () {
    console.log('opening');
  });

  $(document).on('opened', '.remodal', function () {
    console.log('opened');
  });

  $(document).on('closing', '.remodal', function (e) {
    console.log('closing' + (e.reason ? ', reason: ' + e.reason : ''));
  });

  $(document).on('closed', '.remodal', function (e) {
    console.log('closed' + (e.reason ? ', reason: ' + e.reason : ''));
  });

  $(document).on('confirmation', '.remodal', function () {
    console.log('confirmation');
  });

  $(document).on('cancellation', '.remodal', function () {
    console.log('cancellation');
  });
});

//  Usage:
//  $(function() {
//
//    // In this case the initialization function returns the already created instance
//    var inst = $('[data-remodal-id=modal]').remodal();
//
//    inst.open();
//    inst.close();
//    inst.getState();
//    inst.destroy();
//  });

  //  The second way to initialize:
  $('[data-remodal-id=modal2]').remodal({
    modifier: 'with-red-theme'
  });
</script>	
<style>

		.remodal-overlay.without-animation.remodal-is-opening,

		.remodal-overlay.without-animation.remodal-is-closing,

		.remodal.without-animation.remodal-is-opening,

		.remodal.without-animation.remodal-is-closing,

		.remodal-bg.without-animation.remodal-is-opening,

		.remodal-bg.without-animation.remodal-is-closing {

			animation: none;

		}

		.remodal {
    box-sizing: border-box;
    width: 100%;
    margin-bottom: 10px;
    padding: 35px;
    transform: translate3d(0, 0, 0);
    color: #2b2e38;
    background: #fff;
}
.remodal {
    border: 1px solid rgb(51, 51, 51);
    border-radius: 5px;
    box-shadow: rgb(45, 44, 44) 2px 17px 23px;
}

.seeking {
    color: #3EABD2;
    text-align: center;
    font-weight: bold;
    font-size: 20px !important;
    border-bottom: #eee solid 1px;
    margin-top: -20px;
    margin-bottom: 20px;
    padding-bottom: 15px;
}

.left
{
	float:left; text-align:right; font-size:16px;
	width:120px; padding-right:20px;
}

.left2
{
	float:left; text-align:right;
	width:190px; padding-right:20px;
}

.clear
{
	clear:both; margin-bottom:10px;
}
.textbox
{
	width:220px;
}

.error, .out_of_stock, .alert_box_error {
    color: #ff0000;
}
form [class*="alert_box"] {
    margin-top: 10px;
    -webkit-backface-visibility: hidden;
}


[class*="alert_box"] {
    position: relative;
    border-width: 1px;
    border-style: solid;
    background: #fff;
    padding:5px;
    margin-bottom:20px;
}
.textbox {
    font-family: Arial, Helvetica, sans-serif;
    background: rgba(255, 255, 255, 0.44);
    color: #333;
    border: 1px solid #A4A4A4;
    padding: 4px 8px 4px 4px !important;
    line-height: 1;
    width: 275px !important;
    height: 25px;
}		
</style>
