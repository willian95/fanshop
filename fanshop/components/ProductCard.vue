<template>
    <NuxtLink class="card-producto" :to="{ path: '/product', query: { id: id, searchType: searchType }}">
        <div class="card-content">
            <div class="card-producto-img">	
                <p class="btn-custom" >Añadir al carrito</p>
                <img :src="image" class="card-content-img" alt="">
            </div>
            <div class="card-producto-content">
                <h4 class="title-producto">{{ title.substring(0, 40) }}</h4>
                <span class="price">S. {{ ((price + (price * earnPercentage))*dolarPrice).toFixed(2) }}</span>
            </div>
        </div>
    </NuxtLink>
</template>

<script>
export default {
    name:"ProductCard",
    props:{'image':String, 'title':String, 'price':[String, Number], 'id':String, 'searchType':String, 'dolarPrice':Number, 'earnPercentage':Number}

}
</script>