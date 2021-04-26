<template>
    
    <div class="mt-150 container mb-2">
        <Loading :loading="loading" />

        <div class="row" v-if="error">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Producto no disponible</h3>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row" v-else>
            <div class="col-md-4">
                <VueSlickCarousel :dots="true" v-if="images.length > 0">
                    <img class="custom-carousel-img img-responsive" v-for="(image, index) in images" v-bind:key="index" :src="image" alt="">
                
                </VueSlickCarousel>
                
                <h5 class="mt-5">Disponibilidad: {{ availability }}</h5>
                <h5>Cantidad mínima: {{ minimalQuantity }}</h5>

                <h4>Variaciones:</h4>

                <div v-for="(variation, index) in variations" v-bind:key="index">
                    <h4>{{ variation.variationName }}</h4>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(value, indexValues) in variation.values" v-bind:key="indexValues">
                            <a v-if="value.dpUrl" class="cursor-pointer" @click="fetch('https://www.amazon.com'+value.dpUrl, searchType)" >{{ value.value }}</a>
                        </li>
                    </ul>
                </div>
                
                <h4>Detalles del producto</h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Detalle</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(detail, index) in productDetails" v-bind:key="index">
                            <td>
                                {{ detail.name }}
                            </td>
                            <td>
                                <p>{{ detail.value }}</p>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div class="col-md-4">
                <div class="content-decription">
                    <h3>{{ title }}</h3>
                    <p>{{ description }}</p>
                </div>

                <h3>Características:</h3>
                <p v-for="(feature, index) in features" v-bind:key="index">{{ feature }}</p>

            </div>
            <div class="col-md-4">
                <div class="content-decription-pago">

                    <div class="precio-detail">
                        <p class="medium-fs">Precio: <span>USD {{ price }}</span></p>
                    </div>
                    <div v-if="price > maxPriceWithoutTax" class="precio-detail">
                        <p class="medium-fs">Impuesto: USD {{ Math.ceil(price * maxPriceTax) }}</p>
                        <p class="small-fs">Toda comprar mayor a 200 USD tendrá un impuesto del {{ maxPriceTax * 100 }}%</p>
                    </div>

                    <div v-if="weight == 0" class="precio-detail">
                        <p class="medium-fs">Precio de envío con cobro a destino</p>
                    </div>

                    <div v-if="weight == 1" class="precio-detail">
                        <p class="medium-fs">Costo de envío: USD 15</p>
                    </div>

                    <div v-if="weight > 1" class="precio-detail">
                        <p class="medium-fs">Costo de envío: USD {{ Math.ceil(weight * pricePerPound) }}</p>
                    </div>

                    <div class="precio-detail">
                        <p class="large-fs">Total: USD {{ Math.ceil(total) }}</p>
                    </div>
                    
                    <!--<p>Agreegar el producto al carrito para conocer los costos de envio</p>-->
                    <span class="metodo-img"> <strong>Compra con</strong>
                        <img src="/img/Metodos-Pago.png" alt="">
                    </span>
                    <div class="text-center mt-3" v-if="isAuthenticated">
                        <button class="btn btn-custom" @click="storeCart()" v-if="showAddToCartButton == true">
                            
                            <img class="icon_btn" src="/img/cart-add.svg" alt="">
                            Agregar al carrito</button>
                        <!--<a href="carrito.html" class="btn-custom">
                            <img class="icon_btn" src="/img/add-white.svg" alt="">
                            Comprar
                        </a>-->
                    </div>
                    <div class="text-center mt-3" v-else>
                        <p class="text-center">Debes ingresar a tu cuenta para poder comprar</p>
                        <NuxtLink :to="{path: '/login'}" class="btn btn-info">login</NuxtLink>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <Recommendations :asin="id" :searchType="searchType" :fetch="setId" :productCategory="productCategory" v-if="productCategory != ''"/>

            </div>

        </div>


    </div>

</template>

