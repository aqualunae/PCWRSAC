<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
    <![endif]-->
    <?php
        wp_head();

        $title = get_bloginfo("name");
        $tagline = get_bloginfo("description");
        $logo = get_site_icon_url();

        $attachment_title = 'PCWRSAC Logo_RGB Colour horiz';

        $attachments = get_posts([
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'title'          => $attachment_title,
            'posts_per_page' => 1,
        ]);

        if (!empty($attachments)) {
            $media_id = $attachments[0]->ID;
            $media_url = wp_get_attachment_image_src($media_id, 'large')[0];
        } else {
            $media_url = $logo;
        }

        $menu_display = [];
        $menu_items = wp_get_nav_menu_items("Header");
            foreach($menu_items as $item) {
                if ($item->menu_item_parent == "0") {
                    $menu_display[$item->ID]["title"] = $item->title;
                    $menu_display[$item->ID]["url"] = $item->url;
                } else {
                    $menu_display[$item->menu_item_parent]["children"][$item->ID]["title"] = $item->title;
                    $menu_display[$item->menu_item_parent]["children"][$item->ID]["url"] = $item->url;
                }
            }
    ?>
</head>
<body>
<header class="box-green flex-col">
    <div class="flex-row">
        <a id="logo-frame" href="/">
            <img id="logo" src="<?php echo $media_url; ?>" alt="Pictou County Women's Resource & Sexual Assault Centre" />
        </a>
    </div>
    <div id="header-menu-large">
        <div class="flex-row">
            <?php 
            foreach($menu_display as $d_item) {
                if (!$d_item["children"]) {
                    echo '<a class="nav-btn box-violet" href="'.$d_item["url"].'">'.$d_item["title"].'</a>';
                } else {
                    echo '<div class="dropdown nav-btn box-violet" tabindex="0"><div class="dropdown-header" tabindex="-1">'.$d_item["title"].' <span class="dropdown-arrow"></span></div>';
                    echo '<a href="'.$d_item["url"].'" class="dropdown-item box-violet" tabindex="-1">'.$d_item["title"].'</a>';
                    foreach($d_item["children"] as $child) {
                        echo '<a href="'.$child["url"].'" class="dropdown-item box-violet" tabindex="-1">'.$child["title"].'</a>';
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    <div class="flex-col" id="header-menu-mobile">
        <div class="dropdown nav-btn box-violet" tabindex="0"><div class="dropdown-header" tabindex="-1">Menu<span class="dropdown-arrow"></span></div>
        <?php 
            foreach($menu_display as $d_item) {
                if (!$d_item["children"]) {
                    echo '<a class="dropdown-item box-violet" href="'.$d_item["url"].'">'.$d_item["title"].'</a>';
                } else {
                    foreach($d_item["children"] as $child) {
                        echo '<a href="'.$child["url"].'" class="dropdown-item box-violet" tabindex="-1">'.$child["title"].'</a>';
                    }
                }
            }
            ?>
    </div>
</header>
