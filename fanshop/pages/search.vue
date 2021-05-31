<template>
    <section class="producto mt-50" id="productos">
		<div class="container">
			<div class="title-general">
				<h1>Ofertas</h1>
			</div>
        </div>
        <loading :loading="loading" />
      <div class="container">
            <div class="row">
            <div class="col-md-3 mt-4" v-for="product in products" v-bind:key="product.id">
                <ProductCard :image="product.imgUrl" :price="product.price" :dolarPrice="configuration.dolar_price" :earnPercentage="configuration.earn_percentage" :title="product.productDescription" :id="product.asin" :searchType="search.type" :walmartTitle="product.title" :walmartImage="product.imageUrl" :walmartPrice="product.primaryOffer ? (product.primaryOffer.offerPrice ? product.primaryOffer.offerPrice : (product.primaryOffer.minPrice)) : ''" :walmartId="product.productId" :walmartUsItemId="product.usItemId"/>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <Paginator :pages="pages" :setPage="setPage" :isSearch="true" :actualPage="this.search.page"/>

            </div>

        </div>
      </div>
    </section>
    
</template>

<script>

import ProductCard from "../components/ProductCard";
import Loading from "../components/Loading"
import Paginator from "../components/Paginator"

export default {

    components:{ ProductCard, Loading, Paginator },
    computed: {
        searchClicked () {
            return this.$store.getters["getSearchClicked"]
        // Or return basket.getters.fruitsCount
        // (depends on your design decisions).
        }
    },
    watch: {
        searchClicked (newValue, oldValue) {
            // Our fancy notification (2).
            if(newValue == true){
                this.fetchProducts()
            }
        }
    },
    data(){
        return{
            search:"",
            loading:false,
            products:[],
            pages:0,
            configuration:[]
        }
    },
    methods:{

        fetchProducts(){
            this.products = []
            this.pages = 0
            this.$store.dispatch("storeSearchClicked", {value:false})
            this.search = this.$store.getters["getSearch"]
            
            this.searchProducts(this.search)

        },
        async searchProducts(search){
            
            if(search.query != ""){

                this.loading = true
            
                let res = await this.$axios.get("/search?queryWord="+search.query+"&page="+search.page+"&type="+search.type)
                if(res.data.products){
                    //console.log(res.data.products)
                    
                    if(search.type == "amazon"){
                        this.products = res.data.products.searchProductDetails
                        this.pages = Math.ceil(res.data.products.resultCount / res.data.products.numberOfProducts)
                        this.configuration = res.data.configuration
                    }else if(search.type == "walmart"){
                        this.products = res.data.products.productDetails
                        this.pages = this.search.page + 1
                        this.configuration = res.data.configuration
                    }
                    

                    console.log(this.products)
                }
                
                this.loading = false

            }

        },
        setPage(page){

            this.search.page = page
            this.fetchProducts(this.search)

        }

    },
    created(){
        this.fetchProducts()
    }
    
}
</script>