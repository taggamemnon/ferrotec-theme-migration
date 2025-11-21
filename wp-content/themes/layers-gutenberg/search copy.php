<?php
/**
*/

get_header(); ?>

<div class="content interior clearfix">
	<div class="container">
	<div class="row-xs-12">
		<h2 class="pagetitle">Search Results</h2>

		<script>
		  (function() {
		    var cx = '010749595198001975568:zaqqztdz9zy';
		    var gcse = document.createElement('script');
		    gcse.type = 'text/javascript';
		    gcse.async = true;
		    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
		        '//www.google.com/cse/cse.js?cx=' + cx;
		    var s = document.getElementsByTagName('script')[0];
		    s.parentNode.insertBefore(gcse, s);
		  })();
		</script>
		<gcse:searchresults-only queryParameterName="s"></gcse:searchresults-only>
	</div>
	</div>
</div>

<?php get_footer(); ?>