<template>
    
    <div class="container" id="restore">
        <loading :loading="loading" />
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Restaurar clave</h3>
                        <form @submit.prevent="restore">
                            
                            <div class="form-group">
                                <label for="password">Clave</label>
                                <div class="d-flex">
                                    <input :type="passwordInputType" class="form-control" v-model="password">
                                    <button class="btn btn-info" type="button" @click="passwordInputChange()">ver</button>
                                </div>
                                <ErrorShow :error="errors" :name="'password'"/>
                                <ErrorShow :error="errors" :name="'hash'"/>
                            </div>

                            <div class="form-group">
                                <label for="password">Repetir clave</label>
                                <div class="d-flex">
                                    <input :type="passwordConfirmationInputType" class="form-control" v-model="passwordConfirmation">
                                    <button class="btn btn-info" type="button" @click="passwordConfirmationInputChange()">ver</button>
                                </div>
                            </div>


                            <p class="text-center">
                                <button class="btn btn-primary" type="submit">Restaurar</button>
                            </p>

                            <p class="text-center">
                                <NuxtLink :to="{ path: '/register'}">¿No posees cuenta? Registrate</NuxtLink>
                            </p>

                            <p class="text-center">
                                <NuxtLink :to="{ path: '/forgot-password'}">¿olvidaste tu contraseña?</NuxtLink>
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
        name:"PasswordRestore",
        components:{ErrorShow, Loading},
        data(){
            return{
                errors:[],
                password:"",
                passwordConfirmation:"",
                passwordInputType:"password",
                passwordConfirmationInputType:"password",
                hash:"",
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
            async restore(){

                this.loading = true
                this.errors = []
                
                try{

                    let res = await this.$axios.post("update-password", {password: this.password, hash: this.hash, password_confirmation: this.passwordConfirmation})
                    if(res.data.success == true){
                        this.$swal({
                            text: res.data.msg,
                            icon:"success"
                        }).then(res => {

                            this.$router.push("login")

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
            }

        },
        created(){

            this.hash = this.$route.query.hash

        }

    }
</script>

<style>

    #restore{
        margin-top: 150px;
    }


</style>