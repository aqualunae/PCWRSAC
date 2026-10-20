<?php get_header(); ?>

<main class="background-violet">
    <?php 
        the_post_thumbnail( 'large' );
        the_content(); 
    ?>
</main>

<?php get_footer(); ?>