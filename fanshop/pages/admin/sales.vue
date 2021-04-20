<template>
    
    <section class="container">
		<loading :loading="loading" />
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
                    <div class="moda-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">cerrar</button>

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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <label for="Ordenar por"></label>
                                    <select class="form-control" v-model="orderBy" @change="fetch(page)">
                                        <option value="1">Fecha (asc)</option>
                                        <option value="2">Fecha (desc)</option>
                                        <option value="3">Cliente (asc)</option>
                                        <option value="4">Cliente (desc)</option>
                                        <option value="5">Email (asc)</option>
                                        <option value="6">Email (desc)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
              			<div class="table-resposive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Status</td>
                                        <td>Cliente</td>
                                        <td>Email</td>
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
                                        <td>{{ purchase.user.name }} {{ purchase.user.lastname }}</td>
                                        <td>{{ purchase.user.email }}</td>
                                        <td>
                                            S. {{ Math.ceil(purchase.total * 3.63) }}
                                        </td>
                                        <td>
                                            <button @click="setProducts(purchase.purchase_products)" class="btn btn-info" data-toggle="modal" data-target=".productsModal">ver</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
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

    import Loading from '../../components/Loading';
    import Paginator from '../../components/Paginator';

    export default {
        layout: 'admin/admin',
        middleware:["auth", "admin"],
        auth:"auth",
        components:{Paginator, Loading},
        data(){
			return{
				purchases:[],
                products:[],
                statusDetails:[],
                orderBy:1,
                page:1,
                pages:1,
				loading:false
			}
		},
        methods:{

			async fetch(page = 1){
                this.page = page
				this.loading = true
				try{

					let res = await this.$axios.post("admin/sales/fetch", {page: this.page, orderBy: this.orderBy})
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
    }
</script>