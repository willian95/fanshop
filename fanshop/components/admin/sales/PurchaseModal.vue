<template>

     <!-- Modal -->
    <div class="modal fade productsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Productos comprados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" v-bind:key="product.id">

                            <td><img style="max-width: 120px;" :src="product.product.image" alt=""></td>
                            <td>
                                <NuxtLink :to="{path: '/product', query: { id: product.product.productId, searchType: product.product.searchType }}" v-on:click.native="hideModal()">
                                    <p>{{ JSON.parse(product.product.object).productTitle.substring(0, 60) }}</p>
                                </NuxtLink>
                                <small v-if="product.amazon_cart_added_at != null">Añadido al carrito de amazon el día: {{ dateFormatter(product.amazon_cart_added_at) }}</small>
                            </td>
                            <td>USD {{ product.unit_price }}</td>
                            <td>{{ product.amount }}</td>
                        </tr>
                    </tbody>

                </table>

                <div class="container" v-if="purchaseDetails">
                    <div class="col-12">
                        <p class="text-left">Código: {{ purchaseDetails.zinc_api_code }}</p>
                    </div>
                    <div class="col-12">
                        <p class="text-left">Message: {{ purchaseDetails.zinc_api_message }}</p>
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
    export default {
        name:"PurchaseModal",
        props:["products", "selectedProducts", "toggleProducts", "checkTest", "dateFormatter", "purchaseDetails"],
    }
</script>