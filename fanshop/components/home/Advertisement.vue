<template>
    <section class="container seccion-info">
	
		<div class="row">
			<div class="col-md-6">
				<div class="seccion-info_item  " style="background-image:url('img/woman.png')">
					<div>
						<span>Crea una cuenta</span>
					<p>¡Facil y sencillo!</p>
					<a class="btn-custom" href="#">Registrate</a>
					<img src="/img/logo.png" alt="">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="seccion-info_item seccion-info_item-2" style="background-image:url('img/man.png');background-position: -8px 11px;">
					<div>
						<p>Envios directos de </p>
						<p>EUA a Perú</p>
					<img class="seg-btn" src="img/destination.png" alt="">
					<a data-toggle="modal" data-target=".modal-track" class="btn-custom" href="#">Ver seguimiento</a>
					</div>
				</div>
			
			</div>
		</div>
	</section>
</template>

<script>
export default {
    name:"Advertisement"
}
</script>