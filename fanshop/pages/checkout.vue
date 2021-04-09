<template>
    
    <section class="container mt-150">
        <div class="row">
            <div class="col-md-7">

                <UserFormData :name="name" :lastname="lastname" :email="email" :phone="phone" :address="address" />

            </div>
            <div class="col-md-5">

                <div class="pago shadow-card">
                    <form action="">
                        <div class="form-group">

                            <input type="text" class="form-control" id="inputAddress" placeholder="Tarjeta" v-model="card">
                        </div>
                        <div class="form-group">

                            <input type="text" class="form-control" id="inputAddress" placeholder="CVV" v-model="cvv">
                        </div>
                    </form>
                    <div class="text-center">
                        <a class="btn-custom pl-4 pr-4" href="">pagar</a>

                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="carrito">
          			<div class="title-general text-center mb-4">
                        <h1>Carrito</h1>
                    </div>
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
								<CartRow v-for="product in products" v-bind:key="product.id" :cart="product" :product="JSON.parse(product.product.object)" :erase="null" :showError="false" />

                			</tbody>
              			</table>
            		</div>
                </div>
            </div>
        </div>

    </section>

</template>

<script>

    import UserFormData from '../components/checkout/UserFormData';
    import CartRow from '../components/cart/CartRow';

    export default {
        middleware:"auth",
        auth:"auth",
        data(){

            return{

                name:this.$auth.user.name,
                lastname:this.$auth.user.lastname,
                email:this.$auth.user.email,
                phone:this.$auth.user.phone,
                address:this.$auth.user.address,
                products:[],
				loading:false
            }

        },
        components:{UserFormData, CartRow},
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

        },
        created(){

            this.fetch()

        }

    }
</script>