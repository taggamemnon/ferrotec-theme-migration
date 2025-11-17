<?php
/*
Template Name: Nonprofit public info
*/

get_header();

$nonprofitId = $wp_query->query_vars['nonprofit'];

// Get the nonprofits and types
$nonprofit = NonprofitDirectoryAPI::getNonprofit($nonprofitId);

// If error
if ($nonprofit->message) {
	$error     = 'There is no nonprofit with this id';
	$nonprofit = null;
}

// TODO CREATE NONPROFIT CLASS
function getTopMerchants ($nonprofit, $limit) {
	return array_slice($nonprofit->topMerchants->merchants, 0, $limit);
}

function getRecentMerchants ($nonprofit, $limit) {
	return array_slice($nonprofit->recentMerchants, 0, $limit);

}

// return true if the np have a billing address
function hasBillingAddress($nonprofit){
	return (!empty($nonprofit->billingAddress) && (!empty($nonprofit->billingAddress->address)||
													!empty($nonprofit->billingAddress->street)||
													!empty($nonprofit->billingAddress->street2) ||
													!empty($nonprofit->billingAddress->city)));
}

function urlify ($url) {
	if ( ! preg_match("~^(?:f|ht)tps?://~i", $url)) {
		$url = "http://" . $url;
	}

	return $url;
}

?>
	<script type="text/javascript">
		var nonprofitInfoState = {
			showTooltip: false
		};

		function openTooltip () {
			nonprofitInfoState.showTooltip = true;

			document.getElementById('tooltip').style.display = nonprofitInfoState.showTooltip ? 'block' : 'none';
		}

		function closeTooltip () {
			nonprofitInfoState.showTooltip = false;

			document.getElementById('tooltip').style.display = nonprofitInfoState.showTooltip ? 'block' : 'none';
		}

		function toggleTooltip () {
			nonprofitInfoState.showTooltip = !nonprofitInfoState.showTooltip;

			document.getElementById('tooltip').style.display = nonprofitInfoState.showTooltip ? 'block' : 'none';
		}

		function shareLink (url) {
			window.open("https://www.facebook.com/sharer/sharer.php?u=" + url, '_blank', 'width=600, height=300')
		}

        /**
         * @param id - nonprofit entity id
         * @description
         * Expose nonprofit id to 'join Bigpie' modal
         */
        function initNonprofitId(id) {
            bigpie.join.nonprofitId = id;
        }

	</script>

