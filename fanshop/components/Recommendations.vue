<template>
    <div class="relacionados mt-5 pt-5">
        <div class='container'>
            <div class='title-general text-center mb-4'>
                <h1>Productos relacionados </h1>
            </div>
            <div class="row">
                
                <div class="col-md-3" v-for="product in products" v-bind:key="product.id">
                    <!--<ProductCard @click="fetch(product.asin, searchType)" :image="product.imgUrl" :price="product.price" :title="product.productDescription" :id="product.asin" :searchType="searchType"   />-->

                    <a class="card-producto" @click="fetch(product.asin)">
                        <div class="card-content">
                            <div class="card-producto-img">	
                                <p class="btn-custom" >Ver producto</p>
                                <img :src="product.imgUrl" class="card-content-img" alt="">
                            </div>
                            <div class="card-producto-content">
                                <h4 class="title-producto">{{ product.productDescription.substring(0, 40) }}</h4>
                                <span v-if="searchType == 'amazon'" class="price">S/ {{ ((product.price + (product.price * parseFloat(earnPercentage)))*parseFloat(dolarPrice)).toFixed(2) }}</span>
                            </div>
                        </div>
                    </a>

                </div>
                
            </div>

            <!-- <div class='cta-producto'>
                <a class='btn btn-primary btn-shadow' href='#'>Más productos</a>
            </div> -->
        </div>
    </div>
</template>

<script>

    import ProductCard from "../components/ProductCard";

    export default {
        name:"Recommendations",
        components:{ProductCard},
        props:{
            "asin":String,
            "searchType":String,
            "fetch":Function,
            "productCategory":String,
            "dolarPrice":String,
            "earnPercentage":String
        },
        data(){
            return{
                "products":[]
            }
        },
        methods:{

            async getRecomendations(){
                let res = await this.$axios.get("recommendations?asin="+this.productCategory+"&searchType="+this.searchType)
                this.products = res.data.recommendations.searchProductDetails.filter(recommendations => {  return recommendations.price > 0 })
                this.products = this.products.slice(0, 4)
            }

        },
        created(){

            this.getRecomendations()

        }
    }
</script>