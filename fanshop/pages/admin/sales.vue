<template>
    
    <div class="d-flex flex-column-fluid" id="dev-appliance-list">

        <PurchaseModal :products="products" :toggleProducts="toggleProducts" :checkTest="checkTest" :selectedProducts="selectedProducts" :dateFormatter="dateFormatter"/>

        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Ventas</h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Dropdown-->
                        <button class="btn btn-primary" @click="addToAmazon()">Añadir a Amazon</button>
                        <!--end::Dropdown-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin: Datatable-->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Ordenar por:</label>
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

                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style="">
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
                    <!--end: Datatable-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->

    </div>


    
		
	
</template>

<script>

    import Loading from '../../components/Loading';
    import Paginator from '../../components/Paginator';
    import PurchaseModal from '../../components/admin/sales/PurchaseModal';

    export default {
        layout: 'admin/admin',
        middleware:["auth", "admin"],
        auth:"auth",
        components:{Paginator, Loading, PurchaseModal},
        data(){
			return{
				purchases:[],
                products:[],
                statusDetails:[],
                selectedProducts:[],
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
            },
            toggleProducts(id, amount, asin){

                let product = this.selectedProducts.filter((product) => {

                    return product.id == id

                })

                if(product.length == 0){

                    this.selectedProducts.push({id: id, amount: amount, asin: asin})

                }else{

                    this.selectedProducts.forEach((product, index) => {

                        if(product.id == id){
                            this.selectedProducts.splice(index, 1)
                        }

                    })

                }


            },
            checkTest(product){
                    var exists = false
                this.selectedProducts.forEach((data) => {
                    if(data.id == product.id){
                        exists = true
                    }
                })

                return exists
            },
            async addToAmazon(){
                this.loading = true
                let res = await this.$axios.post("/admin/sales/add-to-amazon", {products: this.selectedProducts})
                this.loading = false
                if(res.data.success == true){
                    this.$swal({
                        text:res.data.msg,
                        icon: "success"
                    }).then(ans => {
                        this.fetch(this.page)
                    })

                    this.selectedProducts = []
                }

                else{
                    this.$swal({
                        text:res.data.msg,
                        icon: "error"
                    })
                }
                

            }

		},
		created(){
			this.fetch()
		}
    }
</script>

<style>
    .content{
        margin-left: 0px;
    }
</style>