<?php get_header() ?>
<div id="container">

<div id="intro">
<h1><?php bloginfo( 'site_title' ) ?></h1>
<h2><?php bloginfo( 'description' ) ?></h2>
  <div id='button-container'>
    <?php cd_show_main_button() ?>
  </div>
  <div id='photocount'>
    <span><?php echo get_theme_mod( 'cd_photocount', 0 ) ?></span> photos
  </div>
</div>

</div>
<?php get_footer() ?>
