<footer>
    <div class="foot-menu box-violet">
        <?php $menu_items = wp_get_nav_menu_items("Footer");
        foreach($menu_items as $item) { ?>
        <h3>
            <a href="<?php echo $item->url; ?>">
                <?php echo $item->title; ?>
            </a>
        </h3>
        <?php } ?>
    </div>
    <p class="foot-text box-green">
        Copyright © 2026 Pictou County Women's Resource and Sexual Assault Centre
    </p>
</footer>
<?php wp_footer(); ?>