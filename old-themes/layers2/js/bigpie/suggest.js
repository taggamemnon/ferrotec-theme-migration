

var bigpie = bigpie || {};


(function ($, bigpie) {
  'use strict';

  /////////////////////////////
  //   PRIVATE VARIABLES     //
  /////////////////////////////

  var _nameField = '#suggest_form_name';
  var _websiteField = '#suggest_form_website';
  var _suggestModal = '#suggestModal';
  var _cityField = '#suggest_form_city';

  /////////////////////////////
  //   PRIVATE FUNCTIONS     //
  /////////////////////////////

  /**
   * Resets the suggest form
   */
  function _resetSuggestForm(){
    $('#suggest_form_name').val('');
    $('#suggest_form_state').val(1);
    $('#suggest_form_city').val('');
    $('#suggest_form_website').val('');
  }

  function ValidateUrl(url){
    return /^(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
  }

  /**
   *
   * @returns {boolean} - true if all is valid and false otherwise
   * @private
   */
  function _validateFields(){

    var valid = true;
    // name field validation
    if(!$(_nameField).val()){
      $(_nameField).addClass('invalid');
      valid = false;
    } else {
      $(_nameField).removeClass('invalid');
    }

    // website field validation
    var website = $(_websiteField).val();
    if(website !== '' && !ValidateUrl(website)){
      $(_websiteField).addClass('invalid');
      valid = false;
    } else {
      $(_websiteField).removeClass('invalid');
    }

    return valid;
  }


  /////////////////////////////
  //      PUBLIC API         //
  /////////////////////////////

  /**
   * Submit the suggest form
   * @param evt
   */
  bigpie.submitSuggest = function (evt) {

    evt.preventDefault();
    evt.stopPropagation();
    // validation check
    if(!_validateFields()){
      return;
    }
    // get data
    var name = $('#suggest_form_name').val();
    var stateField = document.getElementById('suggest_form_state');
    var state = stateField.options[stateField.selectedIndex].text;
    var city = $(_cityField).val().length ? $(_cityField).val() : 'Unknown City';
    var website = $('#suggest_form_website').val();
    // hide the modal
    $(_suggestModal).modal('hide');
    $.ajax({
      url: bigpie.config.baseUrl + bigpie.config.suggestNonprofit,
      type: "POST",
      data: {name: name, state: state, city: city, website: website}
    })
      .done(function(){
        $('#thankYouModal').modal('show');
        _resetSuggestForm();
      })
      .error(function(err){
        $('#errorModal').modal('show');
        _resetSuggestForm();
      });
  };

  /////////////////////////////
  //      LISTENERS          //
  /////////////////////////////

  // init the modal after loading
  $(function(){

    $(_suggestModal).on('show.bs.modal', function () {
      $(_nameField).removeClass('invalid');
      $(_websiteField).removeClass('invalid');
      _resetSuggestForm();
    });
  });



})(jQuery, bigpie);