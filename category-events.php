<?php

$id = get_queried_object_id();
$category = get_category($id);

get_header();

$args = array(
    'category' => $id,
    'post_status' => 'publish',
    'order' => 'ASC',
    'orderby' => 'date',
    'numberposts' => -1
);

$posts = get_posts($args);

$first_year = get_the_date( 'Y', $posts[0]->ID );
$last_year = get_the_date( 'Y', $posts[array_key_last($posts)]->ID );

function filter_posts_by_year($posts, $year) {
    return array_values( array_filter( $posts, function( $post ) use ( $year ) {
        return get_the_date( 'Y', $post->ID ) == $year;
    } ) );
}

?>

<main class="background-green no-splash">

<div class="text-box box-violet">
    <h2 class="category-heading">
        <?php echo $category->name; ?>
    </h2>
    <p>
        <?php echo $category->description; ?>
    </p>
</div>

<?php

for ($year = $last_year; $year >= $first_year; $year--)
{ 
    $year_posts = filter_posts_by_year($posts, $year);
    if ( ! empty( $year_posts ) ) { ?>
    <h3 class="text-box box-violet category-heading"><?php echo $year; ?></h3>
    <?php foreach ($year_posts as $post) { ?>
        <div class="text-box box-white category-post">
            <?php if ($thumbnail_html) { ?>
                <div class="featured-image">
                    <?php echo $thumbnail_html; ?>
                </div>
            <?php } ?>
            <div class="post-details">
                <h3><?php echo $post->post_title; ?></h3>
                <p><?php the_content($post); ?></p>
            </div>
        </div>
    <?php } } } ?>

</main>

<?php get_footer(); ?>