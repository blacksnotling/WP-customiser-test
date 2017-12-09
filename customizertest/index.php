<?php get_header() ?>
<div id="container">

<div id="intro">
<h1><?php bloginfo( 'site_title' ) ?></h1>
<h2><?php bloginfo( 'description' ) ?></h2>
<?php if( get_theme_mod( 'cd_button_display', 'show' ) == 'show' ) : ?>
    <a href="" class='button'><?php echo get_theme_mod( 'cd_button_text', 'Come On In' ) ?></a>
<?php endif ?>
</div>

</div>
<?php get_footer() ?>
