<?php wp_footer(); ?>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer__block d-flex">
                    <a href="/"><img src="<?php bloginfo('template_directory') ?>/img/logo_footer.png" alt="logo" class="footer__img"></a>
                    <p class="footer__text">
                        Grand Line — одна из немногих компаний на европейском и российском рынке, производящая как металлические профилированные изделия, так и изделия из ПВХ. Высокое качество выпускаемой продукции — один из приоритетов компании. Новейшие разработки и материалы, используемые при создании всех товаров, постоянный контроль качества сырья и готовых изделий в собственной лаборатории качества позволяет предоставлять клиентам письменную гарантию до 50 лет.
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>


<div class="modal" id="modal1">
            <span class="close" id="close1"></span>
<?php echo do_shortcode( '[contact-form-7 id="5" title="Контактная форма 1"]' ); ?>

</div>




 <div id="overlay"></div>

<!-- jquery -->
<script src="<?php bloginfo('template_directory') ?>/js/jquery-3.4.1.min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/js/jquery.maskedinput.min.js"></script>
<!-- bootstrap -->
<script src="<?php bloginfo('template_directory') ?>/js/bootstrap.min.js"></script>
<!-- slick -->
<script src="<?php bloginfo('template_directory') ?>/js/slick.min.js"></script>
<!-- main.js -->
<script src="<?php bloginfo('template_directory') ?>/js/main.js"></script>
</body>
</html>
