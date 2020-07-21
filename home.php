<?php /*
Template Name: Главная
Template Post Type: post, page, product
*/
?>
<?php

///Получение товаров и формирование скрытых карточек с товарами для индексации
///Сформированные товары будут использованы для переключения на главной JS-ом

$args = ['status' => 'publish', 'limit' => -1 ];
$results = wc_get_products( $args );
$products_text='';
$categories_list = [];
$categories_top=[];
$categories_second=[];
$categories_third=[];


foreach ( $results as $product ) {
		$product_id = $product->get_id();
	$product_name = $product->get_title();	

	$category_top = [];
	$category_second = [];
	$category_third = [];
	$terms_ids = wp_get_post_terms( $product_id, 'product_cat', array('fields' => 'ids') );

	foreach( $terms_ids as $term_id ) {
	    $counter = 0;
	    foreach( get_ancestors( $term_id, 'product_cat' ) as $ancestor_id ){
	        if($counter == 0){
	        	$categories_second[$ancestor_id] = get_term( $ancestor_id, 'product_cat' )->name;
	        	$category_second["id"] = $ancestor_id;
	        	$category_second["name"] = get_term( $ancestor_id, 'product_cat' )->name;
	        }elseif($counter == 1){
	        	$category_top["id"] = $ancestor_id;
	        	$category_top["name"] = get_term( $ancestor_id, 'product_cat' )->name;
	        	$categories_top[$ancestor_id] = get_term( $ancestor_id, 'product_cat' )->name;
	        }
	        $counter ++;
	    }

	    // Add the product category term name to the category array
	    $categories_third[$term_id] = get_term( $term_id, 'product_cat' )->name;
	    $category_third["id"] = $term_id;
		$category_third["name"] = get_term( $term_id, 'product_cat' )->name;

		if ( $category_top["id"] && !isset( $categories_list[$category_top["id"]] )  ){
			$categories_list[$category_top["id"]] = [
				"id" => $category_top["id"],
				"name"=> $category_top["name"],
			];
			ksort( $categories_list );
		}

		if ( $category_second["id"] && !isset( $categories_list[$category_top["id"]]["child"][$category_second["id"]] ) ){
			$categories_list[$category_top["id"]]["child"][$category_second["id"]] = [
				"id" => $category_second["id"],
				"name"=> $category_second["name"],
			];
			ksort( $categories_list[$category_top["id"]]["child"] );
		}

		if ( $category_third["id"] && !isset( $categories_list[$category_top["id"]]["child"][$category_second["id"]]["child"][$category_third["id"]] ) ){
			$categories_list[$category_top["id"]]["child"][$category_second["id"]]["child"][$category_third["id"]] = [ 		
				"id" => $category_third["id"],
				"name"=> $category_third["name"],
			];
			ksort( $categories_list[$category_top["id"]]["child"][$category_second["id"]]["child"] );
		}
	}

    $product_galleries = [];
    $product_attachment_ids = $product->get_gallery_attachment_ids();

    foreach( $product_attachment_ids as $attachment_id ){
        $product_galleries[] = wp_get_attachment_image_src( $attachment_id, 'full' )[0];
    }

	if ( $product->get_type() == 'variable' ){
        $variations = $product->get_children( $args = '', $output = OBJECT ); 
        foreach ($variations as $variation) {
        	$product_variation = new WC_Product_Variation($variation);
			$product_variation_name =  wc_get_formatted_variation($product_variation, true, false, false);
			$product_variation_id = $product_variation->get_id();
			$product_variation_description = do_shortcode( $product_variation->get_description() );
			if ( empty( $product_variation_description ) ){
				$product_variation_description = do_shortcode( $product->get_description() );
			}
			$product_variation_slug = $product_variation->get_sku();
			$product_variation_slug = $product_variation_slug ? $product_variation_slug : $product_variation->get_slug();
			$product_variation_image_id = $product_variation->get_image_id();
			$product_variation_sale_price= $product_variation->get_sale_price();
			$product_variation_price= $product_variation->get_regular_price();
            $product_variation_price = $product_variation_price ? $product_variation_price : '0' ;
            $product_variation_is_in_stock = $product_variation->is_in_stock();
		$products_text .= '
		<div class="hidden product-list-item" style="display:none;" itemscope itemtype="http://schema.org/Product" 
			data-sku="' . $product_variation_slug . '" data-type="product-variation" >
			<meta itemprop="sku" content="' . $product_variation_id . '">
			<meta itemprop="name" content="' . esc_attr( $product_name ) . '" > ' .
			'<div class="description" itemprop="description" >
                ' . $product_variation_description . '
            </div>
            <link itemprop="url" href="' . esc_attr( home_url( '#' . $product_variation_slug )) . '">
			<link itemprop="image" href="' . wp_get_attachment_image_url( $product_variation_image_id, 'full' ) . '"/>
            <div class="product_galleries">' .
                (is_array($product_galleries) && count($product_galleries)>0 ?
                    '<div class="product-image-wr"><img class="product-image" src="' .  
                        implode('" alt="Product image"></div> ' . PHP_EOL . ' <div class="product-image-wr"><img class="product-image" src="', $product_galleries) .  
                    '" alt="Product image"></div>' :
                    ''
                ) .
            '</div>
			<meta itemprop="color" content="' . esc_attr( $product_variation_name ) . '"/>
			<span itemprop="offers" itemscope itemtype="http://schema.org/Offer"> 
				<span class="category" 
					data-cat1="' . $category_top["id"] . '" 
					data-cat2="' . $category_second["id"] . '" 
					data-cat3="' . $category_third["id"] . '" 
					itemprop="category">' . $category_top["name"] . '>' . $category_second["name"] . '>' . $category_third["name"] . '</span>
				<meta itemprop="priceCurrency" content="RUB"/>
				<meta itemprop="price" content="' . ($product_variation_sale_price ? $product_variation_sale_price : $product_variation_price) . '">
                <span class="full_price">' . ($product_variation_price) . '</span>
                <span class="sale_price">' . ($product_variation_sale_price) . '</span>
				<link itemprop="availability" href="http://schema.org/' . ( $product_variation_is_in_stock ? 'InStock' : 'OutOfStock' ) . '"/>
			</span> 
		</div>';
        }
	}else{ //simple
		$product_description = do_shortcode( $product->get_description() );
		$product_slug = $product->get_slug();
		$product_image_id = $product->get_image_id();
		$product_sale_price= $product->get_sale_price();
		$product_price= $product->get_regular_price();
        $product_price = $product_price ? $product_price : '0';
		$product_is_in_stock = $product->is_in_stock();  
		$products_text .= '
		<div class="hidden product-list-item" style="display:none;" itemscope itemtype="http://schema.org/Product"
            data-sku="' . $product_slug . '" data-type="product">
			<meta itemprop="sku" content="' . $product_id . '">
			<meta itemprop="name" content="' . esc_attr( $product_name ) . '" > ' .
            '<div class="description" itemprop="description" >
                ' . $product_description . '
            </div>
			<link itemprop="url" href="' . esc_attr( home_url( '#' . $product_slug )) . '">
			<link itemprop="image" href="' . wp_get_attachment_image_url( $product_image_id, 'full' ) . '"/>
            <div class="product_galleries">' .
                (is_array($product_galleries) && count($product_galleries)>0 ?
                    '<div class="product-image-wr"><img class="product-image" src="' .  
                        implode('" alt="Product image"></div> ' . PHP_EOL . ' <div class="product-image-wr"><img class="product-image" src="', $product_galleries) .  
                    '" alt="Product image"></div>' :
                    ''
                ) .
            '</div>                
			<span itemprop="offers" itemscope itemtype="http://schema.org/Offer"> 
			<span class="category" 
					data-cat1="' . $category_top["id"] . '" 
					data-cat2="' . $category_second["id"] . '" 
					data-cat3="' . $category_third["id"] . '" 
					itemprop="category">' . $category_top["name"] . '>' . $category_second["name"] . '>' . $category_third["name"] . '</span>
				<meta itemprop="priceCurrency" content="RUB"/>
				<meta itemprop="price" content="' . ($product_sale_price ? $product_sale_price : $product_price) . '">
                <span class="full_price">' . ($product_price) . '</span>
                <span class="sale_price">' . ($product_sale_price) . '</span>
				<link itemprop="availability" href="http://schema.org/' . ( $product_is_in_stock ? 'InStock' : 'OutOfStock' ) . ' "/>
			</span> 
		</div>';
    }
}
?>


