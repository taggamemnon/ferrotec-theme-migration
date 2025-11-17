<!-- CREATE NEW NONPROFIT MODAL -->
<modal class="modal fade" id="bp_joinCreateNonprofitModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog join_bigpie enter_email blue_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h1 class="suggest_healine">Enter your email address</h1>
            </div>
            <div class="modal-body">
                <!-- Suggest form -->
                <form id="suggest_form">
                    <div class="form-group">
                        <label for="First">
                            First
                        </label>
                        <input class="orange_input" placeholder="Required" id="bp_joinCreateNonprofitModal_first">
                    </div>
                    <div class="form-group">
                        <label for="Last">
                            Last
                        </label>
                        <input class="orange_input" placeholder="Required" id="bp_joinCreateNonprofitModal_last">
                    </div>
                    <div class="form-group">
                        <label for="Email">
                            Email <br> Address
                        </label>
                        <input class="orange_input" placeholder="Required" id="bp_joinCreateNonprofitModal_email">
                        <p class="input_error"></p>
                    </div>
                </form>
                <div class="get_started_button_holder">
                    <button class="btn_style_jumbo right_arrow"
                            onclick="bigpie.join.registerFromModal(event,
                                    'nonprofit',
                                    '#bp_joinCreateNonprofitModal_email',
                                    '#bp_joinCreateNonprofitModal',
                                    '#bp_joinCreateNonprofitModal_first',
                                    '#bp_joinCreateNonprofitModal_last')">
                        Next
                    </button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</modal>
<!-- END CREATE NEW NONPROFIT MODAL -->