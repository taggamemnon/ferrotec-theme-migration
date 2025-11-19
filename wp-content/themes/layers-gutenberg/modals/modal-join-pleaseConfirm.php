<!-- PLEASE CONFIRM MODAL -->
<modal class="modal fade" id="bp_joinPleaseConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog confirm blue_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" >
                <!-- Not me form -->
                <h1 class="suggest_healine">Please confirm</h1>
                <p>Confirm that we've found the correct nonprofit by clicking <br>
                    "Confirm Listing". If the wrong nonprofit is showing, double <br>
                    check the entered Tax ID and search again or click <br>
                    "Create New Listing..." if you're unable to find your <br>
                    nonprofit in our database.
                </p>
                <div class="not_me">
                    <p class="title">Not me!</p>
                    <p id="bp_joinPleaseConfirmModal_claimedTax"></p>
                    <form id="suggest_form">
                        <div class="form-group">
                            <label for="nonprofitName">
                                Enter a Federal Tax ID
                            </label>
                            <input class="orange_input two_digits" maxlength="2" id="bp_joinPleaseConfirmModal_taxId_2">
                            <span class="hyphen">-</span>
                            <input class="orange_input seven_digits" maxlength="7" id="bp_joinPleaseConfirmModal_taxId_7">
                            <button class="btn_style_jumbo"
                                    onclick="bigpie.join.joinWithTaxId(event, '#bp_joinPleaseConfirmModal_taxId_2', '#bp_joinPleaseConfirmModal_taxId_7', '#bp_joinPleaseConfirmModal')">
                                Search Again
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Already Claimed nonprofit details -->
                <div class="block block_nonprofit">
                    <a id="bp_joinPleaseConfirmModal_info" target="_blank">
                        <contents class="block_contents">

                            <!-- Nonprofit name and info -->
                            <div class="block_header">
                                <div>
                                    <h3 id="bp_joinPleaseConfirmModal_orgName"></h3>
                                    <p id="bp_joinPleaseConfirmModal_city"></p>
                                </div>
                                <!-- Profile image -->
                                <div class="profile_img">
                                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/profile.jpg">
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="block_footer">

                                <!-- Visit page and matches -->
                                <div class="first_row">
                                    <div class="visit_page">
                                        <div class="block_more" href="">
                                            Visit Page
                                            <i>
                                                <img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/visit-page.jpg">
                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="second_row">
                                </div>
                            </div>
                        </contents>
                    </a>
                </div>
                <p class="input_error"></p>
                <!-- Already Claimed nonprofit details -->
                <div class="row">
                    <button class="" onclick="bigpie.join.openModal('#bp_joinPleaseConfirmModal', '#bp_joinCreateNonprofitModal')">
                        Join without Tax ID
                    </button>
                    <button class="btn_style_jumbo right_arrow" onclick="bigpie.join.claimListing(event)">
                        Claim Listing
                    </button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</modal>
<!-- END PLEASE CONFIRM MODAL -->