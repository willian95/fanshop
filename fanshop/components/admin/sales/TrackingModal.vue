<template>

     <!-- Modal -->
    <div class="modal fade trackingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tracking">N° tracking</label>
                                <input type="text" class="form-control" v-model="tracking" id="tracking">
                                <ErrorShow :error="errors" :name="'tracking'" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url">Url</label>
                                <input type="text" class="form-control" v-model="url" id="url">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary" @click="store()">Añadir</button>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tracking</th>
                                        <th>Url</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="tracking in trackings" v-bind:key="tracking.id">
                                        <td>
                                            {{ tracking.tracking }}
                                        </td>
                                        <td>
                                            {{ tracking.url }}
                                        </td>
                                        <td>
                                            <button class="btn btn-secondary" @click="confirmModal(tracking.id)" >Eliminar</button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                
                <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cerrar</button>
            </div>
            </div>
        </div>
    </div>


</template>

<script>

    import ErrorShow from '../../ErrorShow';

    export default {
        name:"TrackingModal",
        props:["purchaseId"],
        components:[ErrorShow],
        data(){
            return{
                tracking:"",
                url:"",
                trackings:[],
                errors:[]
            }
        },
        computed: {
            getTrackings () {
                return this.purchaseId
                // Or return basket.getters.fruitsCount
                // (depends on your design decisions).
            }
        },
        watch: {
            getTrackings (newValue, oldValue) {
                // Our fancy notification (2).
                if(newValue != oldValue){
                    this.fetchTracking()
                }
            }
        },
        methods:{

            async store(){

                this.errors = []
                try{

                    let res = await this.$axios.post("/admin/tracking/store", {tracking: this.tracking, url: this.url, purchaseId: this.purchaseId})
                    if(res.data.success == true){

                        this.$swal({
                            text:res.data.msg,
                            icon:"success"
                        }).then(ans => {

                            this.tracking = ""
                            this.url = ""

                            this.fetchTracking()

                        })

                    }else{
                        this.$swal({
                            text:res.data.msg,
                            icon:"error"
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

            },
            async fetchTracking(){

                let res = await this.$axios.get("admin/tracking/fetch/"+this.purchaseId)
                this.trackings = res.data.trackings

            },

            confirmModal(id){

                this.$swal({
                    text:"¿Deseas eliminar éste tracking?",
                    icon:"warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, lo eliminaré!',
                    cancelButtonText:'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.removeTracking(id)
                    }
                })

                

            },

            async removeTracking(id){

                let res = await this.$axios.post("admin/tracking/delete", {id: id})
                if(res.data.success == true){

                    this.$swal({
                        text:res.data.msg,
                        icon:"success"
                    }).then(ans => {

                        this.tracking = ""
                        this.url = ""

                        this.fetchTracking()

                    })

                }else{
                    this.$swal({
                        text:res.data.msg,
                        icon:"error"
                    })
                }

            }

        }
    }
</script>