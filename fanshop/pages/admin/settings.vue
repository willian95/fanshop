<template>
    
    <div class="d-flex flex-column-fluid" id="dev-appliance-list">

        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Congfiuraciones</h3>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 mt-3 mb-3">
                                <h4 class="text-left">Configuraciones de precio</h4>
                                <hr>
                            </div>
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
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12 mt-3 mb-3">
                                <h4 class="text-left">Configuración de dirección de envío</h4>
                                <hr>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" v-model="shippingName">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Apellido</label>
                                    <input type="text" class="form-control" v-model="shippingLastname">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Dirección</label>
                                    <input type="text" class="form-control" v-model="shippingAddress">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Código postal</label>
                                    <input type="text" class="form-control" v-model="shippingZipCode">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Ciudad</label>
                                    <input type="text" class="form-control" v-model="shippingCity">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Estado</label>
                                    <input type="text" class="form-control" v-model="shippingState">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">País</label>
                                    <input type="text" class="form-control" v-model="shippingCountry">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Número de teléfono</label>
                                    <div class="d-flex">
                                        <span class="text-bold" style="font-size: 20px;">+</span><input type="text" class="ml-1 form-control" v-model="shippingPhoneNumber">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12 mt-3 mb-3">
                                <h4 class="text-left">Configuración de dirección de facturación</h4>
                                <hr>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" v-model="billingName">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Apellido</label>
                                    <input type="text" class="form-control" v-model="billingLastname">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Dirección</label>
                                    <input type="text" class="form-control" v-model="billingAddress">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Código postal</label>
                                    <input type="text" class="form-control" v-model="billingZipCode">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Ciudad</label>
                                    <input type="text" class="form-control" v-model="billingCity">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Estado</label>
                                    <input type="text" class="form-control" v-model="billingState">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">País</label>
                                    <input type="text" class="form-control" v-model="billingCountry">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Número de teléfono</label>
                                    <div class="d-flex">
                                        <span class="text-bold" style="font-size: 20px;">+</span><input type="text" class="ml-1 form-control" v-model="billingPhoneNumber">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12 mt-3 mb-3">
                                <h4 class="text-left">Configuración de tarjeta</h4>
                                <hr>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" v-model="nameOnCard">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Número</label>
                                    <input type="text" class="form-control" v-model="cardNumber">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Código de seguridad</label>
                                    <input type="text" class="form-control" v-model="cardSecurityCode">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Mes de expiración</label>
                                    <input type="text" class="form-control" v-model="cardExpirationMonth">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Año de expiración</label>
                                    <input type="text" class="form-control" v-model="cardExpirationYear">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12 mt-3 mb-3">
                                <h4 class="text-left">Credenciales Amazon</h4>
                                <hr>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Correo</label>
                                    <input type="text" class="form-control" v-model="amazonEmail">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Contraseña</label>
                                    <input type="text" class="form-control" v-model="amazonPassword">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Clave 2FA</label>
                                    <input type="text" class="form-control" v-model="amazonTwoFactor">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-12 mt-3 mb-3">
                                <h4 class="text-left">Credenciales Walmart</h4>
                                <hr>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Correo</label>
                                    <input type="text" class="form-control" v-model="walmartEmail">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Contraseña</label>
                                    <input type="text" class="form-control" v-model="walmartPassword">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr>
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
				loading:false,

                shippingName:"",
                shippingLastname:"",
                shippingAddress:"",
                shippingZipCode:"",
                shippingCity:"",
                shippingState:"",
                shippingCountry:"",
                shippingPhoneNumber:"",

                billingName:"",
                billingLastname:"",
                billingAddress:"",
                billingZipCode:"",
                billingCity:"",
                billingState:"",
                billingCountry:"",
                billingPhoneNumber:"",

                nameOnCard:"",
                cardNumber:"",
                cardSecurityCode:"",
                cardExpirationMonth:"",
                cardExpirationYear:"",

                amazonEmail:"",
                amazonPassword:"",
                amazonTwoFactor:"",

                walmartEmail:"",
                walmartPassword:""

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

                this.shippingName = res.data.configuration.shipping_name
                this.shippingLastname = res.data.configuration.shipping_last_name
                this.shippingAddress = res.data.configuration.shipping_address
                this.shippingZipCode = res.data.configuration.shipping_zip_code
                this.shippingCity = res.data.configuration.shipping_city
                this.shippingState = res.data.configuration.shipping_state
                this.shippingCountry = res.data.configuration.shipping_country
                this.shippingPhoneNumber = res.data.configuration.shipping_phone_number

                this.billingName = res.data.configuration.billing_name
                this.billingLastname = res.data.configuration.billing_last_name
                this.billingAddress = res.data.configuration.billing_address
                this.billingZipCode = res.data.configuration.billing_zip_code
                this.billingCity = res.data.configuration.billing_city
                this.billingState = res.data.configuration.billing_state
                this.billingCountry = res.data.configuration.billing_country
                this.billingPhoneNumber = res.data.configuration.billing_phone_number

                this.nameOnCard = res.data.configuration.name_on_card
                this.cardNumber = res.data.configuration.card_number
                this.cardSecurityCode = res.data.configuration.card_security_code
                this.cardExpirationMonth = res.data.configuration.card_expiration_month
                this.cardExpirationYear = res.data.configuration.card_expiration_year

                this.amazonEmail = res.data.configuration.amazon_email
                this.amazonPassword = res.data.configuration.amazon_password
                this.amazonTwoFactor = res.data.configuration.amazon_two_factor

                this.walmartEmail = res.data.configuration.walmart_email
                this.walmartPassword = res.data.configuration.walmart_password

			},

            async update(){
                
				this.loading = true
				try{

					let res = await this.$axios.post("admin/configuration/update", {
                        "dolarPrice": this.dolarPrice, 
                        "maxPriceWithoutTax": this.maxPriceWithoutTax, 
                        "priceTaxPercent": this.priceTaxPercent, 
                        "pricePerPound": this.pricePerPound, 
                        "earnPercentage": this.earnPercentage,
                        "shippingName":this.shippingName,
                        "shippingLastname":this.shippingLastname,
                        "shippingAddress":this.shippingAddress,
                        "shippingZipCode":this.shippingZipCode,
                        "shippingCity":this.shippingCity,
                        "shippingState":this.shippingState,
                        "shippingCountry":this.shippingCountry,
                        "shippingPhoneNumber":this.shippingPhoneNumber,
                        "billingName":this.billingName,
                        "billingLastname":this.billingLastname,
                        "billingAddress":this.billingAddress,
                        "billingZipCode":this.billingZipCode,
                        "billingCity":this.billingCity,
                        "billingState":this.billingState,
                        "billingCountry":this.billingCountry,
                        "billingPhoneNumber":this.billingPhoneNumber,
                        "nameOnCard":this.nameOnCard,
                        "cardNumber":this.cardNumber,
                        "cardSecurityCode":this.cardSecurityCode,
                        "cardExpirationMonth":this.cardExpirationMonth,
                        "cardExpirationYear":this.cardExpirationYear,
                        "amazonEmail":this.amazonEmail,
                        "amazonPassword":this.amazonPassword,
                        "amazonTwoFactor":this.amazonTwoFactor,
                        "walmartEmail":this.walmartEmail,
                        "walmartPassword":this.walmartPassword
                    })

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