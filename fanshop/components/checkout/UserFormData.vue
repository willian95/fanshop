<template>
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

                <input type="text" class="form-control" id="inputEmail4" placeholder="phone" v-model="phone" readonly>

            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <input type="text" class="form-control" id="inputEmail4" placeholder="Dirección" v-model="address" readonly>
            </div>

        </div>

    </div>
</template>

<script>
    export default {
        name:"UserFormData",
        props:{name:String, lastname:String, email:String, phone:String, address:String}

    }
</script>