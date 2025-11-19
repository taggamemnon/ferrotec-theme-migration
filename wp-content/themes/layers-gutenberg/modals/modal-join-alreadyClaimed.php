<!-- LISTING ALREADY CLAIMED -->
<modal class="modal fade" id="bp_joinListringAlreadyClaimedModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog already_claimed blue_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" >
                <h1 class="suggest_healine">Listing already claimed</h1>
                <!-- Not me form -->
                <div class="not_me">
                    <p class="title">Not me!</p>
                    <p id="bp_joinListringAlreadyClaimedModal_claimedTax"></p>
                    <form id="suggest_form">
                        <div class="form-group">
                            <label for="nonprofitName">
                                Enter a Federal Tax ID
                            </label>
<!--                            <input class="orange_input" placeholder="Required: EIN or TIN number" id="bp_joinListringAlreadyClaimedModal_taxId">-->
                            <input class="orange_input two_digits" maxlength="2" id="bp_alreadyClaimedModal_taxId_2">
                            <span class="hyphen">-</span>
                            <input class="orange_input seven_digits" maxlength="7" id="bp_alreadyClaimedModal_taxId_7">
                            <button class="btn_style_jumbo"
                                    onclick="bigpie.join.joinWithTaxId(event, '#bp_alreadyClaimedModal_taxId_2', '#bp_alreadyClaimedModal_taxId_7', '#bp_joinListringAlreadyClaimedModal')">
                                Search Again
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Already Claimed nonprofit details -->
                <div class="block block_nonprofit">
                    <a id="bp_joinListringAlreadyClaimedModal_info" target="_blank">
                        <contents class="block_contents">

                            <!-- Nonprofit name and info -->
                            <div class="block_header">
                                <div>
                                    <h3 id="bp_joinListringAlreadyClaimedModal_orgName"></h3>
                                    <p id="bp_joinListringAlreadyClaimedModal_city"></p>
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
            </div>
            <p>
                If you have questions contact <a href="mailto:nonprofit-support@bigpie.com">nonprofit-support@bigpie.com</a>
            </p>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</modal>
<!-- END LISTING ALREADY CLAIMED -->