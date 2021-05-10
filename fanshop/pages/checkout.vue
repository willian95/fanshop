<template>
    
    <section class="container mt-150">
        <loading :loading="loading" />
        <div class="row">
            <div class="col-md-8">

                <!--<UserFormData :name="name" :lastname="lastname" :email="email" :phone="phone" :address="address" />-->
                <div class="shadow-card">
                    <div class='title-general title-general2'>
                        <h1>Datos</h1>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">

                            <input type="text" class="form-control" id="inputEmail4" placeholder="Nombre" v-model="name" readonly>

                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="inputEmail4" placeholder="Apellido" v-model="lastname" readonly>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">

                            <input type="text" class="form-control" id="inputEmail4" placeholder="Email" v-model="email" readonly>
                        </div>
                        <div class="form-group col-md-6">

                            <input type="text" class="form-control" id="phoneInput" placeholder="phone" v-model="phone">

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="addressInput" placeholder="Dirección" v-model="address">
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
                                            <td style="width: 200px;"></td>
                                            <td>Precio unitario</td>
                                            <td>Cantidad</td>
                                            <td>Total</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <CartRow v-for="product in products" v-bind:key="product.id" :cart="product" :product="JSON.parse(product.product.object)" :erase="null" :showErase="false" :showUpdateAmount="false"/>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">

                <div class="pago shadow-card">
                    <form action="checkout" @submit.prevent="getCardToken()" id="paymentForm">
                        <h3>Detalles del comprador</h3>
                        <div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input id="email" class="form-control"  type="email" v-model="email" />
                                <ErrorShow :error="errors" :name="'email'"/>
                            </div>
                            <div class="form-group">
                                <label for="docType">Tipo de documento</label>
                                <select id="docType" name="docType" data-checkout="docType" type="text" class="form-control">
                                </select>
                                <ErrorShow :error="errors" :name="'docType'"/>
                            </div>
                            <div class="form-group">
                                <label for="docNumber">Número de documento</label>
                                <input id="docNumber" name="docNumber" data-checkout="docNumber" type="text" class="form-control"/>
                                <ErrorShow :error="errors" :name="'docNumber'"/>
                            </div>
                        </div>
                        <h3>Detalles de la tarjeta</h3>
                        <div>
                            <div class="form-group">
                                <label for="cardholderName">Titular de la tarjeta</label>
                                <input id="cardholderName" data-checkout="cardholderName" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Fecha de vencimiento</label>
                                <div class="d-flex">
                                    <input @keypress="isNumber($event)" maxlength="2" type="text" style="width: 60px;" placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth"
                                    onselectstart="return false" onpaste="return false"
                                    oncopy="return false" oncut="return false"
                                    ondrag="return false" ondrop="return false" autocomplete=off class="form-control">
                                    <span class="date-separator text-center" style="width: 40px;">/</span>
                                    <input @keypress="isNumber($event)" maxlength="2" type="text" style="width: 60px;" placeholder="YY" id="cardExpirationYear" data-checkout="cardExpirationYear"
                                    onselectstart="return false" onpaste="return false"
                                    oncopy="return false" oncut="return false"
                                    ondrag="return false" ondrop="return false" autocomplete=off class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cardNumber">Número de la tarjeta</label>
                                <input type="text" id="cardNumber" data-checkout="cardNumber"
                                onselectstart="return false" onpaste="return false"
                                oncopy="return false" oncut="return false"
                                ondrag="return false" ondrop="return false" autocomplete=off class="form-control" @change="guessPaymentMethod($event)" v-model="cardNumber">
                            </div>
                            <div class="form-group">
                                <label for="securityCode">Código de seguridad</label>
                                <input id="securityCode" data-checkout="securityCode" type="text"
                                onselectstart="return false" onpaste="return false"
                                oncopy="return false" oncut="return false"
                                ondrag="return false" ondrop="return false" autocomplete=off class="form-control">
                            </div>
                            <div id="issuerInput" class="form-group">
                                <label for="issuer">Banco emisor</label>
                                <select id="issuer" name="issuer" data-checkout="issuer" v-model="issuer" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="installments">Cuotas</label>
                                <select type="text" id="installments" name="installments" class="form-control"></select>
                            </div>
                            <div>
                                <input type="hidden" name="transactionAmount" id="transactionAmount" v-model="total" />
                                <input type="hidden" name="paymentMethodId" id="paymentMethodId" v-model="paymentMethodId"/>
                                <input type="hidden" name="description" id="description" />
                                <br>
                                <button class="btn-custom pl-4 pr-4" type="submit">Pagar</button>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        

    </section>

</template>

