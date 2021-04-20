<template>

    <div class="bg-gray p-40 section-space" id="marcas">
		<section class="main-client container">
			<div class="title-general">
				<h1>{{ title }}</h1>
			</div>
			<VueSlickCarousel :slidesToShow="4" :dots="true" :slidesToScroll="4" :infinite="true" :responsive="responsive" v-if="products.length >0">
				<div class="main-destacdo_item" v-for="product in products" v-bind:key="product.asin">
                    <ProductCard :image="product.imgUrl" :price="product.price" :title="product.productDescription" :id="product.asin" :searchType="searchType"/>
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
                ],
                products:[],
                searchType:""
            }
        },
        methods:{

            async fetch(){

                let res = await this.$axios.get("recommendations?asin="+this.setWord()+"&searchType="+this.setSearchType())
                this.products = res.data.recommendations.searchProductDetails.slice(0, 10)

            },
            setWord(){

                let wordList = [
                    "Technology",
                    "cellphones",
                    "kitchen"
                ]

                let word = wordList[Math.floor(Math.random() * wordList.length)] 
                return word
            },
            setSearchType(){

                let searchList = [
                    "amazon",
                    "walmart"
                ]

                //let word = wordList[] 
                this.searchType = searchList[0]
                return searchList[0]
            }

        },
        created(){
            this.fetch()
        }
    }
</script>