<template>
    
    <section class="container mt-150">

        <loading :loading="loading" />

        <div class="car">
            <div class="card-body">
                <div class="text-center" v-if="emailVerifiedAt == null">
                    <p>Aún no validas tu correo.</p>
                    <button class="btn btn-info" @click="resendEmail()">Reenviar</button>
                </div>
                <div class='title-general title-general2'>
                    <h1>Perfil</h1>
                </div>
                <div class=" row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input placeholder="Ingresa tu nombre" type="text" autocomplete="off" class="form-control" v-model="name">
                            <ErrorShow :error="errors" :name="'name'"/>

                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input placeholder="Ingresa tu email" disabled type="text" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                            <ErrorShow :error="errors" :name="'email'"/>

                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input placeholder="Ingresa tu número telefónico" type="tel" class="form-control  " id="password" v-model="phone">
                            <ErrorShow :error="errors" :name="'phone'"/>


                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellido</label>
                            <input placeholder="Ingresa tu apellido" type="text" autocomplete="off" class="form-control" v-model="lastname">
                            <ErrorShow :error="errors" :name="'lastname'"/>

                        </div>
                        <div class="form-group">

                            <label>Dirección</label>
                            <input placeholder="Ingresa tu dirección" type="text" class="form-control  " id="password" v-model="address">
                            <ErrorShow :error="errors" :name="'address'"/>

                        </div>

                        <div class="form-group">

                            <label>DNI</label>
                            <input placeholder="Ingresa tu dni" type="text" class="form-control  " id="password" v-model="dni">
                            <ErrorShow :error="errors" :name="'dni'"/>

                        </div>
    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contraseña</label>
                            <div class="d-flex">
                                
                                <input :type="passwordInputType" autocomplete="off" class="form-control" v-model="password">
                                <button class="btn btn-info" type="button" @click="passwordInputChange()">ver</button>
                            </div>
                            <ErrorShow :error="errors" :name="'password'"/>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Repertir contraseña</label>
                            <div class="d-flex">
                                
                                <input  :type="passwordConfirmationInputType" autocomplete="off" class="form-control" v-model="passwordConfirmation">
                                <button class="btn btn-info" type="button" @click="passwordConfirmationInputChange()">ver</button>
                            </div>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="update()">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary">Actualizar</button>

                        </div>
                    </div>

                </form>


            </div>
        </div>

    </section>

</template>

<script>

    import ErrorShow from '../components/ErrorShow';
    import Loading from '../components/Loading';

    export default {
        middleware:"auth",
        auth:"auth",
        name:"Profile",
        components:{ErrorShow, Loading},
        data(){

            return{
                errors:[],
                emailVerifiedAt:this.$auth.user.email_verified_at,
                name:this.$auth.user.name,
                lastname:this.$auth.user.lastname,
                address:this.$auth.user.address == "null" ? '': this.$auth.user.address,
                email:this.$auth.user.email,
                phone:this.$auth.user.phone == "null" ? '': this.$auth.user.phone,
                dni:this.$auth.user.rut,
                password:"",
                passwordConfirmation:"",
                 passwordInputType:"password",
                passwordConfirmationInputType:"password",
                loading:false
            }

        },
        methods:{

            passwordInputChange(){

                this.passwordInputType == 'password' ? this.passwordInputType = 'text' : this.passwordInputType = "password"

            },
            passwordConfirmationInputChange(){

                this.passwordConfirmationInputType == 'password' ? this.passwordConfirmationInputType = 'text' : this.passwordConfirmationInputType = "password"

            },
            async resendEmail(){

                this.loading = true
                let res = await this.$axios.post("resend-register-email")
                
                if(res.data.success == true){

                    this.$swal({
                        text: res.data.msg,
                        icon:"success"
                    })

                }else{

                    this.$swal({
                        text: res.data.msg,
                        icon:"error"
                    })

                }

                this.loading = false

            },
            async update(){

                this.errors = []
                this.loading = true

                let formData = new FormData()
                formData.append("name", this.name)
                formData.append("lastname", this.lastname)
                formData.append("address", this.address)
                formData.append("email", this.email)
                formData.append("phone", this.phone)
                formData.append("password", this.password)
                formData.append("password_confirmation", this.passwordConfirmation)
                formData.append("dni", this.dni)

                try{
                    let res = await this.$axios.post("/profile/update", formData)

                    if(res.data.success == true){

                        this.$swal({
                            text: res.data.msg,
                            icon:"success"
                        })

                    }else{

                        this.$swal({
                            text: res.data.msg,
                            icon:"error"
                        })

                    }

                }catch(err){

                    this.errors = err.response.data.errors

                }


                this.loading= false
            }

        }
    }
</script>