<template>
    <header>
		<nav class="navbar navbar-expand-md navbar-fixed-js" id="home-serviteca" style="box-shadow: 0px 0px 12px #0000002e;">
			<div class="col-md-12">
				<div class="container-fluid menu-principal">
					<a class="navbar-brand" href="#">
						<img src="/img/logo-fanshop.png" alt="" />
					</a>
					<!-----------------serarch--------------------->
					<form class="position-relative formulario-style">
						<input class="form-control mr-sm-2 buscador" type="search" placeholder="Buscar cualquier articulo.." aria-label="Search" v-model="query">
						<div class="btn-search">
							<button type="button">
								<img class="icon-buscador" src="/img/search.png" alt="" />
								Buscar
							</button>
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
					<!-----------------serarch--------------------->
					<li class="nav-item">
						<NuxtLink :to="{ path: '/cart' }"><img style="width: 20px" src="/img/shopping-cart.svg" alt=""></NuxtLink>
					</li>
				</div>
				<div class="col-md-12">
					<button class="navbar-toggler p-2 border-0 hamburger hamburger--elastic d-none-lg" data-toggle="offcanvas" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
					<div class="offcanvas-collapse fil" id="navbarNav">
						<ul class="navbar-nav">
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
							<li class="nav-item mr-5" v-if="isAuthenticated">
								<NuxtLink :to="{ path: '/profile'}">{{ $auth.user.name }}</NuxtLink>

							</li>
							<li class="nav-item mr-5" v-if="isAuthenticated">
								<button class="btn btn-info" @click="logout()">Cerrar sesión</button>

							</li>
							<li class="nav-item" v-if="!isAuthenticated">
								<NuxtLink :to="{ path: '/register'}" class="nav-link"><i class="fas fa-user fas-icon icon-sesion"></i>Registrar</NuxtLink>
							</li>
							<li class="nav-item mr-5" v-if="!isAuthenticated">
								<NuxtLink :to="{ path: '/login'}" class="nav-link" data-scroll=""><i class="fa fa-sign-in fas-icon icon-sesion"></i>Entrar</NuxtLink>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
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