jQuery(function($){
  var $listingunits="all";

  var showMeivacListings = function(units, size, mount) {
    $(".product-listing").each(function(){
      $this=$(this);
        if ( ( units == "all" || $this.data('units') == units ) && ( size == "all" || $this.data('size') == size ) && ( mount == "all" || $this.data('mount') == mount ) ){
          $this.show();
        } else {
          $this.hide();
        }
    })
  };
  $(".MVformElement").change(function(){
    showMeivacListings( $listingunits,$("#size").val(),$("#type").val() );
  });
  $(".MVlistingbutton").click(function(){
    $(".MVlistingbutton").removeClass("active");
    $(this).addClass("active");
    $listingunits=$(this).data('vals');
    showMeivacListings( $listingunits,$("#size").val(),$("#type").val() );
  });

  //showMeivacListings('all','all','all','all','all');


});

