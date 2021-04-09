<template>

    <div class="bg-gray p-40 section-space" id="marcas">
		<section class="main-client container">
			<div class="title-general">
				<h1>{{ title }}</h1>
			</div>
			<VueSlickCarousel :slidesToShow="4" :dots="true" :slidesToScroll="4" :infinite="true" :responsive="responsive">
				<div class="main-destacdo_item">
                    <ProductCard />
				</div>

                <div class="main-destacdo_item">
                    <ProductCard />
				</div>

                <div class="main-destacdo_item">
                    <ProductCard />
				</div>

                <div class="main-destacdo_item">
                    <ProductCard />
				</div>

                <div class="main-destacdo_item">
                    <ProductCard />
				</div>

                <div class="main-destacdo_item">
                    <ProductCard />
				</div>

                <div class="main-destacdo_item">
                    <ProductCard />
				</div>

                <div class="main-destacdo_item">
                    <ProductCard />
				</div>


			</VueSlickCarousel>
		</section>
	</div>

</template>

<script>

    import VueSlickCarousel from 'vue-slick-carousel'
    import 'vue-slick-carousel/dist/vue-slick-carousel.css'
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

    import ProductCard from '../ProductCard'

    export default {
        name:"HighlightedProducts",
        components:{VueSlickCarousel, ProductCard},
        props:["title"],
        data(){
            return{
                responsive:[
                    {
                    "breakpoint": 1024,
                        "settings": {
                            "slidesToShow": 4,
                            "slidesToScroll": 4,
                            "infinite": true,
                            "dots": true
                        }
                    },
                    {
                    "breakpoint": 600,
                        "settings": {
                            "slidesToShow": 2,
                            "slidesToScroll": 2,
                            "initialSlide": 2
                        }
                    },
                    {
                    "breakpoint": 480,
                        "settings": {
                            "slidesToShow": 1,
                            "slidesToScroll": 1
                        }
                    }
                ]
            }
        }
    }
</script>