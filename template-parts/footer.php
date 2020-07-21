<?php wp_footer(); ?>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer__block d-flex">
                    <a href="/"><img src="<?php bloginfo('template_directory') ?>/img/logo_footer.png" alt="logo" class="footer__img"></a>
                    <?php $the_query = new WP_Query('p=820'); ?>
                <?php while  ($the_query->have_posts() ) : $the_query->the_post(); ?>
                    <div class="footer__text">
                        <?php the_content(); ?>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</footer>


<div class="modal modal1" id="modal">
    <div class="bell__block">
            <span class="close close1"></span>
            <p class="bell__title">Закажите звонок</p>
            <?php echo do_shortcode( '[contact-form-7 id="63" title="Форма заказать звонок"]' ); ?>
    </div>
</div>
<div class="modal modal2" id="modal2">
    <div class="bell__block">
            <span class="close close2"></span>
            <p class="bell__title">Ваш отзыв</p>
            <?php echo do_shortcode( '[contact-form-7 id="71" title="Форма отзыва"]' ); ?>
    </div>
</div>
<div class="modal modal3" id="modal3">
    <div class="bell__block">
            <span class="close close1" id="close2"></span>
            <p class="bell__title">Получи бонус 25%</p>
            <form id="sms" action="<?php bloginfo('template_directory'); ?>/smsaero/smsaero.php" method="post" class="bonus-25__form d-flex flex-column align-items-center js-form">
                <input type="tel" class="tel" name="tel" placeholder="Ваш телефон">
                <a href="#" class="btn sale-25_btn bonus-25_btn" data-submit>Получить промокод</a>
            </form>
            <!-- <p class="bell__title bell__title2">Спасибо заобращение внашу компанию,<br>
                Вы получили смс сообщение с промокодом, он дает вам бонус на доборные элементы 25% и действует 10 дней.<br>В ближайшее время наш менеджер свяжется с Вами и расскажет как им воспользоваться.
            </p> -->
    </div>
</div>
 <div class="modal modal4" id="modal4">
    <div class="bell__block">
            <span class="close close4"></span>
           <!--  <p class="bell__title">Оставьте свои контактные данные 
                    и наш менеджер свяжется с Вами Коллекция:</p> -->
            <?php echo do_shortcode( '[contact-form-7 id="585" title="Форма заказать товар"]' ); ?>
    </div>
</div>




 <div id="overlay"></div>

<!-- jquery -->
<script src="<?php bloginfo('template_directory') ?>/js/jquery-3.4.1.min.js"></script>
<!-- maskedinput -->
<script src="<?php bloginfo('template_directory') ?>/js/jquery.maskedinput.min.js"></script>
<!-- bootstrap -->
<script src="<?php bloginfo('template_directory') ?>/js/bootstrap.min.js"></script>
<!-- validate -->
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.17.0/jquery.validate.min.js"></script>
<!-- slick -->
<script src="<?php bloginfo('template_directory') ?>/js/slick.min.js"></script>
<!-- main.js -->
<script src="<?php bloginfo('template_directory') ?>/js/main.js"></script>
<!-- envycrm -->
<link rel="stylesheet" href="https://cdn.envybox.io/widget/cbk.css">
<script type="text/javascript" src="https://cdn.envybox.io/widget/cbk.js?wcb_code=a65501cd47d46a70d3bc5313f0e1bf74" charset="UTF-8" async></script>
</body>
</html>
