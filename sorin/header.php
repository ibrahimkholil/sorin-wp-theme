<?php
/**
 * The header file
 * @package WordPress
 * @subpackage Sorin
 * @since 1.0
 * @version 1.0
 */
global $themeOptions;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php

if($themeOptions->sorinPreloder === '1'):
 echo do_shortcode('[sorinpreloader]');
 endif;?>
<header class="sr-header">
		<div class="sr-header-top sr-secondary-bg">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-8">
						<div class="row">
							<div class="col-auto">
                                <?php if(!empty($themeOptions->headerNumber)):?>
								<div class="sr-phone text-white font-weight-light">
									<i class="fa fa-phone mr-2"></i>
									<span class="sr-mobile-font"><?php echo esc_attr($themeOptions->headerNumber);?></span>
								</div>
                                <?php endif;?>
							</div>
							<div class="col-auto">
                                <?php if(!empty($themeOptions->headerEmail)):?>
								<div class="sr-email text-white font-weight-light">
									<i class="fa fa-envelope mr-2"></i>
									<span class="sr-mobile-font"><?php echo esc_attr($themeOptions->headerEmail);?></span>
								</div>
                                <?php endif;?>
							</div>
						</div>
					</div>
                    <?php
                    if($themeOptions->headerBtnOff === '1'):?>
					 <div class="col-4">
						<div class="sr-get-quote-btn sr-primary-bg sr-primary-hover-bg float-right">
							<a target="_blank" class="text-white py-2 px-3 py-md-3 px-md-4 d-block text-center" href="<?php if(!empty($themeOptions->headerBtnUrl)):  echo esc_attr($themeOptions->headerBtnUrl); endif;?>">
                                <?php
                                    if(!empty($themeOptions->headerBtnText)):
                                          echo esc_attr($themeOptions->headerBtnText);
                                    endif;
                                ?>
                            </a>

						</div>
					</div>
                    <?php endif;?>
				</div>
			</div>
		</div>
		<div class="sr-header-main">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-3">
						<div class="sr-logo">
                             <?php
                             if(!empty($themeOptions->siteLogo['url'])){
                             ?>
                                 <a href="<?php echo esc_url( home_url() ); ?>">
                                <img src="<?php echo(esc_url($themeOptions->siteLogo['url'])) ;?>" alt="" class="img-fluid">
                                 </a>
                             <?php  }
                             else{?>
                                <img src="<?php echo get_template_directory_uri();?>/assets/img/logo.png" alt="" class="img-fluid">
                             <?php } ?>
						</div>
					</div>
					<div class="col-9 d-flex justify-content-end">
						<div class="sr-menu">

                                <?php
                                if ( has_nav_menu( 'primary' ) ) :
                                    wp_nav_menu( array(
                                        'menu'              => 'Primary Nav',
                                        'container'       => false,
                                        'theme_location'    => 'primary',
                                        'menu_class'        => 'sr-menu-items list-unstyled list-inline-items mb-0'
                                    ));
                                endif;
                                ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
<?php
    //header banner
    if ( ! is_front_page() ) :
    get_template_part( 'template-parts/banner' );
    endif;
?>


