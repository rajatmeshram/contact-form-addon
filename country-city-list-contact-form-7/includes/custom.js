jQuery(document).ready(function($){
var ajaxurl = ajaxob.ajaxurl;
$('#countrylist').on('change', function(e) {
  e.preventDefault();
  var country= this.value;
  $.ajax({
    type: 'POST',
    url: ajaxurl, // use ajax_params.ajax_url if using in plugin
    dataType: 'html',
    data: {
        action: 'get_state',
        newValue:country
    },
    success: function(response) {
      jQuery("#ccl-state").html(response);
    },
    error: function(errorThrown){
        console.log(errorThrown);
    }    
  })
  
  });


  $('#ccl-state').on('change', function(e) {
    e.preventDefault();
    var state= this.value;
    $.ajax({
      type: 'POST',
      url: ajaxurl, // use ajax_params.ajax_url if using in plugin
      dataType: 'html',
      data: {
          action: 'get_city',
          state:state
      },
      success: function(response) {
        jQuery("#ccl-city").html(response);
      },
      error: function(errorThrown){
          console.log(errorThrown);
      }    
    })
    
    });


});
