<?php

// needs update

get_header();

$id = get_queried_object_id();
$post = get_post($id);
$title = $post->post_title;
$content = $post->post_content;
$tags = get_the_tags($id);
$category = get_the_category($post->ID)[0];
$author = get_the_author_meta('display_name', $post->post_author);
$date = get_the_date('', $id);
$excerpt = get_the_excerpt($id);

?>

<main class="background-green">
<div class="text-box box-violet">
    <h2><?php echo $title; ?></h2>
    <p>Posted by <?php echo $author; ?> under <a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->cat_name; ?></a> on <?php echo $date; ?>.</p>
    <hr />
        <?php the_content(); ?>
    <hr />
    <h3>Tags</h3>
    <div id="tag-box" class="flex-row">
        <?php foreach ($tags as $tag) { ?>
            <a class="tag" href="/?tag=<?php echo $tag->name; ?>">
                <?php echo ucfirst($tag->name); ?>
            </a>
        <?php } ?>
    </div>
</div>

<?php 

if ( comments_open() || get_comments_number() ) {
    comments_template();
}

?>

</main>

<?php get_footer(); ?>