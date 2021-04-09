<template>
    
    <section class="container mt-150">

        <loading :loading="loading" />

        <div class="car">
            <div class="card-body">
                <div class='title-general title-general2'>
                    <h1>Perfil</h1>
                </div>
                <div class=" row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input placeholder="Nombre" type="text" autocomplete="off" class="form-control" v-model="name">
                            <ErrorShow :error="errors" :name="'name'"/>

                        </div>
                        <div class="form-group">

                            <input placeholder="Email" type="text" autocomplete="off" class="form-control" id="email" aria-describedby="emailHelp" v-model="email">
                            <ErrorShow :error="errors" :name="'email'"/>

                        </div>
                        <div class="form-group">
                            <input placeholder="Telefono" type="tel" class="form-control  " id="password" v-model="phone">
                            <ErrorShow :error="errors" :name="'phone'"/>


                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input placeholder="Apellido" type="text" autocomplete="off" class="form-control" v-model="lastname">
                            <ErrorShow :error="errors" :name="'lastname'"/>

                        </div>
                        <div class="form-group">


                            <input placeholder="Dirección" type="text" class="form-control  " id="password" v-model="address">
                            <ErrorShow :error="errors" :name="'address'"/>

                        </div>
    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-flex">
                                <input placeholder="Contraseña" :type="passwordInputType" autocomplete="off" class="form-control" v-model="password">
                                <button class="btn btn-info" type="button" @click="passwordInputChange()">ver</button>
                            </div>
                            <ErrorShow :error="errors" :name="'password'"/>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="d-flex">
                                <input placeholder="Repetir contraseña" :type="passwordConfirmationInputType" autocomplete="off" class="form-control" v-model="passwordConfirmation">
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
                name:this.$auth.user.name,
                lastname:this.$auth.user.lastname,
                address:this.$auth.user.address == "null" ? '': this.$auth.user.address,
                email:this.$auth.user.email,
                phone:this.$auth.user.phone == "null" ? '': this.$auth.user.phone,
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

                try{
                    let res = await this.$axios.post("/profile/update", formData)
                }catch(err){

                    this.errors = err.response.data.errors

                }


                this.loading= false
            }

        }
    }
</script>