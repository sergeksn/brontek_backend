<?php
get_header();
elementor_theme_do_location( 'single' );
?>
<main id="content">

<?php 
the_content(); ?>

</main>
<?php get_footer();