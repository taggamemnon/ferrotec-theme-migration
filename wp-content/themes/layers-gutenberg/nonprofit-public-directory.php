<?php
/*
Template Name: Nonprofit public directory

*/

get_header();

// Handle pagination cursors
$pageNumber = (int)$_GET['cursor'] ?: 1;
$params     = array();

// If we came from a search request
if (isset($_GET['query'])) {
	$params['query'] = $_GET['query'];
	NonprofitDirectoryAPI::setQuery($_GET['query']);

}
if (isset($_GET['type'])) {
	$params['type'] = $_GET['type'];
	NonprofitDirectoryAPI::setCategory($_GET['type']);
}


// Get data
$nonprofits = NonprofitDirectoryAPI::getDirectory($pageNumber, $params);
$npTypes    = NonprofitDirectoryAPI::getTypes();
$states     = NonprofitDirectoryAPI::getStates();

?>

<script>
    /**
     * desc
     * open nonprofit page in a new tab
     * @param url
     */
    function openNonprofitPage(url) {
        var win = window.open(url, '_blank');
        win.focus();
    }
</script>
	<section class="nonprofit_directory_container blocks_wrapper_shadow" id="nonprofit_directory">

		<div class="section_header filter_search_section">
			<?php get_template_part('nonprofit', 'directory-header'); ?>

			<span class="indicator indicator_counter">Nonprofits found: <?php echo $nonprofits->total ?></span>

		</div>

		<div class="container_main">
			<div class="section_content">

				<div class="blocks_wrapper">
					<div>

						<?php foreach ($nonprofits->results as $nonprofit) { ?>
							<a href="<?php echo site_url('/nonprofits/') . $nonprofit->slug ?>" class="block block_nonprofit">

								<contents class="block_contents">

									<!-- Nonprofit name and info -->
									<div class="block_header">
										<div>
											<h3>
												<?php
													if(empty($nonprofit->displayName))
														echo $nonprofit->organizationName;
													else
														echo $nonprofit->displayName;
												?>
											</h3>
											<p><?php
												if(empty($nonprofit->billingAddress)){
													echo $nonprofit->city; if (!empty($nonprofit->city)) { echo ' , ';}?><?php echo $nonprofit->countryCode;
												} else {
													echo $nonprofit->billingAddress->city;
													if (!empty($nonprofit->billingAddress->city)) {
														echo ' , ';
													}?><?php echo $nonprofit->billingAddress->countryCode;
												}

												?>
											</p>
										</div>

										<!-- Profile image -->
										<div class="profile_img">
<!--											<img src="--><?php //echo $nonprofit->typeIcon; ?><!--">-->

											<?php /*if ( ! $nonprofit->registrationProgress->incompleteRegistration) { ?>
												<small>
													JOINED<br><span class="joined_year">
                                                        <?php echo date('Y', strtotime($nonprofit->createdAt)) ?>
                                                    </span>
												</small>
											<?php }*/ ?>

										</div>
									</div>

									<!-- Footer -->
									<div class="block_footer">

										<!-- Visit page and matches -->
										<div class="first_row <?php if (count($nonprofit->activeMatches) > 0)
											echo 'has_matches' ?>">
											<div class="visit_page">
												<div class="block_more" href="">
													Visit Page
													<i>
														<img src="<?php echo get_bloginfo('template_url'); ?>/img/bigpie/visit-page.jpg">
													</i>
												</div>
											</div>

											<?php if (count($nonprofit->activeMatches) > 0) { ?>
												<div class="active_merchant">
													<?php echo count($nonprofit->activeMatches); ?> Active <br> MerchantMatches
												</div>
											<?php } ?>
										</div>
										<div class="new_middle_row">
											<span class="total-giveback">
												Total Giveback:
												<?php if(!empty($nonprofit->donated->yearToDate)){
													echo '$'.$nonprofit->donated->lifetime;
												} else {
													echo '$0';
												}?>
											</span>
											<span class="year-to-date">
												Year-to-date
												<?php if(!empty($nonprofit->donated->yearToDate)){
													echo '$'.$nonprofit->donated->yearToDate;
												} else {
													echo '$0';
												}?>
											</span>
										</div>
										<div class="second_row">

											<?php if ($nonprofit->activeGoal) { ?>
												<div class="nonprofit_goal">
													<span>Current Goal:
														<span>$<?php echo $nonprofit->activeGoal->amount; ?></span>
													</span>

													<div class="goal_name">
														<p class="goal_title"><?php echo $nonprofit->activeGoal->title; ?></p>
														<meter value="<?php echo BigPieUtils::calcRatio($nonprofit->activeGoal); ?>">
															<span style="width: <?php echo BigPieUtils::calcRatio($nonprofit->activeGoal);?>%;"></span>
														</meter>
                                                <span class="raised">
                                                    Raised <span>$<?php echo round($nonprofit->activeGoal->donated); ?></span>
                                                </span>

													</div>
												</div>
											<?php } ?>

										</div>
									</div>

								</contents>
							</a>
						<?php } ?>

					</div>

					<!-- The no results div -->
					<?php if (count($nonprofits->results) == 0) { ?>
						<div class="no_results">
							<p>There are no nonprofits matching your filter.</p>
						</div>
					<?php } ?>

					<!-- Pagination -->
					<?php if ($nonprofits->numPages > 1) { ?>
						<nav class="pagination_wrapper">
							<ul class="nonprofit_directory_pagination pagination">
								<li>
									<?php if ( $pageNumber == 1 ) { ?>
										<a href="<?php echo NonprofitDirectoryAPI::PAGE_URL ?>"
										   class="disabled" disabled>&laquo;</a>
									<?php } else { ?>
										<a href="<?php echo NonprofitDirectoryAPI::PAGE_URL ?>">&laquo;</a>
									<?php } ?>
								</li>
								<li>
									<?php if ( $pageNumber == 1 ) { ?>
										<a href="<?php echo NonprofitDirectoryAPI::getPage($pageNumber - 1); ?>"
										   class="disabled" disabled>&lt; prev</a>
									<?php } else { ?>
										<a href="<?php echo NonprofitDirectoryAPI::getPage($pageNumber - 1); ?>">&lt; prev</a>
									<?php } ?>
								</li>
								<li>
									<?php if ( $pageNumber == $nonprofits->numPages ) { ?>
										<a href=" <?php echo NonprofitDirectoryAPI::getPage($pageNumber + 1) ?>"
										   class="disabled" disabled> next &gt;</a>
									<?php } else { ?>
										<a href="<?php echo NonprofitDirectoryAPI::getPage($pageNumber + 1); ?>">
											next &gt;
										</a>
									<?php } ?>
								</li>
							</ul>
						</nav>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="container_main section_footer clearfix">
			<section id="cant_find" class="cant_find">
				<aside>
					<button class="btn_style_mini" data-toggle="modal" data-target="#suggestModal">Suggest Listing</button>
				</aside>
				<div>
					<h3 class="left_align">Can't find your Nonprofit?</h3>
					<p>Use the search fields at the top of the directory to narrow your search. If you still can't find your Nonprofit, we
					   can add it.</p>
				</div>
			</section>
		</div>

		<!-- SUGGEST MODAL -->
		<modal class="modal fade" id="suggestModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog claim_modal">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h1 class="suggest_healine">Suggest a listing</h1>
					</div>
					<div class="modal-body">
						<!-- Suggest form -->
						<form id="suggest_form">
							<div class="form-group">
								<label for="nonprofitName">
									<h5 class="two_lines_fix">Nonprofit Name</h5>
								</label>
								<input class="form-control" placeholder="Required" id="suggest_form_name">
							</div>
							<div class="form-group">
								<label for="state">
									<h5>State</h5>
								</label>
								<select class="form-control" id="suggest_form_state">
									<?php foreach ($states as $index => $state) { ?>
										<option value="<?php echo $index ?>">
											<?php echo $state->abbreviation ?>
										</option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label for="city">
									<h5>City</h5>
								</label>
								<input class="form-control" id="suggest_form_city">
							</div>
							<div class="form-group">
								<label for="website">
									<h5>Website</h5>
								</label>
								<input class="form-control" placeholder="i.e. www.nonprofitname.org" id="suggest_form_website">
							</div>
						</form>
						<div class="get_started_button_holder">
							<button class="btn_style_jumbo" onclick="bigpie.submitSuggest(event)">
								Suggest
							</button>
						</div>


					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</modal>
		<!-- END SUGGEST MODAL -->

		<!-- THANK YOU FOR SUGGEST MODAL -->
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
		<!-- END YOU FOR SUGGEST MODAL -->


		<!-- ERROR SUGGEST MODAL -->
		<modal class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">

			<div class="modal-dialog thank_you_modal">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="title">Error</div>
						<p>
							An Error had occurred during the sending of the form, please try again later.
						</p>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
		</modal>
		<!-- END ERROR SUGGEST MODAL -->



	</section>

<?php
get_footer();
