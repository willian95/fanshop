<template>
    
    <div class="mt-150 container mb-2">
        <Loading :loading="loading" />
        <div class="row">
            <div class="col-md-4">
                <VueSlickCarousel :dots="true" v-if="images.length > 0">
                    <img class="custom-carousel-img img-responsive" v-for="(image, index) in images" v-bind:key="index" :src="image" alt="">
                
                </VueSlickCarousel>
                
                <h4>Variaciones:</h4>

                <div v-for="(variation, index) in variations" v-bind:key="index">
                    <h4>{{ variation.variationName }}</h4>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="(value, indexValues) in variation.values" v-bind:key="indexValues">
                            <a v-if="value.dpUrl" class="cursor-pointer" @click="fetch('https://www.amazon.com'+value.dpUrl, searchType)" >{{ value.value }} ${{ value.price }}</a>
                        </li>
                    </ul>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="content-decription">
                    <h3>{{ title }}</h3>
                    <p>{{ description }}</p>
                </div>

                <h3>Disponibilidad: {{ availability }}</h3>
                <!--<h3>Cantidad mínima: {{ minimalQuantity }}</h3>-->

                <h3>Características:</h3>
                <p v-for="(feature, index) in features" v-bind:key="index">{{ feature }}</p>

            </div>
            <div class="col-md-4">
                <div class="content-decription-pago">
                    <!--<p class="info_price">Precio: <span>USD 100</span> </p>
                    <p class="info_price">Ahorras: USD 100</p>-->

                    <div class="precio-detail">USD {{ price }}</div>
                    
                    <p>Agreegar el producto al carrito para conocer los costos de envio</p>
                    <span class="metodo-img"> <strong>Compra con</strong>
                        <img src="/img/Metodos-Pago.png" alt="">
                    </span>
                    <div class="text-center mt-3" v-if="isAuthenticated">
                        <a class="btn-custom" @click="storeCart()">
                            
                            <img class="icon_btn" src="/img/cart-add.svg" alt="">
                            Agregar al carrito</a>
                        <a href="carrito.html" class="btn-custom">
                            <img class="icon_btn" src="/img/add-white.svg" alt="">
                            Comprar
                        </a>
                    </div>
                    <div class="text-center mt-3" v-else>
                        <p class="text-center">Debes ingresar a tu cuenta para poder comprar</p>
                        <NuxtLink :to="{path: '/login'}" class="btn btn-info">login</NuxtLink>
                    </div>
                </div>

            </div>
        </div>

    	<div class="relacionados mt-5 pt-5">
        <div class='container'>
            <div class='title-general text-center mb-4'>
                <h1>Productos relacionados </h1>
            </div>
            <div class="producto-carousel row">
				<a class="card-producto col-md-3" href="detalle.html">
					<div class="card-content">
						<div class="card-producto-img">	<p class="btn-custom" >Añadir al carrito</p>
							<p class="btn-custom" >Añadir al carrito</p>
							<img src="assets/img/product.jpeg" class="card-content-img" alt="" />
						</div>
						<div class="card-producto-content">
							<h4 class="title-producto">lorem ipsum asmet dolor</h4>
							<p class="description-producto">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi
								laudantium eligendi sed perferendis.
							</p>
							<span class="price">$18.00</span>
						</div>
					</div>
				</a>
				<a class="card-producto col-md-3" href="detalle.html">
					<div class="card-content">
						<div class="card-producto-img">	<p class="btn-custom" >Añadir al carrito</p>
							<img src="assets/img/product.jpeg" class="card-content-img" alt="" />
						</div>
						<div class="card-producto-content">
							<h4 class="title-producto">lorem ipsum asmet dolor</h4>
							<p class="description-producto">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi
								laudantium eligendi sed perferendis.
							</p>
							<span class="price">$18.00</span>
						</div>
					</div>
				</a>
				<a class="card-producto col-md-3" href="detalle.html">
					<div class="card-content">
						<div class="card-producto-img">	<p class="btn-custom" >Añadir al carrito</p>
							<img src="assets/img/product.jpeg" class="card-content-img" alt="" />
						</div>
						<div class="card-producto-content">
							<h4 class="title-producto">lorem ipsum asmet dolor</h4>
							<p class="description-producto">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi
								laudantium eligendi sed perferendis.
							</p>
							<span class="price">$18.00</span>
						</div>
					</div>
				</a>
				<a class="card-producto col-md-3" href="detalle.html">
					<div class="card-content">
						<div class="card-producto-img">	<p class="btn-custom" >Añadir al carrito</p>
							<img src="assets/img/product.jpeg" class="card-content-img" alt="" />
						</div>
						<div class="card-producto-content">
							<h4 class="title-producto">lorem ipsum asmet dolor</h4>
							<p class="description-producto">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi
								laudantium eligendi sed perferendis.
							</p>
							<span class="price">$18.00</span>
						</div>
					</div>
				</a>
				
			</div>
                <!-- <div class='cta-producto'>
                    <a class='btn btn-primary btn-shadow' href='#'>Más productos</a>
                </div> -->
            </div>
        </div>
    </div>

</template>

<script>

    import VueSlickCarousel from 'vue-slick-carousel'
    import 'vue-slick-carousel/dist/vue-slick-carousel.css'
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

    import Loading from "../components/Loading"

    import { mapGetters } from 'vuex'
    
    export default {
        name:"productDetail",
        components:{VueSlickCarousel, Loading},
        data(){
            return{
                loading:true,
                images:[],
                mainImage:"",
                title:"",
                description:"",
                features:[],
                price:0,
                availability:"",
                minimalQuantity:1,
                variations:[],
                id:"",
                searchType:""
            }
        },
        computed: {
			...mapGetters(['isAuthenticated', 'loggedInUser']),
		},
        methods:{

            async storeCart(){

                this.loading = true
                let res = await this.$axios.post("/cart/store", {"productId": this.$route.query.id, "searchType": this.$route.query.searchType, "object": JSON.stringify(this.detail)})
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
            async fetch(id, searchType){
                this.clear()
                this.loading = true

                this.id = id
                this.searchType = searchType
            
                let res = await this.$axios.post('/product', {"id": this.id, "searchType":this.searchType})
                if(res.data){
                    this.images = res.data.imageUrlList
                    this.title = res.data.productTitle
                    this.description = res.data.productDescription
                    this.features = res.data.features
                    this.price = res.data.price
                    this.availability = res.data.warehouseAvailability
                    this.variations = res.data.variations
                }
                this.loading = false

            },
            clear(){

                this.images = []
                this.mainImage = ""
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
</style>