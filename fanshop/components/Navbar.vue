<template>
    <header>
			  <div class="header">
      <div class="">
        <header>
					<div class="row">
						<div class="col-md-12">
							<div class="logo">
								<NuxtLink class="navbar-brand" :to="{ path: '/' }">
								<img src="/img/logo-fanshop.png" alt="" />
							</NuxtLink>
					
							<form class="position-relative formulario-style ml7 mr-auto">
								<input class="form-control mr-sm-2 buscador" type="search" placeholder="Buscar cualquier articulo.." aria-label="Search" v-model="query">
								<div class="btn-search">
									<!--<button type="button">
										<img class="icon-buscador" src="/img/search.png" alt="" />
										Buscar
									</button>-->
									<button type="button" @click="querySearch('amazon')">
										<img class="icon-buscador" src="/img/search.png" alt="" />
										<img class="icon-logo" src="/img/Amazon_logo.png" alt="" />
									</button>
									<button type="button" @click="querySearch('walmart')">
										<img class="icon-buscador" src="/img/search.png" alt="" />
										<img class="icon-logo icon-logo_wal" src="/img/walmart_logo.png" alt="" />
									</button>
								</div>
							</form>
							<li class="nav-item mr-5 pr-3">
						<NuxtLink :to="{ path: '/cart' }"><img style="width: 20px" src="/img/shopping-cart.svg" alt=""></NuxtLink>
					</li>
						<li class="nav-item mr-5" v-if="isAuthenticated">
								<NuxtLink :to="{ path: '/profile'}">{{ $auth.user.name }}</NuxtLink>
							</li>
							<li class="nav-item mr-5" v-if="isAuthenticated && $auth.user.role_id == 2">
								<NuxtLink  :to="{ path: '/purchases'}">Compras</NuxtLink>
							</li>

					
							</div>
						</div>
							<div class="col-md-12">
							 <input type="checkbox" id="nav-toggle" class="nav-toggle" />
          <nav>
            <ul class="nav">
								<li class="nav-item active">
								<NuxtLink class="nav-link" :to="{ path: '/'}">Inicio</NuxtLink>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-scroll="" href="busqueda.html">Ofertas</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-scroll="" href="compras.html">Quienes somos</a>
							</li>
							<li class="nav-item mr-5">
								<a class="nav-link" data-scroll="" href="#team-about">contacto</a>
							</li>
							
							<li class="nav-item mr-5" v-if="isAuthenticated && $auth.user.role_id == 1">
								<NuxtLink :to="{ path: '/admin/dashboard'}">Admin panel</NuxtLink>
							</li>
							<li class="nav-item mr-5" v-if="isAuthenticated">
								<button class="btn btn-info btn-logot" @click="logout()"><i class="fa fa-sign-out" aria-hidden="true"></i>
Cerrar sesión</button>
							</li>
							<li class="nav-item p-nones" v-if="!isAuthenticated">
								<NuxtLink :to="{ path: '/register'}" class="nav-link"><i class="fas fa-user fas-icon icon-sesion"></i><p>Registrar</p></NuxtLink>
							</li>
							<li class="nav-item mr-5  p-nones" v-if="!isAuthenticated">
								<NuxtLink :to="{ path: '/login'}" class="nav-link" data-scroll=""><i class="fa fa-sign-in fas-icon icon-sesion"></i><p>Entrar</p></NuxtLink>
							</li>
            </ul>
					
          </nav>
          <label for="nav-toggle" title="Show navbar" class="nav-toggle-label">
            <span></span>
          </label>
						</div>
					</div>
      
         
					
        </header>
			
      </div>
    </div>
	
	</header>
</template>

<script>

	import { mapGetters } from 'vuex'

    export default {
		middleware: 'auth',
        name:"Navbar",
		data(){
			return{
				query:"",
				page:1
			}
		},
		computed: {
			...mapGetters(['isAuthenticated', 'loggedInUser'])
		},
		methods:{

			async querySearch(type){

				let query = this.query
				let page = 1
				
				this.$store.dispatch("storeSearch", {type, query, page})
				this.$store.dispatch("storeSearchClicked", {value:true})

				this.$router.push({path: "/search"});

			},
			async logout(){
				await this.$auth.logout()
				this.$auth.redirect('home')
			}

		}
    }
</script>