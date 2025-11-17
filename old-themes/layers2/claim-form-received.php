<?php
/*
Template Name: Claim Form Received
*/

get_header();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	NonprofitDirectory::claim($_POST);
}

?>

<section id="claim_form_received">
	<div class="content">
		<h2>Your account is being verified</h2>
		<p><i>Now we will quickly verify that you are the adminstrator of the nonprofit
		      listed in the BigPie Directory. Within the next 48 hours, usually much
		      sooner, we will activate your account and send an approval via email.</i></p>
	</div>
	<div class="next_step_info">
		<a href="<?php echo site_url('/how-to-set-a-fundraising-goal') ?>">
			Learn how to set a Fundraising Goal
		</a>
		<a href="<?php echo site_url('/find-local-merchants-with-matching-programs') ?>">
			Find local merchants with matching programs
		</a>
		<a href="<?php echo site_url('/kickstart-your-bigpie-giveback-program') ?>">
			Kickstart your BigPie giveback program by following our roadmap
		</a>
	</div>
</section>

<?php
get_footer();
?>
