
var bigpie = bigpie || {};


(function ($, bigpie) {
  'use strict';

  /////////////////////////////
  //   PRIVATE VARIABLES     //
  /////////////////////////////

  var _$registeredEmail;
  var _$registeredType;
  var _$nonprofit = {};
  var _tmpTaxId = null;

  // Modals
  var _errorModal                     = '#errorModal';
  var _emailField                     = '#bp_joinPatronModal_name';
  var _joinPatronModal                = '#bp_joinPatronModal';
  var _joinPatronSuccess              = '#bp_joinPatronSuccess';
  var _joinPatronSuccessDynamicEmail  = '.bp_joinPatronSuccess_dynamicEmail';
  var _joinMerchantModal              = '#bp_joinMerchantModal';
  var _joinMerhcantEmailField         = '#bp_joinMerchantModal_name';
  var _joinNonprofitModal             = '#bp_joinNonprofitModal';
  var _joinAlreadyClaimedModal        = '#bp_joinListringAlreadyClaimedModal';
  var _joinAlreadyClaimedTaxField     = '#bp_joinListringAlreadyClaimedModal_taxId';
  var _joinAlreadyClaimedClaimedId    = '#bp_joinListringAlreadyClaimedModal_claimedTax';
  var _joinAlreadyClaimedInfo         = '#bp_joinListringAlreadyClaimedModal_info';
  var _joinAlreadyClaimedOrgName      = '#bp_joinListringAlreadyClaimedModal_orgName';
  var _joinAlreadyClaimedCity         = '#bp_joinListringAlreadyClaimedModal_city';
  var _joinPleaseConfirmModal         = '#bp_joinPleaseConfirmModal';
  var _joinPleaseConfirmTaxField      = '#bp_joinPleaseConfirmModal_taxId';
  var _joinPleaseConfirmClaimedId     = '#bp_joinPleaseConfirmModal_claimedTax';
  var _joinPleaseConfirmInfo          = '#bp_joinPleaseConfirmModal_info';
  var _joinPleaseConfirmOrgName       = '#bp_joinPleaseConfirmModal_orgName';
  var _joinPleaseConfirmCity          = '#bp_joinPleaseConfirmModal_city';
  var _joinWeNeedYourHelpModal        = '#bp_joinWeNeedYourHelp';
  var _joinWeNeedYourHelpTaxIdField   = '#bp_joinWeNeedYourHelp_taxId';
  var _joinWeNeedYourHelpTaxHeader    = '#bp_joinWeNeedYourHelp_taxHeader';
  var _joinCreateNonprofitModal       = '#bp_joinCreateNonprofitModal';
  var _joinCreateNonprofitFirstField  = '#bp_joinCreateNonprofitModal_first';
  var _joinCreateNonprofitLastField   = '#bp_joinCreateNonprofitModal_last';
  var _joinCreateNonprofitEmailField  = '#bp_joinCreateNonprofitModal_email';
  var _joinNonprofitTaxIdField        = '#bp_joinNonprofitModal_taxId';
  var _joinForgotPasswordModal        = '#bp_joinPatronForgotPassword';
  var _joinForgotPasswordEmailField   = '#bp_joinPatronForgotPassword_email';
  var _joinForgotPasswordDynamicEmail = '#bp_joinPatronForgotPassword_dynamicEmail';
  var _mailSentMessage                = '#bp_joinPatronSuccess_resend';
  var _inputErrorField                = '.input_error';
  var _invalidInputClass              = 'invalid';
  var _nonprofitHome                  = '/nonprofits/';

  /////////////////////////////
  //   PRIVATE FUNCTIONS     //
  /////////////////////////////

  /**
   *
   * @param email
   * @returns {boolean}
   * @private
   */
  function _verifyEmail(email) {
    var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(email);
  }

  /**
   *
   * @param id - string with the tax id
   * @param index {Integer} - {2,7} integer corresponding to the input type (2 digits or seven digits
   * @private
   */
  function _verifyTaxId(id, index){
    //var pattern = /^\d{2}-?\d{7}$/;
    var pattern_2 = /^\d{2}$/;
    var pattern_7 = /^\d{7}$/;

    switch (index) {
      case 2:
        return pattern_2.test(id);
      case 7:
        return pattern_7.test(id);
    }
  }

  /**
   * Do a check with the server if a user exists for the given email
   * @param email
   * @returns {Boolean} - true if exists
   * @private
   */
  function _userExists(email){
    var dfr = $.Deferred();
    $.ajax({
      url: bigpie.config.baseUrl + bigpie.config.exists,
      type: "POST",
      timeout: 15000,
      data: {"email": email}
    })
      .done(function(user){
        if(user.length){
          dfr.resolve(true);
        } else {
          dfr.resolve(false);
        }
      })
      .error(function(err){
        if(!err.status){
          $(_errorModal).modal('show');
          dfr.reject(err);
        }
        dfr.resolve(false);
      });

    return dfr.promise();
  }

  /**
   * @param hash
   * @returns {boolean}
   * @description
   * check if url contain has value
   */
  function _searchUrlHash(hash) {
    return location.hash === hash;
  }

  /**
   * @private
   * @description
   * Fires on page load. this function checks if url has '#join' hash and if so it
   * triggers join modal open
   */
  function _openModalIfNeeded() {

    var urlPaths = location.pathname.substr(1).split('/');

    // check if inside some nonprofit page
    if (urlPaths[0] === 'nonprofits' && urlPaths[1]) {

      // check if url has 'join' hash. if so trigger modal open
      if (_searchUrlHash('#join')) {

        $(document).ready(function() {
          bigpie.join.openModal(null, '#bp_joinPatronModal');
        });

      }

    }
  }

  /**
   * @desc
   * clean input's text by selector
   * @param inputsArr
   */
  function cleanInputs(inputsArr) {
    inputsArr.forEach(function(input) {
      $(input).val('');
      $(input).removeClass('invalid');
    })
  }

  /**
   * send register request to the server
   * @param {string} email
   * @param {string} type
   * @param {string} first - nonprofit only
   * @param {string} last - nonprofit only
   * @param {string} taxId - the tax id
   * @param {string} nonprofitid - id of selected nonprofit
   * @returns {Promise}
   * @private
   */
  function _registerUser(email, type, first, last, taxId, nonprofitid){
    var dfr = $.Deferred();
    $.ajax({
      url: bigpie.config.baseUrl + bigpie.config.register,
      type: "POST",
      timeout: 15000,
      data: {"email": email, "type": type, first: first, last: last, taxId: taxId, selectedNonprofit: nonprofitid}
    })
      .done(function(){
        dfr.resolve(true);
      })
      .error(function(err){
        $(_errorModal).modal('show');
        dfr.reject('An error had occur during the registration');
      });

    return dfr.promise();
  }

  /**
   * send forgot password request to the server
   * @param {string} email
   * @returns {*} - Promise with the response
   * @private
   */
  function _sendPasswordResetEmail(email) {
    return $.ajax({
      url: bigpie.config.baseUrl + bigpie.config.forgot,
      type: "POST",
      data: {"email": email}
    });
  }

  /**
   * Check if a field is empty, if yes then set the invalid class on it
   * @param field
   * @returns {boolean} - valid : true else false
   * @private
   */
  function _validateEmptiness(field){
    if($(field).val() === ''){
      $(field).addClass(_invalidInputClass);
      return false;
    }
    $(field).removeClass(_invalidInputClass);
    return true;
  }

  /**
   * desc
   * build taxId from the two input fields
   * @param firstPart
   * @param secondPart
   * @returns {*}
   * @private
   */
  function _buildTaxId(firstPart, secondPart) {
    return firstPart.toString() + '-' + secondPart.toString();
  }

  /////////////////////////////
  //      PUBLIC API         //
  /////////////////////////////

  bigpie.join = {};

  /**
   * @param id
   * @description
   * Expose nonprofit id to 'join Bigpie' modal
   */
  bigpie.join.initNonprofitId = function(id) {
    bigpie.join.nonprofitId = id;
  };

  /**
   * Handles regular request for register from modal, do mostly validations
   * @param evt
   * @param type - entity type
   * @param emailField - Id selector of the email field
   * @param modal - father modal Id selector (for closing the modal)
   * @param firstField - Id selector of first field (nonprofits only)
   * @param lastField - Id selector of last field (nonprofits only)
   */
  bigpie.join.registerFromModal = function(evt, type, emailField, modal, firstField, lastField){
    evt.preventDefault();
    evt.stopPropagation();
    var email = $(emailField).val();
    var first = firstField ? $(firstField).val() : null;
    var last = firstField ? $(lastField).val(): null;
    var emailValid = true;
    var firstValid = true;
    var lastValid = true;
    // saves the email for later use in the resend email
    _$registeredEmail = email;
    _$registeredType = type;
    // email validations
    if (!_verifyEmail(_$registeredEmail)) {
      $(emailField).addClass(_invalidInputClass);
      emailValid = false;
    }
    // first and last fields validations
    firstValid = _validateEmptiness(firstField);
    lastValid = _validateEmptiness(lastField);
    if(!firstValid || !lastValid){
      $(modal).find(_inputErrorField).text('Please fill in all fields');
      return;
    } else if (!emailValid){
      $(modal).find(_inputErrorField).text('Invalid Email');
      return;
    }
    $(modal).modal('hide');
    $(emailField).removeClass(_invalidInputClass);

    // user exist check
    _userExists(email)
      .then(function(exists){
        if(!exists){
          // if not exist then register the user
          return _registerUser(email, type, first, last, _tmpTaxId, bigpie.join.nonprofitId)
            .then(function(){
              $(_joinPatronSuccess).modal('show');
            });
        }
        // if exist show forgot password modal
        $(_joinForgotPasswordModal).modal('show');
      });

  };

  /**
   * resend register email to an existing user, according to his type
   * @param type - patron, nonprofit or merchant
   */
  bigpie.join.resendInvite = function(type){
    $.ajax({
      url: bigpie.config.baseUrl + bigpie.config.register,
      type: "POST",
      data: {"email": _$registeredEmail, "type": type}
    })
      .done(function(){
        // show mail sent msg
        $(_mailSentMessage).removeClass('hidden');
      })
      .error(function(err){
        // show mail sent msg
        if(err.status == 400){
          $(_mailSentMessage).removeClass('hidden');
        } else {
          $(_errorModal).modal('show');
        }
      });
  };

  /**
   * Handles the request of the user for reset his password
   */
  bigpie.join.resetPassword = function(){
    _sendPasswordResetEmail(_$registeredEmail)
      .done(function(){
        $(_joinForgotPasswordModal).modal('hide');
      })
      .error(function(){
        $(_errorModal).modal('show');
      });
  };

  /**
   * Handles register request from the forgot password modal
   * @param evt
   */
  bigpie.join.newAccount = function(evt){
    evt.preventDefault();
    evt.stopPropagation();
    var email = $(_joinForgotPasswordEmailField).val();
    if (!_verifyEmail(email)) {
      $(_joinForgotPasswordEmailField).addClass(_invalidInputClass);
      return;
    }
    _$registeredEmail = email;
    $(_joinForgotPasswordModal).hide();

      // user exist check
    _userExists(email)
      .then(function (exists) {
        if (!exists) {
          // if not exist then register the user
          return _registerUser(email, _$registeredType)
            .then(function () {
              $(_joinPatronSuccess).modal('show');
            });
        } else {
          // if exist show forgot password modal
            $(_joinForgotPasswordDynamicEmail).text(_$registeredEmail);
            $(_joinForgotPasswordModal).show();
        }
      });
  };

  /**
   * Handles join nonprofit with taxId request
   * @param evt
   * @param firstTaxField
   * @param secondTaxField
   * @param modal
   */
  bigpie.join.joinWithTaxId = function(evt, firstTaxField, secondTaxField, modal){

    evt.preventDefault();
    evt.stopPropagation();
    var firstTaxIdVal = $(firstTaxField).val();
    var secondTaxIdVal = $(secondTaxField).val();

    // tax Id verification
    if(!_verifyTaxId(firstTaxIdVal,2)){
      $(firstTaxField).addClass(_invalidInputClass);
      $(firstTaxField).focus();
      $(modal).find(_inputErrorField).text('Invalid TaxId number');
      return;
    }

    $(firstTaxField).removeClass(_invalidInputClass);

    if(!_verifyTaxId(secondTaxIdVal,7)){
      $(secondTaxField).addClass(_invalidInputClass);
      $(secondTaxField).focus();
      $(modal).find(_inputErrorField).text('Invalid TaxId number');
      return;
    }

    // build taxId full value
    var taxId = _buildTaxId(firstTaxIdVal, secondTaxIdVal);

    $(modal).modal('hide');
    $.ajax({
      url: bigpie.config.baseUrl + bigpie.config.tax + '/' + taxId,
      type: "GET"
    })
      .done(function(res){
        cleanInputs([firstTaxField, secondTaxField]);
        // no entity was found - show create new nonprofit modal
        if(!res.entity){
          _tmpTaxId = taxId;
          setTimeout(function(){
            $(_joinWeNeedYourHelpTaxHeader).html(_tmpTaxId);
            $(_joinWeNeedYourHelpModal).modal('show');
          }, 500);
        }
        // found entity but state is unclaimed - show please confirm modal
        else if (res.entity && !res.user) {
          _$nonprofit = res.entity;
            setTimeout(function(){
              $(_joinPleaseConfirmModal).modal('show');
            }, 500);
        }
        // found a claimed entity - show already claim modal
        else if (res.entity && res.user){
            _$nonprofit = res.entity;
            setTimeout(function(){
              $(_joinAlreadyClaimedModal).modal('show');
            }, 500);
        }
      })
      .error(function(){
        $(_errorModal).modal('show');
      });
  };

  /**
   * Opens the claim modal with the nonprofit data
   * @param event
   */
  bigpie.join.claimListing = function(event){
    $(_joinPleaseConfirmModal).modal('hide');
    bigpie.openClaimModal(event, _$nonprofit.organizationName, _$nonprofit._id);
  };

  /**
   * Hide the current modal and open the target modal afterwards
   * @param fatherModal - the modal that should be closed
   * @param targetModal - the modal the should be opened
   */
  bigpie.join.openModal = function openModal(fatherModal, targetModal){
    if (fatherModal) {
      $(fatherModal).modal('hide');
    }
      $(targetModal).modal('show');
  };


  /////////////////////////////
  //       LISTENERS         //
  /////////////////////////////

  $(function () {

    // clear necessary fields upon a modal opening event + init dynamic fields
    $(_joinPatronModal).on('show.bs.modal', function () {
      _tmpTaxId = null;
      $(_emailField).removeClass(_invalidInputClass);
      $(_emailField).val('');
      $(_joinPatronModal).find(_inputErrorField).text('');
    });

    $(_joinMerchantModal).on('show.bs.modal', function () {
      $(_joinMerhcantEmailField).val('');
      $(_joinMerhcantEmailField).removeClass(_invalidInputClass);
      $(_joinMerchantModal).find(_inputErrorField).text('');
    });

    $(_joinForgotPasswordModal).on('show.bs.modal', function () {
      $(_joinForgotPasswordEmailField).removeClass(_invalidInputClass);
      $(_joinForgotPasswordEmailField).val('');
      $(_joinForgotPasswordDynamicEmail).text(_$registeredEmail);
    });

    $(_joinPatronSuccess).on('show.bs.modal', function () {
      $(_mailSentMessage).addClass('hidden');
      $(_joinPatronSuccessDynamicEmail).text(_$registeredEmail);
    });

    $(_joinNonprofitModal).on('show.bs.modal', function () {
      $(_joinNonprofitTaxIdField).val('');
      $(_joinNonprofitModal).find(_inputErrorField).text('');
      $(_joinNonprofitTaxIdField).removeClass(_invalidInputClass);
    });

    $(_joinWeNeedYourHelpModal).on('show.bs.modal', function(){
      //$(_joinWeNeedYourHelpTaxHeader).text(_$nonprofit.taxId);
      $(_joinWeNeedYourHelpTaxIdField).val('');
    });

    $(_joinCreateNonprofitModal).on('show.bs.modal', function () {
      $(_joinCreateNonprofitFirstField).val('');
      $(_joinCreateNonprofitLastField).val('');
      $(_joinCreateNonprofitEmailField).val('');
      $(_joinCreateNonprofitFirstField).removeClass(_invalidInputClass);
      $(_joinCreateNonprofitLastField).removeClass(_invalidInputClass);
      $(_joinCreateNonprofitEmailField).removeClass(_invalidInputClass);
      $(_joinCreateNonprofitModal).find(_inputErrorField).text('');
    });

    /**
     *
     * @param modal
     * @param taxField
     * @param taxLabel
     * @param claimedInfo
     * @param organizationName
     * @param city
     * @private
     */
    function _initModalWithInfo(modal, taxField, taxLabel, claimedInfo, organizationName, city){
      $(modal).find(_inputErrorField).text('');
      $(taxField).val('');
      $(taxField).removeClass(_invalidInputClass);
      $(taxLabel).text(_$nonprofit.taxId);
      $(claimedInfo).attr('href', _nonprofitHome + _$nonprofit.slug);
      $(organizationName).text(_$nonprofit.organizationName || 'No Name');
      if(_$nonprofit.city && _$nonprofit.city.length){
        $(city).text(_$nonprofit.city + ', ' + _$nonprofit.countryCode);
      } else {
        $(city).text('Unknown City');
      }
    }

    $(_joinAlreadyClaimedModal).on('show.bs.modal', function () {
      _initModalWithInfo(_joinAlreadyClaimedModal, _joinAlreadyClaimedTaxField, _joinAlreadyClaimedClaimedId, _joinAlreadyClaimedInfo
        , _joinAlreadyClaimedOrgName, _joinAlreadyClaimedCity)
    });

    $(_joinPleaseConfirmModal).on('show.bs.modal', function () {
      _initModalWithInfo(_joinPleaseConfirmModal, _joinPleaseConfirmTaxField, _joinPleaseConfirmClaimedId, _joinPleaseConfirmInfo
        , _joinPleaseConfirmOrgName, _joinPleaseConfirmCity)
    });

    function preventDefault(event){
      if(event.keyCode === 13){
        event.preventDefault();
        event.stopPropagation();
      }
    }

    // disable all enter button presses activity
    $('.modal').find('input').keydown(function(event){
      preventDefault(event);
    });

  });


  /////////////////////////////
  //          INIT           //
  /////////////////////////////

  _openModalIfNeeded();

})(jQuery, bigpie);