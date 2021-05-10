<template>
    
    <div class="d-flex flex-column-fluid" id="dev-appliance-list">

        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Congiuraciones</h3>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Soles por dolar</label>
                                    <input type="text" class="form-control" v-model="dolarPrice">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Porcentaje de ganancia %</label>
                                    <input type="text" class="form-control" v-model="earnPercentage">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Precio máximo sin impuesto (USD)</label>
                                    <input type="text" class="form-control" v-model="maxPriceWithoutTax">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Impuesto por sobreprecio %</label>
                                    <input type="text" class="form-control" v-model="priceTaxPercent">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Precio por libra</label>
                                    <input type="text" class="form-control" v-model="pricePerPound">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-center"> 
                                    <button class="btn btn-primary" @click="update()">Actualizar</button>
                                </p>
                            </div>
                        </div>
                    </div>

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

    export default {
        layout: 'admin/admin',
        middleware:["auth", "admin"],
        auth:"auth",
        components:{Loading},
        data(){
			return{
                errors:[],
				dolarPrice:0,
                maxPriceWithoutTax:0,
                priceTaxPercent:0,
                pricePerPound:0,
                earnPercentage:0,
				loading:false
			}
		},
        methods:{

			async fetch(){

                let res = await this.$axios.get("admin/configuration/fetch")
                this.dolarPrice = res.data.configuration.dolar_price
                this.maxPriceWithoutTax = res.data.configuration.max_price_without_tax
                this.priceTaxPercent = res.data.configuration.price_tax_percent * 100
                this.pricePerPound = res.data.configuration.price_per_pound
                this.earnPercentage = res.data.configuration.earn_percentage * 100

			},

            async update(){
                
				this.loading = true
				try{

					let res = await this.$axios.post("admin/configuration/upcate", {"dolarPrice": this.dolarPrice, "maxPriceWithoutTax": this.maxPriceWithoutTax, "priceTaxPercent": this.priceTaxPercent, "pricePerPound": this.pricePerPound, "earnPercentage": this.earnPercentage})

                    if(res.data.success == true){

                        this.$swal({
                            icon: 'success',
                            text: res.data.msg,
                        })

                    }else{

                        this.$swal({
                            icon: 'error',
                            text: res.data.msg,
                        })

                    }

				}catch(err){

                    if(err.response.data.error){
                        
                        this.$swal({
                            icon: 'error',
                            text: err.response.data.error,
                        })
                    }
                    if(err.response.data.errors){

                        this.$swal({
                            icon: 'error',
                            text: "Hay campos que debes revisar",
                            toast: true,
                            position: 'top-end',
                        })

                        this.errors = err.response.data.errors
                    }

				}

				this.loading = false
				
			},


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