<template>
    
    <div class="container" id="register">
        <loading :loading="loading" />
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Registro</h3>
                        <form @submit.prevent="register()">
                            
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" v-model="name">
                                <ErrorShow :error="errors" :name="'name'" />
                            </div>

                            <div class="form-group">
                                <label for="lastname">Apellido</label>
                                <input type="lastname" class="form-control" v-model="lastname">
                                <ErrorShow :error="errors" :name="'lastname'"/>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" v-model="email">
                                <ErrorShow :error="errors" :name="'email'"/>
                            </div>

                            <div class="form-group">
                                <label for="password">Clave</label>
                                <div class="d-flex">
                                    <input :type="passwordInputType" class="form-control" v-model="password">
                                    <button class="btn btn-info" type="button" @click="passwordInputChange()">ver</button>
                                </div>
                                <ErrorShow :error="errors" :name="'password'"/>
                            </div>

                            <div class="form-group">
                                <label for="password">Repetir clave</label>
                                <div class="d-flex">
                                    <input :type="passwordConfirmationInputType" class="form-control" v-model="passwordConfirmation">
                                    <button class="btn btn-info" type="button" @click="passwordConfirmationInputChange()">ver</button>
                                </div>

                            </div>

                            <p class="text-center">
                                <button class="btn btn-primary" type="submit">Registrarme</button>
                            </p>

                            <p class="text-center">
                                <NuxtLink :to="{ path: '/login'}">¿Posees cuenta? Ingresa</NuxtLink>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import ErrorShow from '../components/ErrorShow';
    import Loading from '../components/Loading';

    export default {
        
        middleware:"auth",
        auth:"guest",
        name:"Register",
        components:{ErrorShow, Loading},
        data(){
            return{
                errors:[],
                name:"",
                lastname:"",
                email:"",
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
            async register(){

                this.errors = []
                this.loading = true
                try{

                    let res = await this.$axios.post("/register", {email: this.email, name: this.name, lastname: this.lastname, password: this.password, password_confirmation: this.passwordConfirmation})
                
                    if(res.data.success == true){

                        this.$swal({
                            icon: 'success',
                            text: res.data.msg,
                        }).then(res => {
                            this.clearInputs()
                            this.$router.push("login")
                        })

                    }else{
                        this.$swal({
                            icon: 'error',
                            text: res.data.msg,
                        })
                    }

                }catch(err){
    
                    this.$swal({
                        icon: 'error',
                        toast:true,
                        position:"top-end",
                        text: "Hay campos que debes revisar",
                    })
                    this.errors = err.response.data.errors

                }


                this.loading = false
            },
            clearInputs(){
                
                this.name = ""
                this.lastname = ""
                this.email = ""
                this.password = ""
                this.passwordConfirmation = ""

            }


        }

    }
</script>

<style>

    #register{
        margin-top: 150px;
    }


</style>