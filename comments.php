<?php

$id = get_queried_object_id();
    $post = get_post($id);
    
    $args = array(
        'post_id' => $id,
        'status' => 'approve',
        'orderby' => 'comment_date',
        'order' => 'DESC',
        'number' => $comments_per_page,
        'offset' => $offset
    );
    
    $comments = get_comments($args);

if ( post_password_required($post) ) {
    return;
} 

?>

<div id="comments" class="comments-area">
<h2 class="comments-title">
    <?php echo 'Comments on ' . get_the_title(); ?>
</h2>

<?php if (count($comments) > 0) { ?>

<ul class="comment-list">

<?php

foreach($comments as $comment) { 

    $content = $comment->comment_content;
    $author = $comment->comment_author;
    $date = get_the_date('', $comment->comment_ID);
    $url = $comment->comment_author_url;
    if ($url) {
        $author = '<a href="' . $url . '">' . $author . '</a>';
    }
    
?>
    <div class="text-box comment">
        <p><?php echo $content; ?></p>
        <p class="details">Posted by <?php echo $author; ?> on <?php echo $date; ?></p>
    </div>
<?php } // foreach comment ?>
</ul><!-- .comment-list -->

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>

<nav class="navigation comment-navigation" role="navigation">

    <h3 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'twentythirteen' ); ?></h3>
    <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentythirteen' ) ); ?></div>
    <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentythirteen' ) ); ?></div>

</nav><!-- .comment-navigation -->

<?php } // Check for comment navigation ?>

<?php if ( ! comments_open() && get_comments_number() ) { ?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'twentythirteen' ); ?></p>
<?php } ?>

<?php } // count($comments) ?>

<?php comment_form(); ?>

</div><!-- #comments -->