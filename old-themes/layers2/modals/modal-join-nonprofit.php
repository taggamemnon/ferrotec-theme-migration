<!-- JOIN NONPROFIT MODAL -->
<modal class="modal fade" id="bp_joinNonprofitModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog join_bigpie join_for_patron blue_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h1 class="suggest_healine">Join BigPie now!</h1>
                <p> If you know it, enter your Federal Tax ID number. If not,<br>choose "Join without a Tax ID".</p>
            </div>
            <div class="modal-body">
                <!-- Suggest form -->
                <form id="suggest_form">
                    <div class="form-group">
                        <label for="nonprofitName">
                            Federal Tax ID
                        </label>
                        <input class="orange_input two_digits" maxlength="2" id="bp_joinNonprofitModal_taxId_2">
                        <span class="hyphen">-</span>
                        <input class="orange_input seven_digits" maxlength="7" id="bp_joinNonprofitModal_taxId_7">
                        <p class="input_error"></p>
                    </div>
                </form>
                <div class="get_started_button_holder">
                    <button class="btn_style_jumbo without_tax" onclick="bigpie.join.openModal('#bp_joinNonprofitModal', '#bp_joinCreateNonprofitModal')">
                        Join without a Tax ID
                    </button>
                    <button class="btn_style_jumbo right_arrow"
                            onclick="bigpie.join.joinWithTaxId(event, '#bp_joinNonprofitModal_taxId_2', '#bp_joinNonprofitModal_taxId_7', '#bp_joinNonprofitModal')">
                        Next
                    </button>
                </div>
            </div>

            <div class="modal-footer">
                <div>Oops. I want to join as a merchant.</div>
                <button class="" onclick="bigpie.join.openModal('#bp_joinNonprofitModal', '#bp_joinMerchantModal')">
                    BigPie for Merchants
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</modal>
<!-- END JOIN NONPROFIT MODAL -->