<?php get_template_part('template-parts/head') ?>
<section class="sale-25">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="sale-25__wrap d-md-block d-sm-flex flex-column align-items-center">
        	    <?php $the_query = new WP_Query('p=83'); ?>
                	<?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                    <h1 class="sale-25__text">
                        <?php the_title(); ?>
                    </h1>
                    <ul>
                        <li>
                            1. <?php echo get_field('header_p1'); ?>
                        </li>
                        <li>
                            2. <?php echo get_field('header_p2'); ?>
                        </li>
                        <li>
                            3. <?php echo get_field('header_p3'); ?>
                        </li>
                    </ul>
                    <?php endwhile; ?>
                    <a href="#modal3" class="btn sale-25_btn open_modal3">Получить промокод</a>
                    <div class="d-flex sale__check-block">
                    	<input type="checkbox" checked>
                    	<p>Согласен на обработку персональных данных и принимаю условия соглашения</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="nav hidden align-items-center">
	<div class="nav__min-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-2 col-md-6">
                <i class="fas fa-bars menu__bar"></i>
                <ul class="nav_list d-md-flex">
                    <li><a href="#catalog" class="go">Каталог</a></li>
                    <li><a href="#brand" class="go">Преимущества</a></li>
                    <li><a href="#reviews" class="go">Отзывы</a></li>
                    <li><a href="#contacts" class="go">Контакты</a></li>
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
<section class="catalog" id="catalog">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="catalog__title">Каталог продукции Grand Line</p>
            </div>
            <div class="col-12">  
                <div class="shadow">    
                    <p class="catalog__menu-main">Наименование</p>
                     <ul class="catalog__tab-min">
                     	<?php 
                     		$first_category = 0;
                     		$counter = 0;
    	                 	foreach ($categories_list as $id => $category_ar) {
    							$active = "";
    							if ($counter == 0){
    								$active = "active";
    	                 			$first_category = $id;
    	                 		}
    	                 		$counter ++;
        	             		echo "<li class=\"$active\" data-categid=\"{$id}\">{$category_ar['name']}</li>";
            	         	}
                        ?>
                    </ul>
                    <p class="catalog__menu-level1">Вид</p>
                    <ul class="catalog__tab-level1">
    					<?php
    					$first_subcategory = 0;
    					$counter = 0; 
                     	if (isset($categories_list[$first_category]["child"]) && is_array($categories_list[$first_category]["child"])){
    	                 	foreach ($categories_list[$first_category]["child"] as $id => $category_ar) {
    	                 		$active = "";
    							if ($counter == 0){
    								$active = "active";
    								$first_subcategory = $id;
    							}
    							$counter ++;
        	             		echo "<li class=\"$active\" data-subcategid=\"{$id}\">{$category_ar['name']}</li>";
            	         	}
            	        }
                        ?>
                    </ul>
                    <p class="catalog__menu-level2">Название</p>
                    <ul class="catalog__tab-level2">
                    	<?php
    					$counter = 0; 
                        $first_subsubcategory = 0;
                     	if (isset($categories_list[$first_category]["child"][$first_subcategory]["child"]) && is_array($categories_list[$first_category]["child"][$first_subcategory]["child"])){
    	                 	foreach ($categories_list[$first_category]["child"][$first_subcategory]["child"] as $id => $category_ar) {
    						$active = "";
    						if ($counter == 0){
    							$active = "active";
                                $first_subsubcategory = $id;
    						}
    						$counter ++;
    						echo "<li class=\"$active\" data-subsubcategid=\"{$id}\">{$category_ar['name']}</li>";
            	         	}
            	        }
                        ?>
                    </ul>
                    <div class="catalog__offer">
                        <ul class="catalog__tab-level3">
                     	<?php 
                     		$counter = 0; 
    	                 	foreach ($categories_list as $id => $category_ar) {
                                $active = "";
                                if ($counter == 0){
                                    $active = "active";
                                }
                                $counter ++;
                                if (isset($category_ar['name'])){
                                	echo "<li  class=\"$active\" data-categid=\"{$id}\">{$category_ar['name']}</li>";
                                }
            	         	}
                        ?>
                        </ul>
                        <div class="catalog__calc d-flex">
                            <div class="calc__wiew-wrap d-flex justify-content-center">
                                <div class="calc__wiew d-flex flex-column align-items-center">
                                    <div class="calc__wiew-title">&nbsp;</div>
                                    <!-- <div class="garantee">гарантия 50 лет</div> -->
                                    
                                    <div class="catalog__color_image_wr">
                                        <div class="catalog__color_main_image">
                                            <img class="catalog__color-items d-block w-100" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" alt="Product image">
                                        </div>
                                    </div>
                                     <ul class="catalog__color d-flex">

                                    </ul>
                                    <div class="calc__wiew-price d-flex">
                                        <p class="sale_price">0<span>&nbsp;&#8381;</span></p>
                                        <p class="regular_price">0<span>&nbsp;&#8381;</span></p>
                                    </div>
                                    <a href="#modal4" id="need_to_order_btn" data-category="" data-product="" class="btn heared_btn calc__wiew_btn open_modal4">Заказать</a>
                                </div>
                            </div>
                            <div class="calc__info-wrap">
                                <div class="calc__info">
                                    <div class="calc__info-title" data-default="Покрытие">
                                        Покрытие
                                    </div>
                                    <div class="calc__info-color d-flex flex-wrap">

                                    </div>
                                    <div class="calc__info-prop ">
                                        <ul class="calc__info-prop-key d-flex flex-column align-items-start">

                                        </ul>
                                        <ul class="calc__info-prop-value d-flex flex-column align-items-start">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
