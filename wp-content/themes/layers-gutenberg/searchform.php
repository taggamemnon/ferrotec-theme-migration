<?php
/**
 * The template for displaying search forms in Underscores.me
 *
 * @package Underscores.me
 * @since Underscores.me 1.0
 */
?><span class="nav-icon icon-search hide" aria-hidden="true"></span>
                  <div class="search_wrapper" style="margin-bottom:30px;">
                     <form role="search" method="get" id="searchform" class="searchform form-horizontal" action="<?php echo get_home_url(); ?>">
                     	<div class="row">
                     		<div class="col-xs-10">
		                        <div class="form-group">
		                           <label class="screen-reader-text" for="s">Search for:</label>
		                           <input class="form-control" type="text" value="" name="s" id="s" >
		                        </div>
		                    </div>
	                        <div class="col-xs-2">
	                           <button type="submit" id="searchsubmit" class=" icon-search btn btn-default btn-sm"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></button>
							</div>
						</div>
                     </form>
                  </div>
