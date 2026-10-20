<?php
    get_header();
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_post_thumbnail();
            the_title();
            the_author();
            the_content();
        endwhile;
    else :
        _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
    endif;
    get_footer();