<div style="display:none;" class="product-list">
<?php 
	echo $products_text;
?>
</div>
<script>
	<?php
		$js_array = json_encode($categories_list);
		echo "var avaliableCategories = ". $js_array . ";\n";
	?>
</script>
<section class="bonus-25" id="bonus-25">
    <div class="container">
        <div class="row">
            <div class="col">
            	<?php $the_query = new WP_Query('p=89'); ?>
                	<?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                <p class="bonus-25__text"><?php the_title(); ?> <span><?php echo get_field('bonus__min'); ?></span></p>
                <div class="bonus-25__wrap d-xl-flex">
                    <ul>
                        <li>
                            1. <?php echo get_field('bonus_p1'); ?>
                        </li>
                        <li>
                            2. <?php echo get_field('bonus_p2'); ?>
                        </li>
                        <li>
                            3. <?php echo get_field('bonus_p3'); ?>
                        </li>
                    </ul>
                    <div class="bonus-25__form-block">
	                    <form id="sms" action="<?php bloginfo('template_directory'); ?>/smsaero/smsaero.php" method="post" class="bonus-25__form d-flex align-items-center js-form">
	                        <input type="tel" class="tel" name="tel" placeholder="Ваш телефон">
	                        <a href="#" class="btn sale-25_btn bonus-25_btn" data-submit>Получить промокод</a>
	                    </form>
	                     <div class="d-flex sale__check-block">
	                    	<input type="checkbox" checked>
	                    	<p>Согласен на обработку персональных данных и принимаю условия соглашения</p>
	                    </div>
                	</div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>
