<template>
    
    <tr>
        
        <td class="text-center" v-if="cart.product.searchType == 'amazon'">
            <img
                class="img-product"
                :src="product.imageUrlList[0]"
                alt=""
            />
        </td>

        <td class="text-center" v-if="cart.product.searchType == 'walmart'">
            <img
                class="img-product"
                :src="cart.product.image"
                alt=""
            />
        </td>


        <td v-if="cart.product.searchType == 'amazon'">
            <NuxtLink :to="{path: '/product/'+cart.product.productId, query: {searchType: cart.product.searchType }}">
                <p>{{ product.productTitle.substring(0, 60) }}</p>
            </NuxtLink>
            <span v-if="cart.destination_payment == 1">*Producto con pago a destino</span>
        </td>

        <td v-if="cart.product.searchType == 'walmart'">
            <NuxtLink :to="{path: '/product/'+cart.product.productId, query: {searchType: cart.product.searchType }}">
                <p>{{ product.productInfo.productTitle.substring(0, 60) }}</p>
            </NuxtLink>
            <span v-if="cart.destination_payment == 1">*Producto con pago a destino</span>
        </td>

        <td>{{ cart.product.searchType }}</td>
        <td>S. {{ (cart.unit_price * dolarPrice).toFixed(2) }}</td>
        <td> <!--<button class="btn btn-info" @click="updateAmount(cart.id,'add')"> + </button>--> {{ cart.amount }} <span v-if="showUpdateAmount == true"><button @click="updateAmount(cart.id,'substract')" v-if="cart.amount - 1 >= cart.product.minimun_quantity" class="btn btn-info"> - </button></span></td>
        <td class="text-center"><span>S. {{ (cart.unit_price * dolarPrice * cart.amount).toFixed(2) }}</span></td>
        <td>

            <button v-if="showErase" class="btn btn-danger" @click="erase(cart.id)">X</button>

        </td>
    </tr>

</template>

<script>
    export default {
        name:"CartRow",
        props:{product:Object, cart:Object, erase:Function, showErase:true, updateAmount:Function, showUpdateAmount:Boolean, dolarPrice:Number, searchType:String}      
    }
</script>

<style>
    .img-product{
        width: 100%;
    }
</style>