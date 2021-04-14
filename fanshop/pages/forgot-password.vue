<template>
    
    <div id="restore">

        <loading :loading="loading" />
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        
                        <form @submit.prevent="restorePassword">
                            
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" v-model="email">
                                <ErrorShow :error="errors" :name="'email'"/>
                            </div>

                            <p class="text-center">
                                <button class="btn btn-primary" type="submit">Recuperar contraseña</button>
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
        name:"ForgotPassword",
        components:{ErrorShow, Loading},
        data(){
            return{
                errors:[],
                email:"",
                loading:false,
            }
        },
        methods:{

            async restorePassword(){

                this.errors = []
                this.loading = true
                try{

                    let res = await this.$axios.post("restore-password", {email: this.email})
                   
                    if(res.data.success == true){

                        this.$swal({
                            "text": res.data.msg,
                            "icon": "success"
                        }).then(res => {

                            this.$router.push("login")

                        })

                    }else{

                        this.$swal({
                            "text": res.data.msg,
                            "icon": "error"
                        })

                    }

                }catch(err){

                    console.log(err)

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

    #restore{
        margin-top: 150px;
    }


</style>