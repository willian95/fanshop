<template> 
    <div>

        <VueSlickCarousel :arrows="false" :dots="false" class="">

            <div>
                <img class="img-responsive" src="/img/banner.png" />
                <!--<div class="mask-item">
                    <div class="banner-info">
                        <h1 class="title-banner wow animated fadeInUp" data-wow-delay=".2s"
                            data-wow-duration="1500ms">
                            Oferta de la semana
                        </h1>
                        <p class="wow animated fadeInUp" data-wow-delay=".9s" data-wow-duration="1500ms">
                            Subtitulo
                        </p>
                    </div>
                </div>-->
            </div>

        </VueSlickCarousel>

        <AboutUs />

        <HighlightedProducts :title="'Productos destacados'" />

        <Advertisement />

        <!--<Offers />-->

        <HighlightedProducts :title="'Popular en la tienda'" />

    </div>


</template>

<script>

    import VueSlickCarousel from 'vue-slick-carousel'
    import 'vue-slick-carousel/dist/vue-slick-carousel.css'
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

    import AboutUs from '../components/home/AboutUs'
    import HighlightedProducts from '../components/home/HighlightedProducts';
    import Advertisement from '../components/home/Advertisement'
    import Offers from '../components/home/Offers'

    export default {
        components: { VueSlickCarousel, AboutUs, HighlightedProducts, Advertisement, Offers },
    }
</script>

<style>
    .img-responsive{
        width: 100%;
    }
</style>
