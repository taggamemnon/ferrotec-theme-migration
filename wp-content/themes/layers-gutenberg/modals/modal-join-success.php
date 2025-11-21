<!-- modal join patron success -->
<modal class="modal fade" id="bp_joinPatronSuccess" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog success_modal  orange_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <h1 class="title">Look in your email</h1>
                <p>
                    An email was sent to <span class="bp_joinPatronSuccess_dynamicEmail"></span> with a link that will log you into BigPie.
                </p>
                <p>
                    If the email is not in your inbox, please look in your junk/spam folder as your system may have not recognized our email server.
                </p>
                <p>
                    If you have not received an email within 5 minutes, click "Resend Invite" and a second email will be sent.
                </p>
                <div class="button_holder">
                    <button class="btn_style_jumbo" onclick="bigpie.join.resendInvite('patron')">Resend Invite</button>
                </div>
                <p id="bp_joinPatronSuccess_resend" class="hidden">The invite has been resend to <span class="bp_joinPatronSuccess_dynamicEmail"></span></p>
                <p>If you need additional support please send an email to <a href="mailto:support@bigpie.com">support@bigpie.com</a>.
                </p>
            </div>
        </div>
        <!-- modal/modal-content -->
    </div>
</modal>
<!-- END modal join patron success -->