<?php
   /**
    * The template for displaying 404 pages (not found).
    *
    * @package Hillstone
    */
   
   get_header(); ?>
<div id="primary" class="content-area">
   <main id="main" class="site-main" role="main">
      <section class="error-404 not-found">
         <header class="page-header">
            <h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'Ferrotec' ); ?></h1>
         </header>
         <!-- .page-header -->
         <div class="page-content">
            <div class="wrapper orange">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12">
                        <h1>We’re sorry&mdash;something has gone wrong on our end</h1>
                        <h3>What could have caused this?</h3>
                        <p>Well, something technical went wrong on our site.</p>
                        <p>We might have removed the page when we redesigned our website.</p>
                        <p>Or the link you clicked might be old and does not work anymore.</p>
                        <p>Or you might have accidentally typed the wrong URL in the address bar.</p>
                        <h3>What you can do?</h3>
                        <p>You might try retyping the URL and trying again.</p>
                        <p>Or we could take you return to the <a href="/">Ferrotec home page</a>.</p>
                        <h3>One more thing:</h3>
                        <p>If you want to help us fix this issue, we are here to help. <a href="mailto:info@ferrotec.com?subject=404 Error&amp;body=Please tell us went wrong, the URL you were requesting, the type of device you were connecting with. For example, Windows laptop or iPhone, a tablet. Please contact us and let us know what went wrong.">Please tell us went wrong</a> Be sure to let us know what Web Browser and Operating System you were using when this occurred. </p>
                     </div>
                  </div>
               </div>
            </div>
            <style> .error-404 a { color:#FFF; text-decoration:underline; } </style>
         </div>
         <!-- .page-content -->
      </section>
      <!-- .error-404 -->
   </main>
   <!-- #main -->
</div>
<!-- #primary -->
<?php get_footer(); ?>