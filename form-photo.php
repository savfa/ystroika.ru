<?php /*
Template Name: Form-photo
Template Post Type: post, page, product
*/
?>
<?php get_template_part('template-parts/head') ?>
<section class="nav nav2 align-items-center">
    <div class="nav__min-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-2 col-md-6">
                <i class="fas fa-bars menu__bar"></i>
                <ul class="nav_list d-md-flex">
                    <li><a href="/#catalog" class="go">Каталог</a></li>
                    <li><a href="/#brand" class="go">Преимущества</a></li>
                    <li><a href="/#reviews" class="go">Отзывы</a></li>
                    <li><a href="/#contacts" class="go">Контакты</a></li>
                </ul>
            </div>
            <div class="col-10 col-md-6">
                <div class="phone d-flex justify-content-between">
                    <div class="phone__number d-flex align-items-center ml-auto">
                        <i class="fas fa-phone"></i>
                        <a href="tel:88005506465" class="phone__number-text">8 800 550 64 65</a>
                    </div>
                    <a href="#modal" class="btn heared_btn nav_btn open_modal">Заказать звонок</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- Форма фотокаталог -->
<section class="sms">
     <div class="container">
        <div class="row">
            <div class="col-12">
               <?php while( have_posts() ) : the_post();
                        $more = 1; ?>    
                        <p class="sms__title"><?php the_title(); ?></p>
                        <p class="sms__block">
                    <?php the_content(); ?> 
                </p>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>
<!-- конец форма фотокаталог -->
<section class="brand" id="">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php $the_query = new WP_Query('p=48'); ?>
                <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="brand__text"><?php the_title(); ?></div>
            </div>
            <div class="col-md-2 offset-md-1">
                <div class="brand__wrap" data-rectangle="163">
                    <img src="<?php bloginfo('template_directory') ?>/img/open-delivered-box.png" alt="">
                    <div class="brand__item-text" data-text="<?php echo get_field('text-1'); ?>"><?php echo get_field('title-1'); ?></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="brand__wrap" data-rectangle="353">
                    <img src="<?php bloginfo('template_directory') ?>/img/automation.png" alt="">
                    <div class="brand__item-text" data-text="<?php echo get_field('text-2'); ?>"><?php echo get_field('title-2'); ?></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="brand__wrap" data-rectangle="543">
                    <img src="<?php bloginfo('template_directory') ?>/img/schedule.png" alt="">
                    <div class="brand__item-text" data-text="<?php echo get_field('text-3'); ?>"><?php echo get_field('title-3'); ?></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="brand__wrap" data-rectangle="733">
                    <img src="<?php bloginfo('template_directory') ?>/img/guarantee.png" alt="">
                    <div class="brand__item-text" data-text="<?php echo get_field('text-4'); ?>"><?php echo get_field('title-4'); ?></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="brand__wrap" data-rectangle="923">
                    <img src="<?php bloginfo('template_directory') ?>/img/site-quality.png" alt="">
                    <div class="brand__item-text" data-text="<?php echo get_field('text-5'); ?>"><?php echo get_field('title-5'); ?></div>
                </div>
            </div>
            <div class="col-md-12 d-none d-md-block">
                <div class="brand__slide">
                    <div class="rectangle"></div>
                </div>
            </div>
            <div class="col-md-12 d-none d-md-block">
                <div class="brand__info">
                   <?php echo get_field('text-1'); ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php get_template_part('template-parts/footer') ?>