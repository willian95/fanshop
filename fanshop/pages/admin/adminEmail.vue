<template>
    
    <div class="d-flex flex-column-fluid" id="dev-appliance-list">

        <!-- Modal -->
        <div class="modal fade adminEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Añadir email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="container">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" class="form-control" v-model="email">
                                        <ErrorShow :error="errors" :name="'email'"/>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cerrar</button>
                        <button class="btn btn-primary" v-if="action == 'create'" @click="store()">Añadir</button>
                        <button class="btn btn-primary" v-if="action == 'edit'" @click="update()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Emails administrativos</h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Dropdown-->
                        <button class="btn btn-primary" @click="create()" data-toggle="modal" data-target=".adminEmailModal" >Añadir correo</button>
                        <!--end::Dropdown-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin: Datatable-->

                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style="">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Email</td>
                                    <td>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="adminEmailAccount in adminEmailAccounts" v-bind:key="adminEmailAccount.id">
                                    <td>{{ adminEmailAccount.email }}</td>
                                    <td>
                                        <button class="btn btn-info" @click="edit(adminEmailAccount)" data-toggle="modal" data-target=".adminEmailModal">editar</button> 
                                        <button class="btn btn-secondary" @click="remove(adminEmailAccount.id)">eliminar</button>    
                                    </td>    
                                
                                </tr>
                            </tbody>
                        </table>
                    
                    </div>
                    <!--end: Datatable-->
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
    import ErrorShow from '../../components/ErrorShow';

    export default {
        layout: 'admin/admin',
        middleware:["auth", "admin"],
        auth:"auth",
        components:{Loading, ErrorShow},
        data(){
			return{
                id:"",
                errors:[],
                action:"create",
                email:"",
				adminEmailAccounts:[],
                page:1,
                pages:1,
				loading:false
			}
		},
        methods:{

            create(){
                this.action = "create"
                this.email = ""
                this.id = ""
            },
            edit(adminEmailAccount){
                this.id = adminEmailAccount.id
                this.action = "edit"
                this.email = adminEmailAccount.email
            },
			async fetch(){
				this.loading = true

				let res = await this.$axios.get("admin/email-account/fetch")
				this.adminEmailAccounts = res.data.adminEmailAccounts
				this.loading = false
				
			},
            hideModal(){
               
                $('.adminEmailModal').modal('hide')
                $('.modal-backdrop').remove()       
            },
            async store(){
                this.errors = []
                try{

                    this.loading = true
                    let res = await this.$axios.post("admin/email-account/store", {email: this.email})

                    this.loading = false

                    if(res.data.success == true){

                        this.$swal({
                            text:res.data.msg,
                            icon:"success"
                        }).then(ans => {

                            this.email = ""
                            this.action = "create"
                            this.hideModal()
                            this.fetch()

                        })

                    }else{

                        this.$swal({
                            text:res.data.msg,
                            icon:"error"
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

            },
            async update(){
                this.errors = []
                try{

                    this.loading = true
                    let res = await this.$axios.post("admin/email-account/update", {email: this.email, id: this.id})

                    this.loading = false

                    if(res.data.success == true){

                        this.$swal({
                            text:res.data.msg,
                            icon:"success"
                        }).then(ans => {

                            this.email = ""
                            this.action = "create"
                            this.id  =""
                            this.hideModal()
                            this.fetch()

                        })

                    }else{

                        this.$swal({
                            text:res.data.msg,
                            icon:"error"
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

            },
            async remove(id){

                this.loading = true
                let res = await this.$axios.post("admin/email-account/delete", {id: id})

                this.loading = false

                if(res.data.success == true){

                    this.$swal({
                        text:res.data.msg,
                        icon:"success"
                    }).then(ans => {

                        this.email = ""
                        this.action = "create"
                        this.id  =""
                        this.fetch()

                    })

                }else{

                    this.$swal({
                        text:res.data.msg,
                        icon:"error"
                    })

                }

            },
            setPage(page){

                this.fetch(page)

            }

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