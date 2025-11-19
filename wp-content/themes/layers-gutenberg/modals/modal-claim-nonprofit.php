


<modal class="modal fade" id="claimModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog claim_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="title">Claim this listing</div>
                <div class="sub_title"></div>

                <form name="claim" onsubmit="bigpie.claimListing(event)">
                    <div>
                        <label for="claimName">Name</label>
                        <input type="text" name="claimName" id="claimName" placeholder="Required">
                    </div>
                    <div>
                        <label for="claimLast">Last</label>
                        <input type="text" name="claimLast" id="claimLast" placeholder="Required">
                    </div>
                    <div>
                        <label for="claimPhone">Phone</label>
                        <input type="tel" name="claimPhone" id="claimPhone" placeholder="Required">
                    </div>
                    <div>
                        <label for="claimEmail">Email</label>
                        <input placeholder="Required" name="claimEmail" id="claimEmail" placeholder="Required">
                    </div>
                    <p class="input_error" id="claimError"></p>

                    <button class="submit_btn" type="submit">Claim</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</modal>

<modal class="modal fade" id="thankYouModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog thank_you_modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="title">Thank you!</div>
                <p>
                    We appreciate your suggestion. Our team of researchers will
                    locate them and encourage them to join BigPie.
                </p>
                <p>Please help us spread the word about BigPie in your
                    community.</p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</modal>
