<!-- modal join patron forgot password -->
<modal class="modal fade" id="bp_joinPatronForgotPassword" tabindex="-1" role="dialog" aria-hidden="true" style="height: 600px;">
    <div class="modal-dialog light_blue_modal forgot_password">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <h1 class="title">Did you forget your password?</h1>
                <p>
                    An account with your email address <span id="bp_joinPatronForgotPassword_dynamicEmail"></span> is already in use.
                    You can either reset the password, or you can create a new account.
                </p>
                <div class="border_box_container">
                    <div class="border_box ">
                        <p>
                            Email temporary password
                        </p>
                        <button class="btn-default" onclick="bigpie.join.resetPassword()">
                            Reset Password
                        </button>
                    </div>
                    <div class="border_box new_account" >
                        <p>
                            Create new BigPie account
                        </p>
                        <input placeholder="Enter your email address" id="bp_joinPatronForgotPassword_email">
                        <button class="btn-default" onclick="bigpie.join.newAccount(event)">
                            New account
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</modal>
<!-- END modal join patron forgot password -->