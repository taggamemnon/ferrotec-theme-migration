<!-- JOIN PATRON MODAL -->
<modal class="modal fade" id="bp_joinPatronModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog join_bigpie blue_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h1 class="suggest_healine">Join BigPie now!</h1>
                <p>Enter your email to start. No credit cards. No fees.<br>Just choose your nonprofits and begin earning giveback for them.</p>
            </div>
            <div class="modal-body">
                <!-- Suggest form -->
                <form id="suggest_form">
                    <div class="form-group">
                        <label for="nonprofitName">
                            Email Address
                        </label>
                        <input class="orange_input" placeholder="Required: i.e. bob@bigpie.com" id="bp_joinPatronModal_name">
                        <p class="input_error"></p>
                    </div>
                </form>
                <div class="get_started_button_holder">
                    <button class="btn_style_jumbo" onclick="bigpie.join.registerFromModal(event, 'patron', '#bp_joinPatronModal_name', '#bp_joinPatronModal')">
                        Submit
                    </button>
                </div>
            </div>

            <div class="modal-footer">
                <div>Nonprofits and merchants can join here...</div>
                <button class="" onclick="bigpie.join.openModal('#bp_joinPatronModal', '#bp_joinNonprofitModal')">
                    BigPie for Nonprofits
                </button>
                <button class="" onclick="bigpie.join.openModal('#bp_joinPatronModal', '#bp_joinMerchantModal')">
                    BigPie for Merchants
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</modal>
<!-- END JOIN MODAL -->