<section class="brand" id="brand">
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
                    Качество всей продукции соответствует мировым стандартам, что подтверждается письменными
                    гарантийными обязательствами со стороны производителя. Система менеджмента качества компании
                    соответствует международным стандартам.
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<section class="question">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="question__wrap d-flex flex-column align-items-center">
                    <div class="question__text">
                        Сколько стоит?
                    </div>
                    <div class="question__text2">
                        Получите расчет кровли
                    </div>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSeWbIeYN3tHxjN-pONJp0gNWzol6ehWb5DUn93MYfunBbfFag/viewform?embedded=true" class="btn question_btn" target="_blank">Расчитай кровлю за 5 минут</a>
                    <div class="question__warning">
                        Неправильный расчет материалов приведет к большим переплатам и увеличению
                        сроков монтажа, доверьте это дело профессионалам
                    </div>
                   <!--  <div class="google__form">
                        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeWbIeYN3tHxjN-pONJp0gNWzol6ehWb5DUn93MYfunBbfFag/viewform?embedded=true" width="700" height="520" frameborder="0" marginheight="0" marginwidth="0">Загрузка…</iframe>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="statistics">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="statistics__wrap d-flex justify-content-around align-items-baseline">
                    <div class="statistics__info d-flex flex-column align-items-center">
                        <div class="statistics__info-wrap d-flex align-items-center">
                            <p class="statistics__count count">8</p>
                            <img src="<?php bloginfo('template_directory') ?>/img/factory.png" alt="">
                        </div>
                        <div class="statistics__info-text">
                            собственных заводов<br>в России
                        </div>
                    </div>
                    <div class="statistics__info d-flex flex-column align-items-center">
                        <div class="statistics__info-wrap d-flex align-items-center">
                            <p class="statistics__count count">3000</p>
                            <img src="<?php bloginfo('template_directory') ?>/img/admin.png" alt="">
                        </div>
                        <div class="statistics__info-text">
                            высококвалифицированных<br>сотрудников
                        </div>
                    </div>
                    <div class="statistics__info d-flex flex-column align-items-center">
                        <div class="statistics__info-wrap d-flex align-items-center">
                            <p class="statistics__count count">11</p>
                            <img src="<?php bloginfo('template_directory') ?>/img/depot.png" alt="">
                        </div>
                        <div class="statistics__info-text">
                            региональных складов
                        </div>
                    </div>
                    <div class="statistics__info d-flex flex-column align-items-center">
                        <div class="statistics__info-wrap d-flex align-items-center">
                            <p class="statistics__count count">10</p>
                            <img src="<?php bloginfo('template_directory') ?>/img/minecraft.png" alt="">
                        </div>
                        <div class="statistics__info-text">
                            миллионов. кв. м  в год<br>металлочерепицы
                        </div>
                    </div>
                    <div class="statistics__info d-flex flex-column align-items-center">
                        <div class="statistics__info-wrap ">
                            <img class="statistics__img_mod" src="<?php bloginfo('template_directory') ?>/img/lab.png" alt="">
                        </div>
                        <div class="statistics__info-text">
                            собственная лаборатория
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="statistics__wrap2 d-flex align-items-center">
                    <div class="statistic__wrap2-content d-flex align-items-center ml-md-auto">
                        <div class="statistics__questions">
                            Хотите узнать больше?
                        </div>
                        <a href="#modal" class="btn heared_btn nav_btn statistics__btn open_modal">Заказать звонок</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="reviews" id="reviews">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="reviews__title">Отзывы</p>
                <ul class="reviews__slider-block">
                    <?php $the_query = new WP_Query('cat=19'); ?>
                    <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                    <li class="reviews__slider-items d-flex">
                        <div class="reviews__name-block">
                            <p><?php the_title(); ?></p>
                            <p><?php echo get_field('date'); ?></p>
                        </div>
                        <div class="reviews__slider-text">
                             <?php the_content(); ?>
                        </div>
                    </li>
                    <?php endwhile; ?>
                </ul>
                <a href="#modal2" class="btn reviews__btn open_modal2">Написать отзыв</a>
            </div>
        </div>
    </div>
