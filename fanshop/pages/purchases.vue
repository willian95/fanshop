<template>
  	<section class="container mt-150 carrito">
		<loading :loading="loading" />

        <!-- Modal -->
        <div class="modal fade trackingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trackings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="container">
                        
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tracking</th>
                                            <th>Url</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="tracking in trackings" v-bind:key="tracking.id">
                                            <td>
                                                {{ tracking.tracking }}
                                            </td>
                                            <td>
                                                <a :href="tracking.url">{{ tracking.url }}</a>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                    <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
                </div>
            </div>
        </div>

    	<div class="row">

            <!-- Modal -->
            <div class="modal fade productsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Productos comprados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products" v-bind:key="product.id">
                                    <td><img style="max-width: 120px;" :src="product.product.image" alt=""></td>
                                    <td>
                                        <NuxtLink :to="{path: '/product', query: { id: product.product.productId, searchType: product.product.searchType }}" v-on:click.native="hideModal()">
                                            <p>{{ JSON.parse(product.product.object).productTitle.substring(0, 60) }}</p>
                                        </NuxtLink>
                                    </td>
                                    <td>USD {{ product.unit_price }}</td>
                                    <td>{{ product.amount }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    </div>
                </div>
            </div>


     	 	<div class="col-sm-12">
        		<div class="carrito">
          			<div class="title-general text-center mb-4">
            		<h1>Mis compras</h1>
          		</div>
          		<div class="row">
					<div class="col-md-12">
              			<table class="table table-bordered">
                			<thead>
                  				<tr>
                    				<td>Fecha</td>
                    				<td>Status</td>
                    				<td>Total</td>
									<td></td>
                  				</tr>
                			</thead>
                			<tbody>
								<tr v-for="purchase in purchases" v-bind:key="purchase.id">
                                    <td>{{ dateFormatter(purchase.created_at) }}</td>
                                    <td>
                                        <span v-if="purchase.status == 'approved'">Aprobado</span>
                                        <span v-if="purchase.status == 'in_process'">En proceso</span>
                                        <span v-if="purchase.status == 'rejected'">Rechazado</span>
                                        {{ showStatusDetail(purchase) }}
                                    </td>
                                    <td>
                                        S. {{ Math.ceil(purchase.total * 3.63) }}
                                    </td>
                                    <td>
                                        <button @click="setProducts(purchase.purchase_products)" class="btn btn-info" data-toggle="modal" data-target=".productsModal">ver</button>
                                        <button @click="setTracking(purchase.trackings)" class="btn btn-info" data-toggle="modal" data-target=".trackingModal">tracking</button>
                                    </td>
                                </tr>
                			</tbody>
              			</table>
            		</div>
				</div>
                <div class="row">
                    <div class="col-12">
                        <Paginator :pages="pages" :setPage="setPage" :isSearch="false"/>
                    </div>
                </div>
			</div>
		</div>
	</div>

  	</section>
</template>

<script>

	import Loading from '../components/Loading';
    import Paginator from '../components/Paginator';

	export default {
		middleware:"auth",
        auth:"auth",
		components:{Paginator, Loading},
		data(){
			return{
				purchases:[],
                products:[],
                statusDetails:[],
                page:1,
                pages:1,
				loading:false,
                trackings:[]
			}
		},
		methods:{

			async fetch(page = 1){
                this.page = page
				this.loading = true
				try{

					let res = await this.$axios.get("purchase/fetch?page="+this.page)
					this.purchases = res.data.purchases
                    this.pages = Math.ceil(res.data.purchasesCount/res.data.dataAmount)
                    this.fetchDetails()
					

				}catch(err){

				}
				this.loading = false
				
			},
            async fetchDetails(){

                let res = await this.$axios.get("mercado-pago-details")
				this.statusDetails = res.data.details

            },
            hideModal(){
               
                $('.productsModal').modal('hide')
                $('.modal-backdrop').remove()       
            },
            showStatusDetail(purchase){
                let status = this.statusDetails.filter(status => { return status.status === purchase.mercado_pago_status_detail })

                if(status.length > 0){
                        
                    return status[0].description.replaceAll("/amount/", "S. "+Math.ceil(purchase.total * 3.63)).replaceAll("/payment_method_id/", purchase.mercado_pago_payment_method_id).replaceAll("/installments/", purchase.mercado_pago_installments)
      
                    
                }

            },
            setPage(page){

                this.fetch(page)

            },
            setTracking(trackings){

                this.trackings = trackings

            },
            dateFormatter(date){

                let year = date.substring(0, 4)
                let month = date.substring(5, 7)
                let day = date.substring(8, 10)

                return day+"-"+month+"-"+year

            },
            setProducts(products){
                this.products = products
            }

		},
		created(){
			this.fetch()
		}
		
	};
</script>
