<template>
    
    <tr>
        <td class="text-center w-150">
            <img
                class="img-product"
                :src="product.images[0]"
                alt=""
            />
        </td>
        <td>
            <p>{{ product.title.substring(0, 60) }}</p>
        </td>
        <td>$ {{ product.price }}</td>
        <td>{{ cart.amount }}</td>
        <td class="text-center"><span>$ {{ product.price * cart.amount }}</span></td>
        <td>

            <button v-if="showError" class="btn btn-danger" @click="erase(cart.id)">X</button>

        </td>
    </tr>

</template>

<script>
    export default {
        name:"CartRow",
        props:{product:Object, cart:Object, erase:Function, showError:true}      
    }
</script>