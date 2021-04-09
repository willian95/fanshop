<template>
    
    <div class="container" id="login">
        <loading :loading="loading" />
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Login</h3>
                        <form @submit.prevent="login">
                            
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


                            <p class="text-center">
                                <button class="btn btn-primary" type="submit">Ingresar</button>
                            </p>

                            <p class="text-center">
                                <NuxtLink :to="{ path: '/register'}">¿No posees cuenta? Registrate</NuxtLink>
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
        
        middleware: 'auth',
        auth: 'guest',
        name:"Login",
        components:{ErrorShow, Loading},
        data(){
            return{
                errors:[],
                name:"",
                email:"",
                password:"",
                passwordInputType:"password",
                loading:false,
            }
        },
        methods:{

            passwordInputChange(){
                
                this.passwordInputType == 'password' ? this.passwordInputType = 'text' : this.passwordInputType = "password"

            },
            async login(){

                this.errors = []
                this.loading = true
                try{

                    let res = await this.$auth.loginWith('local', {
                                                        data:{
                                                            email:this.email,
                                                            password:this.password
                                                        }
                                                    })

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
            }


        }

    }
</script>

<style>

    #login{
        margin-top: 150px;
    }


</style>