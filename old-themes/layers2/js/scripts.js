jQuery(function($){
/*$('.scroll-nav a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });*/
  $('.js-more').click(function(){
    if ($(this).hasClass('open')) {
      $(this).text('Read more...').toggleClass('open');
    } else {
      $(this).text('Close').toggleClass('open');
    }
  });
  $("#head-banner-nav li").on('click',function(){
    $("#head-banner-nav").attr('data-active',$(this).attr('class'));
    $("#head-banner-btn").attr('href',$(this).data('href'));
  });

  $("#listing").tablesorter({
    sortList : [[1,0], [2,0]]
  }); 
  var $listingunits="all";

  var showListings = function(units, shaft, mount, environ, temp) {
    var mountarray=mount.split(',');
    var shaftarray=shaft.split(',');
    $(".product-listing").each(function(){
      $this=$(this);
        if ( ( units == "all" || $this.data('units') == units ) && ( shaft == "all" || ( jQuery.inArray( $this.data('shaft').toString(), shaftarray) !== -1 )  ) && ( mount == "all" || ( jQuery.inArray( $this.data('mounting').toString(), mountarray) !== -1 ) ) && ( environ == "all" || $this.data('environment') == environ ) && ( temp == "all" || $this.data('temperature') == temp ) ){
          $this.show();
        } else {
          $this.hide();
        }
    })
  };
  $(".formElement").change(function(){
    showListings($listingunits,$("#shaftType").val(),$("#mount").val(),$("#environment").val(),$("#temperature").val());
  });
  $(".listingbutton").click(function(){
    $(".listingbutton").removeClass("active");
    $(this).addClass("active");
    $listingunits=$(this).data('vals');
    showListings($listingunits,$("#shaftType").val(),$("#mount").val(),$("#environment").val(),$("#temperature").val());
  });

  showListings($listingunits,'all','all','all','all');
  $('.slider-btn').on('click',function(){
    $('.slider-btn').removeClass('on');
    $(this).addClass('on')
    $('.bkg-map').removeClass('on');
    $('#map-'+$(this).data('map')).addClass('on');
  });
  $('.microhome-carousel').on('slid.bs.carousel', function () {
        if ($(this).find('.carousel-inner .item:first').hasClass('active')) {
            $(this).carousel('pause');
        }
    });
  $(".navbar-open").on('click', function(){
    $(".nav-mobile-slide").addClass("in");
  })
  $(".navbar-close").on('click', function(){
    $(".nav-mobile-slide").removeClass("in");
  })
});
