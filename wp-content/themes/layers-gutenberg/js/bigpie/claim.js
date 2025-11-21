'use strict';
/**
 * Created by eliorb on 11/06/2015.
 */
var bigpie = bigpie || {};

(function claim ($, bigpie) {

    /////////////////////////////
    //   PRIVATE VARIABLES     //
    /////////////////////////////

    var npName;
    var npId;
    var _claimModal     = '#claimModal';
    var _nameField      = '#claimName';
    var _lastField      = '#claimLast';
    var _emailField     = '#claimEmail';
    var _phoneField     = '#claimPhone';
    var _errorField     = '#claimError';
    var _invalidClass   = 'invalid';

    /////////////////////////////
    //   PRIVATE METHODS       //
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
     * Check if a field is empty, if yes then set the invalid class on it
     * @param field
     * @returns {boolean} - valid : true else false
     * @private
     */
    function _validateEmptiness(field){
        if($(field).val() === ''){
            $(field).addClass(_invalidClass);
            return false;
        }
        $(field).removeClass(_invalidClass);
        return true;
    }

    /////////////////////////////
    //      PUBLIC API         //
    /////////////////////////////

    /**
     * Open the claim modal, save organization name and Id of the nonprofit
     * @param event
     * @param organizationName
     * @param id - nonprofit Id
     */
    bigpie.openClaimModal = function openClaimModal(event, organizationName, id){
        event.preventDefault();
        event.stopPropagation();
        var $claimModal = $('#claimModal');
        // init dynamic data
        npName = organizationName;
        npId = id;
        //
        $claimModal.find('.sub_title').text(organizationName);
        $claimModal.modal('show');
    };

    /**
     * Send the claim form
     * @param event
     * @returns {*}
     */
    bigpie.claimListing = function claimListing (event) {
        event.preventDefault();
        event.stopPropagation();

        var $claimModal = $('#claimModal'),
            $tyModal    = $('#thankYouModal');

        // fetch data
        var name   = $claimModal.find(_nameField).val(),
            last   = $claimModal.find(_lastField).val(),
            email  = $claimModal.find(_emailField).val(),
            phone  = $claimModal.find(_phoneField).val();

        // validations
        var nameValid = _validateEmptiness(_nameField);
        var lastValid =_validateEmptiness(_lastField);
        var phoneValid =_validateEmptiness(_phoneField);
        if(!_verifyEmail(email)){
            $(_emailField).addClass(_invalidClass);
        }

        if(!nameValid  || !lastValid || !phoneValid){
            $(_errorField).text('Please fill in all fields');
            return;
        } else if (!_verifyEmail(email)){
            $(_errorField).text('Invalid email address');
            return;
        }

        return $.post(bigpie.config.baseUrl + '/claim', {
            claimName: name,
            claimLast: last,
            claimEmail: email,
            claimPhone: phone,
            npId: npId,
            npName: npName
        })
            .success(function (response) {
                $claimModal.modal('hide');
                $(_errorField).text('');
                window.location.replace('/claim-form-received');
            })
            .error(function (error) {
                if (error.responseJSON) {
                    $(_errorField).text(error.responseJSON.message);
                }
            });

    };

    /**
     * Check by the server if the provided email already exists in the system.
     * @param email
     * @returns {Promise}
     */
    function checkEmailExists (email) {
        var deferred = $.Deferred();

        $.get(bigpie.config.baseUrl + '/user?' + encodeURIComponent(email))
            .success(function onEmailFound () {
                deferred.reject('This email is already taken.');
            })
            .error(function onEmailNotFound () {
                deferred.resolve();
            });

        return deferred.promise();
    }

    $(function(){
        // clear necessary fields upon a modal opening event + init dynamic fields
        $(_claimModal).on('show.bs.modal', function () {
            $(_nameField).val('');
            $(_lastField).val('');
            $(_phoneField).val('');
            $(_emailField).val('');
            $(_errorField).text('');
            $(_nameField).removeClass(_invalidClass);
            $(_lastField).removeClass(_invalidClass);
            $(_phoneField).removeClass(_invalidClass);
            $(_emailField).removeClass(_invalidClass);
        });

    });

})(window.jQuery, bigpie);
