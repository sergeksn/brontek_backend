<?php get_header();?>

<main id="content">

<?php // Elementor `single` location
elementor_theme_do_location( 'single' );
?>
<?php 
the_content(); ?>
</main>
<?php get_footer();