</section>
<section class="checklist" id="checklist">
    <div class="container">
        <div class="row">
        		<?php $the_query = new WP_Query('p=812'); ?>
                <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
            <div class="col-12">
                <p class="checklist__title-big"><?php the_title(); ?></p>
                <p class="checklist__title-min">для проверки качества монтажа</p>
            </div>
            <div class="col-md-7">
                <p class="checklist__text">
                     <?php the_content(); ?>
                </p>
            	<?php endwhile; ?>
                <?php echo do_shortcode( '[contact-form-7 id="5" title="Форма контрольный лист"]' ); ?>
            </div>
            <div class="col-md-5">
                <img src="<?php bloginfo('template_directory') ?>/img/pdf-plus-word.png" alt="pdf plus word" class="checklist__img">
                <p class="checklist__bonus">Бонус</p>
                <p class="checklist__bonus-text">
                    Договор на монтажные работы,<br> адаптированный под заводские настройки
                </p>
            </div>

        </div>
    </div>
</section>
<section class="gallery">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="gallery__title">Фотогалерея</p>
                <ul class="gallery__catalog d-sm-flex">
                    <li>
                        <a data-slider_class='gallery__all'>Все</a>
                    </li>
                    <li>
                        <a data-slider_class='gallery__siding'>Сайдинг</a>
                    </li>
                    <li>
                        <a data-slider_class='gallery__roof'>Кровля</a>
                    </li>
                    <li>
                        <a data-slider_class='gallery__drain'>Водостоки</a>
                    </li>
                    <li>
                        <a data-slider_class='gallery__panels'>Фасадные панели</a>
                    </li>
                </ul>
                <div class="gallery__slider gallery__all"> 
                    <?php 
                    echo do_shortcode('[slick-carousel-slider 
                        category="20" design="design-6" slidestoshow="2" image_fit="false" image_size="large"]');
                    ?>
                </div>
                <div class="gallery__slider gallery__siding"> 
                    <?php 
                    echo do_shortcode('[slick-carousel-slider category="21" design="design-6" slidestoshow="2" image_fit="true" image_size="large"]');
                    ?>
                </div>
                <div class="gallery__slider gallery__roof"> 
                    <?php 
                    echo do_shortcode('[slick-carousel-slider category="22" design="design-6" slidestoshow="2" image_fit="true" image_size="large"]');
                    ?>
                </div>
                <div class="gallery__slider gallery__drain">
                    <?php 
                    echo do_shortcode('[slick-carousel-slider category="23" design="design-6" slidestoshow="2" image_fit="true" image_size="large"]');
                    ?>
                </div>
                <div class="gallery__slider gallery__panels">
                    <?php 
                    echo do_shortcode('[slick-carousel-slider category="24" design="design-6" slidestoshow="2" image_fit="true" image_size="large"]');
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="photo-catalog">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-7">
            	<?php $the_query = new WP_Query('p=816'); ?>
                <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                <p class="photo-catalog__title"><?php the_title(); ?></p>
                <p class="photo-catalog__text">
                     <?php the_content(); ?>
                </p>
                <?php endwhile; ?>
                <?php echo do_shortcode( '[contact-form-7 id="46" title="Форма фоткаталог"]' ); ?>
            </div>
            <div class="col-md-4 col-lg-5">
                <img src="<?php bloginfo('template_directory') ?>/img/catalog.png" alt="catalog" class="photo-catalog__img">
            </div>
        </div>
    </div>