<script>

    import VueSlickCarousel from 'vue-slick-carousel'
    import 'vue-slick-carousel/dist/vue-slick-carousel.css'
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

    import Loading from "../components/Loading"
    import Recommendations from "../components/Recommendations"

    import { mapGetters } from 'vuex'
    
    export default {
        name:"productDetail",
        components:{VueSlickCarousel, Loading, Recommendations},
        data(){
            return{
                fullObject:"",
                loading:true,
                images:[],
                title:"",
                description:"",
                features:[],
                price:0,
                availability:"",
                minimalQuantity:1,
                variations:[],
                productCategory:"",
                id:"",
                searchType:"",
                error:false,
                productDetails:[],
                weight:0,
                maxPriceWithoutTax:0,
                maxPriceTax:0,
                pricePerPound:0,
                total:0,
                showAddToCartButton:false

            }
        },
        computed: {
			...mapGetters(['isAuthenticated', 'loggedInUser']),
		},
        methods:{

            async storeCart(){

                this.loading = true
                
                var destinationPayment = 0;
                if(this.weight == 0){
                    destinationPayment = 1;
                }

                let res = await this.$axios.post("/cart/store", {"productId": this.id, "searchType": this.$route.query.searchType, "image": this.images[0], "price": this.total, "object": JSON.stringify(this.fullObject), "amount": this.minimalQuantity, "destinationPayment": destinationPayment})
                if(res.data.success == true){

                    this.$swal({
                        icon: 'success',
                        toast:true,
                        position:"top-end",
                        text: res.data.msg,
                    })

                }else{

                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: res.data.msg,
                    })

                }
                this.loading = false

            },
            setId(id){
                this.fetch(id, this.searchType)
            },
            async fetch(id, searchType){

                this.clear()
                this.loading = true

                this.id = id
                this.searchType = searchType
            
                let res = await this.$axios.post('/product', {"id": this.id, "searchType":this.searchType})
                
                if(res.data.product.imageUrlList){
                    console.log("product", res.data.product)
                    this.fullObject = res.data.product
                    this.id = res.data.product.asin
                    this.images = res.data.product.imageUrlList
                    this.title = res.data.product.productTitle
                    this.description = res.data.product.productDescription
                    this.features = res.data.product.features
                    this.price = res.data.product.price
                    this.availability = res.data.product.warehouseAvailability
                    this.variations = res.data.product.variations
                    this.productDetails = res.data.product.productDetails
                    this.productCategory = res.data.product.categories[0]

                    this.calculateTaxes(res)
                    this.checkAvailability()
                    

                }else{
                    this.error = true
                }
                this.loading = false

            },
            calculateTaxes(res){

                this.weight = 0
                this.maxPriceWithoutTax = res.data.configuration.max_price_without_tax
                this.maxPriceTax = res.data.configuration.price_tax_percent
                this.pricePerPound = res.data.configuration.price_per_pound                    
                let weightTax = 0
                let priceTax = 0

                if(res.data.productDetails != null){
                    let weight = res.data.product.productDetails.filter(data => { if(data.name .toLowerCase() == "item weight") return data.value  })
                    this.weight = 0
                    if(weight.length > 0){
                        if( weight[0]["value"].toLowerCase().indexOf("pound") > -1){
                            weight = weight[0]["value"].toLowerCase().substring(0, weight[0]["value"].indexOf("pound"))
                            this.weight = parseFloat(weight)
                        }

                        else if(weight[0]["value"].toLowerCase().indexOf("ounce") > -1){
                            weight = weight[0]["value"].toLowerCase().substring(0, weight[0]["value"].indexOf("ounce"))
                            weight = parseFloat(weight)

                            if(weight <= 16){
                                this.weight = 1
                            }else{

                                this.weight = weight/16;

                            }
                        }
                    }

                    if(weight == 1){
                        weightTax = 15;
                    }else if(weight > 1){
                        weightTax = this.weight * this.pricePerPound
                    }

                }

                if(this.price > this.maxPriceWithoutTax){
                    priceTax = this.price * this.maxPriceTax
                }

                this.total = this.price + weightTax + priceTax

            },
            checkAvailability(){

                if(this.availability.toLowerCase().indexOf("in stock") > -1){

                    this.showAddToCartButton = true

                }

            },
            clear(){
                window.scrollTo(0, 0);
                this.images = []
                this.title = ""
                this.description = ""
                this.features = []
                this.price = 0
                this.availability = ""
                this.minimalQuantity = 1
                this.variations = []

            }

        },
        created: async function(){
            
            this.fetch(this.$route.query.id, this.$route.query.searchType)
           

        }
    }
</script>

<style>
    .custom-carousel-img{
        max-height: 400px;
    }

    .cursor-pointer{
        cursor: pointer;
    }

    .small-fs{
        font-size: 10px;
        margin-top:-10px;
    }

    .medium-fs{
        font-size: 16px;
    }

    .large-fs{
        font-size: 20px;
    }

</style>