<?php

$id = get_queried_object_id();
$category = get_category($id);

get_header();

$args = array(
    'category' => $category->term_id,
    'post_status' => 'publish',
    'order' => 'DESC',
    'orderby' => 'date',
    'numberposts' => -1
);

$posts = get_posts($args);

/**
 * Get all tags used by posts in a specific category.
 *
 * @param int|string $category_id Category ID, slug, or term object.
 * @return array Array of tag WP_Term objects.
 */
function get_tags_in_category( $category_id ) {
    // 1. Convert slug or object to ID if needed
    if ( is_string( $category_id ) && ! is_numeric( $category_id ) ) {
        $cat = get_term_by( 'slug', $category_id, 'category' );
        $category_id = $cat ? $cat->term_id : 0;
    } elseif ( is_object( $category_id ) ) {
        $category_id = $category_id->term_id;
    }

    if ( ! $category_id ) {
        return array();
    }

    // 2. Get all published post IDs in this category
    $post_ids = get_objects_in_term( $category_id, 'category' );

    if ( empty( $post_ids ) || is_wp_error( $post_ids ) ) {
        return array();
    }

    // 3. Get all unique tags assigned to these posts
    $tags = wp_get_object_terms( $post_ids, 'post_tag', array(
        'orderby' => 'name',
        'order'   => 'ASC',
    ) );

    if ( is_wp_error( $tags ) ) {
        return array();
    }

    return $tags;
}

/**
 * Filter an existing array of post objects by tag.
 *
 * @param array      $posts    Array of WP_Post objects or post IDs.
 * @param string|int $tag_slug Tag slug, ID, or name to filter by.
 * @return array               Filtered array of posts matching the tag.
 */
function filter_posts_by_tag( array $posts, $tag_slug ) {
    return array_values( array_filter( $posts, function( $post ) use ( $tag_slug ) {
        return has_tag( $tag_slug, $post );
    } ) );
}

$category_tags = get_tags_in_category($id);
usort( $category_tags, function( $a, $b ) {
    return strcasecmp( $b->name, $a->name );
} );

?>

<main class="background-green no-splash">

<div class="text-box box-violet">
    <h2 class="category-heading">
        <?php echo $category->name; ?>
    </h2>
    <p>
        <?php echo nl2br($category->description); ?>
    </p>
    <div class="flex-row">
    <?php foreach ( $category_tags as $tag ) { ?>
        <a class="tag-btn" href="#<?php echo $tag->slug; ?>"><?php echo $tag->name; ?></a>
    <?php } ?>
    </div>
</div>

<?php if ( ! empty( $category_tags ) ) {
    foreach ( $category_tags as $tag ) {
        $tag_posts = filter_posts_by_tag($posts, $tag); ?>
        <h3 class="text-box box-violet category-heading"><?php echo $tag->name; ?></h3>
        <div class="text-box box-white">
        <?php
        foreach ( $tag_posts as $post ) {
            $url = null;
            if (str_contains($post->post_content, "<a"))
            {
                $pattern = '/<a\s+[^>]*href=["\']([^"\']*)["\']/i';
                if (preg_match_all($pattern, $post->post_content, $matches)) {
                    $url = $matches[1][0];
                }
            }
            if ($url) { ?>
                <div class="post-details">
                        <h3><a href="<?php echo $url; ?>"><?php echo $post->post_title; ?></a></h3>
                    </div>
                    <hr />
            <?php } else { ?>
            <div class="post-details">
                <h3><?php echo $post->post_title; ?></h3>
                <p><?php echo $post->post_content; ?></p>
            </div>
            <hr />
        <?php } } ?>
        </div>
<?php }
} else {
foreach ( $posts as $post ) { 
    $thumbnail_html = get_the_post_thumbnail($post->ID); ?>
    <div class="text-box box-white category-post">
        <?php if ($thumbnail_html) { ?>
            <div class="featured-image">
                <?php echo $thumbnail_html; ?>
            </div>
        <?php } ?>
        <div class="post-details">
            <h3><?php echo $post->post_title; ?></h3>
            <p><?php echo $post->post_content; ?></p>
        </div>
    </div>
<?php } } ?>

</main>

<?php get_footer(); ?>