<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
    <?php if (is_post_type_archive('tour') || is_singular('tour') || is_tax('tour_category')) : ?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/pages.css">
    <?php endif; ?>
    <?php if (is_singular('tour')) : ?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/tour-detail.css">
    <?php endif; ?>
    <?php if (is_home() || is_archive() || is_singular('post')) : ?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/pages.css">
    <?php endif; ?>
    <?php if (is_singular('post')) : ?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/blog-detail.css">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Header -->
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/logo.png" alt="' . get_bloginfo('name') . '">';
                    }
                    ?>
                    <span><span style="color: black;">Safwa</span><span style="color: red;">Turizm</span></span>
                </a>
            </div>
            
            <nav class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => '',
                    'fallback_cb' => 'safwa_default_menu'
                ));
                ?>
            </nav>
            
            <div class="header-actions">
                <button class="menu-btn"><i class="fas fa-bars"></i></button>
            </div>
        </div>
    </div>
</header>
