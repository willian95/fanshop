<template>
  	<section class="container mt-150 carrito">
		<loading :loading="loading" />
    	<div class="row">
     	 	<div class="col-sm-12">
        		<div class="carrito">
          			<div class="title-general text-center mb-4">
            		<h1>Carrito</h1>
          		</div>
          		<div class="row">
					<div class="col-md-12">
              			<table class="table table-bordered">
                			<thead>
                  				<tr>
                    				<td>Producto</td>
                    				<td></td>
                    				<td>Precio unitario</td>
                    				<td>Cantidad</td>
                    				<td>Total</td>
									<td></td>
                  				</tr>
                			</thead>
                			<tbody>
								<CartRow v-for="product in products" v-bind:key="product.id" :cart="product" :product="JSON.parse(product.product.object)" :erase="eraseProduct" />

                			</tbody>
              			</table>
            		</div>

            		<div class="col-md-6 mt-5">
              			<div class="pedido">
                			<!--<div class="pedido-item">
                  				<p>Envio a deposito:</p>
                  				<span>Gratis</span>
							</div>

                			<div class="pedido-item">
                  				<p>Tax interno:</p>
                  				<span>USD 300.00</span>
                			</div>

                			<div class="pedido-item">
                  				<p>Shipping internacional:</p>
                  				<span>USD 300.00</span>
							</div>
                			<div class="pedido-item">
                  				<p>Envio:</p>
                  				<span>USD 300.00</span>
                			</div>-->
              			</div>
            		</div>
					<div class="col-md-6 mt-5">
              			<div class="pedido">
                			<!--<div class="pedido-item">
                  				<p>Subtotal:</p>
                  				<span>USD 300.00</span>
                			</div>-->
                			<div class="pedido-item">
                  				<p>Total</p>
                  				<span>USD {{ total[0] }}</span>
                			</div>

                			<span class="metodo-img" style="align-items: flex-end">
                  				<strong></strong>
								<img src="assets/img/Metodos-Pago.png" alt="" />
							</span>
                			<div class="text-center mt-3">
                  				<NuxtLink :to="{ path:'/home' }" class="btn-custom">
                    				<img
                     					 class="icon_btn"
										src="assets/img/cart-add.svg"
									alt=""/>
                    				Seguir comprando
								</NuxtLink>
								<NuxtLink :to="{ path:'/checkout'}" class="btn-custom ml-5">
									Finalizar compra
								</NuxtLink>
               		 		</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

  	</section>
</template>

<script>

	import Loading from '../components/Loading';
	import CartRow from '../components/cart/CartRow';

	export default {
		middleware:"auth",
        auth:"auth",
		components:{CartRow, Loading},
		computed: {
			total () {
				var total = 0;
				return this.products.map(product => {

					total = total + parseFloat(JSON.parse(product.product.object).price)
					return total
				})
			}
		},
		data(){
			return{
				products:[],
				loading:false
			}
		},
		methods:{

			async fetch(){

				this.loading = true
				try{

					let res = await this.$axios.get("cart/fetch")
					this.products = res.data.products
					

				}catch(err){

				}
				this.loading = false
				
			},
			async eraseProduct(id){

	
				try{

					if(confirm("¿Estás seguro?")){

						this.products = this.products.filter(product => {
							return product.id !== id
						})

						await this.$axios.post("cart/delete", {id})

					}
					

				}catch(err){

				}
	

			}

		},
		created(){
			this.fetch()
		}
		
	};
</script>
