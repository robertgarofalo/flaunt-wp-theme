<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
	
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'flaunt' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="navbar-container">
            <nav class="navbar">
                <i id="menu-button" class="fa-solid fa-bars"></i>
                <?php //the_title() ?>
            </nav>

            <div class="logo-title">
                <!-- Logo -->
                <?php 
                    // Get logo SRC
                    if ( function_exists( 'the_custom_logo' ) ) {
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src( $custom_logo_id );
                    }
                        // Logo exists?
                    if ( has_custom_logo()) :
                            ?>
                        <img src="<?php echo $logo[0]?>" >
                        <?php
                    else :
                        ?>
                        <!-- No node -->
                        <?php
                    endif;
                    ?>

                <!-- Site Title -->
               <div></div>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>                
            </div> <!-- .logo-title -->
            
            <div id="flaunt-navbar-social">
                <?php dynamic_sidebar( 'navbar-social' ); ?>
            </div>
		</div><!-- .site-branding -->

        <nav id="flaunt-sidebar">
           <!-- Avatar -->
        <?php echo_sidebar_avatar() ?>
            <!--Side navbar menu  -->
            <?php 
					wp_nav_menu(
						array(
							'menu' => 'primary',
                            'menu_class' => 'flaunt-sidebar-menu',
							'container' => '',
							'theme_location' => 'primary',
							// 'items_wrap' => '<ul id="" class="navbar-nav flex-column text-sm-center text-md-left">%3$s</ul>'
						)
					);

				?>
        </nav>

	</header><!-- #masthead -->
