<!-- WE NEED YOUR HELP MODAL -->
<modal class="modal fade" id="bp_joinWeNeedYourHelp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog join_bigpie need_help blue_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h1 class="suggest_healine">We need your help</h1>
                <p>The Federal Tax ID you entered "<span id="bp_joinWeNeedYourHelp_taxHeader"></span>" was not <br>
                    found in our database of more than 1.6 million listing.
                </p>
            </div>
            <div class="modal-body">
                <!-- Suggest form -->
                <div class="row">
                    <div class="col-sm-6">
                        <h5>If the Tax ID is incorrect <br> update and search again.</h5>
                        <div class="not_me">
                            <form id="suggest_form">
                                <div class="form-group">
                                    <label for="nonprofitName">
                                        Enter a Federal Tax ID
                                    </label>
<!--                                    <input class="orange_input" placeholder="EIN or TIN #" id="bp_joinWeNeedYourHelp_taxId">-->
                                    <input class="orange_input two_digits" maxlength="2" id="bp_joinWeNeedYourHelp_taxId_2">
                                    <span class="hyphen">-</span>
                                    <input class="orange_input seven_digits" maxlength="7" id="bp_joinWeNeedYourHelp_taxId_7">
                                    <button class="btn_style_jumbo"
                                            onclick="bigpie.join.joinWithTaxId(event, '#bp_joinWeNeedYourHelp_taxId_2', '#bp_joinWeNeedYourHelp_taxId_7', '#bp_joinWeNeedYourHelp')">
                                        Search Again
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h5>If the number is correct, <br> create a new listing</h5>
                        <button class="btn_style_jumbo right_arrow" onclick="bigpie.join.openModal('#bp_joinWeNeedYourHelp', '#bp_joinCreateNonprofitModal')">
                            <span>Create New Listing</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</modal>
<!-- END WE NEED YOUR HELP MODAL -->