</section>
<section class="contacts" id="contacts">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-7">
            	<?php $the_query = new WP_Query('p=823'); ?>
                <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                <p class="contacts__title"><?php the_title(); ?></p>
                <ul class="contacts__list">
                    <li>
                        <div class="contacts__list-title">
                            <i class="fas fa-phone-alt"></i>
                            <span>Телефон</span>
                        </div>
                        <a href="tel:88005506465" class="contact__tel">
                        	<?php echo get_field('contact-tel'); ?></a>
                    </li>
                    <li>
                        <div class="contacts__list-title">
                            <i class="fas fa-envelope"></i>
                            <span>E-mail</span>
                        </div>
                        <a href="mailto:info@y-stroika.ru">
                        	<?php echo get_field('e-mail'); ?></a>
                    </li>
                    <li>
                        <div class="contacts__list-title">
                            <i class="fab fa-viber"></i>
                            <span>Viber</span>
                        </div>
                        <a href="viber://add?number=+79858084455"> 
                            <?php echo get_field('viber'); ?>
                        </a>
                    </li>
                    <li>
                        <div class="contacts__list-title">
                            <i class="fab fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </div>
                        <a href="https://api.whatsapp.com//send?phone=79858084455" target="_blank">
                        	<?php echo get_field('whats-app'); ?>
                    	</a>
                    </li>
                    <li>
                        <div class="contacts__list-title">
                            <i class="far fa-clock"></i>
                            <span>Часы работы</span>
                        </div>
                        <div>
                            <p><?php echo get_field('time-work1'); ?></p>
                            <p><?php echo get_field('time-work2'); ?></p>
                        </div>
                    </li>
                    <li>
                        <div class="contacts__list-title">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Адрес</span>
                        </div>
                        <p><?php echo get_field('adress-work'); ?></p>
                    </li>
                </ul>
                <?php endwhile; ?>
            </div>  
            <div class="col-lg-6 col-md-5">
            	<?php $the_query = new WP_Query('p=818'); ?>
                <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                <p class="contacts__title-right"><?php the_title(); ?></p>
                <p class="contacts__text-right"><?php the_content(); ?></p>
                <?php endwhile; ?>
                <?php echo do_shortcode( '[contact-form-7 id="47" title="Форма льготная доставка"]' ); ?>
            </div>  
        </div>
    </div>
</section>


<?php get_template_part('template-parts/footer') ?>
