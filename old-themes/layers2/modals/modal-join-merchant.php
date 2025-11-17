<!-- JOIN MERCHANT MODAL -->
<modal class="modal fade" id="bp_joinMerchantModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog join_bigpie join_for_merchent blue_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h1 class="suggest_healine">Join BigPie now!</h1>
                <p> Enter your email address and click "Next"</p>
            </div>
            <div class="modal-body">
                <!-- Suggest form -->
                <form id="suggest_form">
                    <div class="form-group">
                        <label for="nonprofitName">
                            Email Address
                        </label>
                        <input class="orange_input" placeholder="Required: i.e. bob@bigpie.com" id="bp_joinMerchantModal_name">
                        <p class="input_error"></p>
                    </div>
                </form>
                <div class="get_started_button_holder">
                    <button class="btn_style_jumbo right_arrow" onclick="bigpie.join.registerFromModal(event, 'merchant', '#bp_joinMerchantModal_name', '#bp_joinMerchantModal')">
                        Next
                    </button>
                </div>
            </div>

            <div class="modal-footer">
                <div>Oops. I want to join as a nonprofit.</div>
                <button class="" onclick="bigpie.join.openModal('#bp_joinMerchantModal', '#bp_joinNonprofitModal')">
                    BigPie for Nonprofits
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</modal>
<!-- END JOIN MERCHANT MODAL -->