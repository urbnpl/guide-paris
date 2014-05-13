<?php

/*
Template Name: page-single
*/

// Simple home page template that doesn't need a loop for content
// Gets content from advanced custom fields plugin, there's an example of how to grab a field below

?>

<?php get_header(); ?>

<body <?php body_class(); ?>>
	<div class="content-main clear-fix" role="main">	
	<!--SITE HEADER ~ for SEO ~ hidden with CSS-->
	<header class="site-header parallax" id="intro" role="banner">
	<div class="header-wrap">
	<div class="header-inner">
		<div class="logo"><img src="<?php bloginfo('template_url'); ?>/images/logo.png"></div><h1 class="site-title"><?php bloginfo( 'name' ); ?></h1><h2 class="site-description"><?php echo str_replace('-','<br />',get_bloginfo('description')); ?></h2>
	</div></div>
        
	</header>

	<!--MAIN NAV: Activate the menu system by going into wpadmin / appearance / menus / and adding a menu named mainNav-->
	<!--To make the menu vertical instead of horizontal remove the menu_class of horiz-list-->
	<nav class="nav-menu" id="navigation" role="navigation">
		<?php wp_nav_menu(array('menu' => 'mainNav', 'menu_class' => 'horiz-list')); // create the mainNav menu inside Appearance menus and go to town -- for more on menus see: http://templatic.com/news/wordpress-3-0-menu-management ?>
	</nav>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<!--BEGIN: Sections-->
	<?php
        $args = array(
            'post_type' => 'parallax',
            'order'     => 'ASC',
            'orderby' => 'none/ID/author/title/name/date/modified/parent/rand/comment_count/menu_order/meta_value/meta_value_num/post__in'
        );
        $parallax = new WP_Query($args);
            while($parallax->have_posts()) : $parallax->the_post();
                 
                $parallaxImage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
                $breakUrl = str_replace(home_url(), '', $parallaxImage[0]); ?>
                <section class="parallax" id="section_<?php echo the_ID(); ?>" style="background-image: url('.<?php echo $breakUrl; ?>') ;">
                
                <article class="story">
                    <h2 class="section-title"><?php the_title(); ?></h2>
                    <div class="page-content">
                        <?php the_content(); ?>
						</div>
                </article></section>
 
            <?php endwhile;
        wp_reset_postdata();
?>	
	<!--END: Sections-->

<?php endwhile; ?>


	
<?php endif; //END: The Loop ?>
<!--END: Content-->
<?php get_footer(); ?></div>