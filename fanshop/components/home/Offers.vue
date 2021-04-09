<template>
  	<section class="producto" id="productos">
    	<div class="container">
      		<div class="title-general">
				<h1>Ofertas</h1>
      		</div>
			<div class="producto-carousel row">
				<div class="col-md-3">
					<ProductCard />
				</div>

				<div class="col-md-3">
					<ProductCard />
				</div>

				<div class="col-md-3">
					<ProductCard />
				</div>

				<div class="col-md-3">
					<ProductCard />
				</div>

				<div class="col-md-3">
					<ProductCard />
				</div>
			

			</div>
		</div>
	</section>
</template>

<script>

import ProductCard from '../ProductCard'

export default {
	name:"Offers",
	components:{ProductCard}

}
</script>
