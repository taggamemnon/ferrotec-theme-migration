jQuery(function($){
  var $listingunits="all";

  var showMeivacListings = function(units, flange, material, coating, actuation) {
    $(".product-listing").each(function(){
      $this=$(this);
        if ( ( units == "all" || $this.data('units') == units ) && ( flange == "all" || $this.data('flange') == flange ) && ( material == "all" || $this.data('material') == material ) && ( coating == "all" || $this.data('coating') == coating ) && ( actuation == "all" || $this.data('actuation') == actuation ) ){
          $this.show();
        } else {
          $this.hide();
        }
    })
  };
  $(".MVformElement").change(function(){
    showMeivacListings($listingunits,$("#flange").val(),$("#material").val(),$("#coating").val(),$("#actuation").val());
  });
  $(".MVlistingbutton").click(function(){
    $(".MVlistingbutton").removeClass("active");
    $(this).addClass("active");
    $listingunits=$(this).data('vals');
    showMeivacListings($listingunits,$("#flange").val(),$("#material").val(),$("#coating").val(),$("#actuation").val());
  });

  //showMeivacListings('all','all','all','all','all');


});