<script>

    import UserFormData from '../components/checkout/UserFormData';
    import CartRow from '../components/cart/CartRow';
    import Loading from '../components/Loading';
    import ErrorShow from '../components/ErrorShow';

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
				loading:false,
                total:0,

                cardNumber:"",
                paymentMethodId:"",
                issuer:"",
                doSubmit:false,
                token:"",
                description:"Fanshop payment",

                errors:[]
            }

        },
        components:{UserFormData, CartRow, Loading, ErrorShow},
        methods:{

            async fetch(){

				this.loading = true
				try{

					let res = await this.$axios.get("cart/fetch")
					this.products = res.data.products
					this.getTotal()

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

            guessPaymentMethod(event) {
    
                if (this.cardNumber.length >= 6) {
                    let bin = this.cardNumber.substring(0,6);
                    window.Mercadopago.getPaymentMethod({
                        "bin": bin
                    }, this.setPaymentMethod);
                }
            },

            setPaymentMethod(status, response) {

                if (status == 200) {
                    let paymentMethod = response[0];
                    this.paymentMethodId = paymentMethod.id;

                    this.getIssuers(paymentMethod.id);
                } else {
                    alert(`payment method info error: ${response}`);
                }
            },

            getIssuers(){

                 window.Mercadopago.getIssuers(
                    this.paymentMethodId,
                    this.setIssuers
                );

            },

            setIssuers(status, response) {
                if (status == 200) {
                    document.getElementById('issuer').innerHTML = ""
                    let issuerSelect = document.getElementById('issuer');
                    
                    response.forEach( issuer => {
                        let opt = document.createElement('option');
                        opt.text = issuer.name;
                        opt.value = issuer.id;
                        issuerSelect.appendChild(opt);
                    });

                    this.getInstallments()
                } else {
                    alert(`issuers method info error: ${response}`);
                }
            },

            getInstallments(){
                window.Mercadopago.getInstallments({
                    "payment_method_id": this.paymentMethodId,
                    "amount": Math.ceil(parseFloat(this.total)),
                    "issuer_id": parseInt(this.issuer)
                }, this.setInstallments);
            },

            setInstallments(status, response){
                if (status == 200) {
                    document.getElementById('installments').options.length = 0;
                    response[0].payer_costs.forEach( payerCost => {
                        let opt = document.createElement('option');
                        opt.text = payerCost.recommended_message;
                        opt.value = payerCost.installments;
                        document.getElementById('installments').appendChild(opt);
                    });
                } else {
                    alert(`installments method info error: ${response}`);
                }
            },
            getTotal(){

                this.total = 0;
				this.products.forEach(product => {
                  
					this.total = this.total + (parseFloat(product.amount * product.unit_price))
					
				})

                this.total = this.total * 3.63

            },

            getCardToken(){

                let $form = document.getElementById('paymentForm');

                if(this.checkFields()){
                    window.Mercadopago.createToken($form, this.setCardTokenAndPay);
                }

                
                
            },

            setCardTokenAndPay(status, response) {
                if (status == 200 || status == 201) {
                    let form = document.getElementById('paymentForm');
                    //let card = document.createElement('input');
                    //card.setAttribute('name', 'token');
                    //card.setAttribute('type', 'hidden');
                    //card.setAttribute('value', response.id);
                    //form.appendChild(card);
                    this.token = response.id
                    this.doSubmit = true
                    this.checkout()
                } else {
                    alert("Verify filled data!\n"+JSON.stringify(response, null, 4));
                }
            },


            async checkout(){
                this.loading = true
                let installments = document.getElementById("installments").value
                let docType = document.getElementById("docType").value
                let docNumber = document.getElementById("docNumber").value
                let res = await this.$axios.post("/checkout", {transactionAmount: Math.ceil(this.total), usdTotal: Math.ceil(this.total / 3.63), token: this.token, description: this.description, installments: installments, paymentMethodId: this.paymentMethodId, issuer: this.issuer, email: this.email, docType: docType, docNumber: docNumber, phone:this.phone, address:this.address})

                this.loading = false

                if(res.data.success == true){
                    this.$swal({
                        title:res.data.title,
                        text:res.data.msg,
                        icon:"success"
                    }).then(ans => {
                        localStorage.removeItem('firstLoad');
                        this.$router.push("/purchases")

                    })
                }else{

                     this.$swal({
                        title:res.data.title,
                        text:res.data.msg,
                        icon:"error"
                    }).then(ans => {
                        window.location.reload();
                    })

                }

            },

            checkFields(){

                let error = false
                if(this.email == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Email es requerido",
                    })
                    error = true
                }

                if(this.phone == "" || this.phone == null){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Teléfono es requerido",
                    })
                    error = true
                }

                if(this.address == "" || this.address == null){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Dirección es requerida",
                    })
                    error = true
                }

                if(document.getElementById("docType").value == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Tipo de documento es requerido",
                    })
                    error = true
                }

                if(document.getElementById("cardNumber").value == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Número de tarjeta es requerido",
                    })
                    error = true
                }

                if(document.getElementById("docNumber").value == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Número de documento es requerido",
                    })
                    error = true
                }

                if(document.getElementById("cardholderName").value == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Titular de la tarjeta es requerido",
                    })
                    error = true
                }

                if(document.getElementById("cardExpirationMonth").value == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Mes de expiración de la tarjeta es requerido",
                    })
                    error = true
                }

                if(document.getElementById("cardExpirationYear").value == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Año de expiración de la tarjeta es requerido",
                    })
                    error = true
                }

                if(document.getElementById("cardExpirationMonth").value < 0 || document.getElementById("cardExpirationMonth").value > 12){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Mes de expiración de la tarjeta no es válido",
                    })
                    error = true
                }
                /*let currentTime = new Date()
                if(document.getElementById("cardExpirationYear").value < currentTime.getFullYear().substring(1, 3)){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Mes de expiración de la tarjeta no es válido",
                    })
                    error = true
                }

                if(document.getElementById("cardNumber").value == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Número de la tarjeta es requerido",
                    })
                    error = true
                }

                if(document.getElementById("securityCode").value == ""){
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Código de seguridad de la tarjeta es requerido",
                    })
                    error = true
                }*/

                if(error == true){
                    return false
                }

                return true
            },

            isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();;
                } else {
                    return true;
                }
            }



        },
        created(){

            this.fetch()
            
        },
        mounted(){
            if (process.browser){
                
                if( !localStorage.getItem('firstLoad') )
                {
                    localStorage['firstLoad'] = true;
                    window.location.reload();
                }  
                else
                    localStorage.removeItem('firstLoad');

                let issuer = document.getElementById('issuer')
                if(issuer){
                    issuer.innerHTML = "";
                }
                window.Mercadopago.setPublishableKey("TEST-324cf059-b22d-478f-a5bc-1317c86d1505");
                window.Mercadopago.getIdentificationTypes();
            }
        }

    }
</script>