<?php if ($nonprofit) : ?>

    <script>
        initNonprofitId('<?php echo $nonprofit->id ?>');
    </script>

	<section class="nonprofit_info_wrapper" id="nonprofit_directory">

		<!-- NONPROFITINFO -->
		<div>
			<div class="section_header filter_search_section">
				<?php get_template_part('nonprofit', 'directory-header'); ?>
			</div>
		</div>

		<div class="container_main nonprofit_info" id="nonprofitInfo">

			<!-- Header -->
			<div class="info_header">
				<div class="info_title">
					<h1><?php
						if(empty($nonprofit->displayName)) {echo $nonprofit->organizationName;}
						else {echo $nonprofit->displayName;}
						?>
					</h1>
					<?php if(!hasBillingAddress($nonprofit)){ ?>
						<p><?php echo $nonprofit->street ?></p>
						<p><?php echo $nonprofit->zip ?>&nbsp;<?php echo $nonprofit->city ?>&nbsp;<?php echo $nonprofit->countryCode ?></p>
					<?php }
						  else { ?>
						<p><?php echo $nonprofit->billingAddress->street.' '.$nonprofit->billingAddress->street2 ?></p>
						<p><?php echo $nonprofit->billingAddress->zip ?>&nbsp;<?php echo $nonprofit->billingAddress->city ?>&nbsp;<?php echo $nonprofit->billingAddress->countryCode ?></p>
					<?php } ?>
				</div>

				<div class="action_menu">
					<div>

						<?php if ( ! $nonprofit->registrationProgress->incompleteRegistration) { ?>
							<span class="nptype"><?php echo $nonprofit->npType ?></span>
<!--							<img src="--><?php //echo $nonprofit->typeIcon; ?><!--" class="categoryIcon">-->
						<?php } ?>

					</div>
					<div class="drop_down" style="display: none;">
						<a href="">Select for Giveback</a>
						<ul>
							<li><a href="">action1</a></li>
							<li><a href="">action1</a></li>
							<li><a href="">action1</a></li>
							<li><a href="">action1</a></li>
						</ul>
					</div>
					<div class="drop_down small" style="display: none;">
						<a href="">Research this nonprofit</a>
						<ul>
							<li><a href="">action1</a></li>
							<li><a href="">action1</a></li>
							<li><a href="">action1</a></li>
							<li><a href="">action1</a></li>
						</ul>
					</div>

				</div>

				<!-- Sheare Section -->
				<div class="share_section clearfix">
					<?php if ($nonprofit->websiteURL) { ?>
						<a class="web_site" target="_blank" href="<?php echo urlify($nonprofit->websiteURL) ?>">
							<i class="world_icon">
								<img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/icon_set4.jpg">
							</i><?php echo removeProtocolPrefix($nonprofit->websiteURL) ?>
						</a>
					<?php } ?>

					<div class="share_wrapper">
						<a href="#" onclick="shareLink('<?php echo site_url("/nonprofits/") . $nonprofit->slug ?>')">
							<i class="facebook">
								<img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/icon_set2.jpg">
							</i>Facebook
						</a>
						<a href="#" onclick="shareLink('<?php echo site_url("/nonprofits/") . $nonprofit->slug ?>')">
							<i class="share_page">
								<img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/icon_set3.jpg">
							</i>Share this page
						</a>
					</div>
				</div>
			</div>

			<div class="content_wrapper">
				<!-- Modal content -->
				<div class="content">
					<?php if ($nonprofit->about) : ?>
						<h4 class="mission">Mission Statement</h4>
						<p class="about"><?php echo $nonprofit->about ?></p>
					<?php endif ?>

					<?php if (BigPieUtils::showMerchantsSection($nonprofit)) { ?>
						<div class="merchant_tables">

							<?php if (count($nonprofit->activeMatches) > 0) { ?>

								<table class="merchant_table merchant_matches_table">
									<thead>
									<tr>
										<th>Active Merchant Matches</th>
										<th>Match Commitment</th>
										<th>Achieved</th>
										<th>Days Remaining</th>
									</tr>
									</thead>

									<tbody>

									<?php foreach ($nonprofit->activeMatches as $match) { ?>
										<tr>
											<td><?php echo $match->merchantId->organizationName ?></td>
											<td>$<?php echo round($match->maxAmount) ?></td>
											<td>$<?php echo round($match->balance) ?></td>
											<td class="remaining"><?php echo BigPieUtils::calcDaysDiff($match->endDate, $match->startDate) ?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							<?php } ?>

							<?php if (count($nonprofit->topMerchants->merchants) > 0) { ?>
								<table class="merchant_table merchant_top_table half-width">
									<thead>
									<tr>
										<th>Top Merchants</th>
									</tr>
									</thead>

									<tbody>
									<?php foreach (getTopMerchants($nonprofit, 5) as $merchant) { ?>
										<tr>
											<td><?php echo $merchant->organizationName ?></td>
										</tr>
									<?php } ?>
								</table>
							<?php } ?>

							<?php if (count($nonprofit->recentMerchants) > 0) { ?>

								<table class="merchant_table merchant_top_table half-width" style="margin-left: -5px;">
									<thead>
									<tr>
										<th>Recent Merchant Giveback</th>
									</tr>
									</thead>

									<tbody>
									<?php foreach (getRecentMerchants($nonprofit, 5) as $merchant) { ?>
										<tr>
											<td><?php echo $merchant->organizationName ?></td>
										</tr>
									<?php } ?>
								</table>
							<?php } ?>
						</div>
					<?php } ?>
				</div>

				<!-- Side Bar	 -->
				<div class="info_sidebar">

					<?php if ($nonprofit->supportingPatrons > 0) { ?>
						<div class="support_and_raised">
							<div class="support">
								<div>Supporting patrons</div>
								<div class="number"><?php echo $nonprofit->supportingPatrons ?></div>
							</div>
							<div class="raised">
								<div class="giveback">Lifetime giveback raised</div>
								<div class="price">$<?php echo round($nonprofit->donated->lifetime) ?></div>
							</div>
						</div>
					<?php } ?>


					<?php if ($nonprofit->activeGoal) { ?>
						<div class="fundraising" style="margin-left: -2px;">
							<div class="title">Current fundraising goal</div>

							<div class="upgrade">
								<?php echo $nonprofit->activeGoal->title ?>
								<a href="javascript:void(0)" class="info_icon" onclick="openTooltip()">
									<img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/icon_set5.jpg">
								</a>

								<div class="tooltip" id="tooltip" style="display: none">
									<div class="tooltip_content">
										<button type="button" class="close" onclick="closeTooltip()">&times;</button>
										<h4><?php echo $nonprofit->activeGoal->title ?></h4>
										<p><?php echo $nonprofit->activeGoal->description ?></p>
									</div>
								</div>
							</div>

							<div class="goal">Goal: $<?php echo round($nonprofit->activeGoal->amount) ?></div>

							<meter value="<?php echo BigPieUtils::calcRatio($nonprofit->activeGoal); ?>">
								<span style="width: <?php echo BigPieUtils::calcRatio($nonprofit->activeGoal); ?>%;"></span>
							</meter>

							<small class="raised">Raised:
								<span class="price">$<?php echo round($nonprofit->activeGoal->donated) ?></span>
							</small>

							<div class="remaining">
								<span>Days Remaining<span><?php echo BigPieUtils::calcGoalDaysRemaining($nonprofit) ?></span></span>

								<?php if ($nonprofit->activeGoal->url) { ?>
									<a href="<?php echo $nonprofit->activeGoal->url ?>" target="_blank">
                                        Goal Web page <i>
											<img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/icon_set6.jpg">
										</i>
									</a>
								<?php } ?>
							</div>
						</div>
					<?php } ?>

                    <!-- Display donation box only if there is a donation link attached to nonprofit -->
                    <?php if ($nonprofit->donationLink) { ?>
                        <div class="donate">
                            You can donate directly to us too. Visit our website.
                            <a <?php if ($nonprofit->donationLink) { ?>
                                href="<?php echo $nonprofit->donationLink ?>" target="_blank"
                                <?php } ?>
                                >
                                Direct donation web page
                                <i>
                                    <img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/icon_set7.jpg">
                                </i>
                            </a>
                        </div>
                    <?php } ?>
				</div>
			</div>

			<?php if ( ! $nonprofit->hasUsers) : ?>
				<div class="claim">
					<p>Do you manage this Nonprofit?</p>
					<button class="btn_style_mini"
						onclick="bigpie.openClaimModal(event, '<?php echo $nonprofit->organizationName ?>', '<?php echo $nonprofit->id ?>')">
						Claim listing
					</button>
				</div>
			<?php endif ?>
		</div>



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

	</section>
<?php else : ?>
	<section class="nonprofit_info_wrapper" id="nonprofit_directory">
		<div class="no_results">
			<p>There is no such nonprofit with this name</p>
		</div>
	</section>
<?php endif ?>
<?php
get_footer();
