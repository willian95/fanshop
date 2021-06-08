<template>

    <div>
        <NuxtLink class="card-producto" :to="{path:`/product/${id}`, query: { searchType: searchType }}" v-if="searchType == 'amazon'">
            <div class="card-content">
                <div class="card-producto-img">	
                    <p class="btn-custom" >Ver producto</p>
                    <img v-if="searchType == 'amazon'" :src="image" class="card-content-img" alt="">
                </div>
                <div class="card-producto-content">
                    <h4 class="title-producto" v-if="searchType == 'amazon'">{{ title.substring(0, 40) }}</h4>

                    <span v-if="searchType == 'amazon'" class="price">S/ {{ ((price + (price * earnPercentage))*dolarPrice).toFixed(2) }}</span>
                </div>
            </div>
        </NuxtLink>
        <NuxtLink class="card-producto" :to="{ path: `/product-walmart/${walmartId}`, query: { searchType: searchType, usItemId:walmartUsItemId }}" v-if="searchType == 'walmart'">
            <div class="card-content">
                <div class="card-producto-img">	
                    <p class="btn-custom" >Ver producto</p>
                    <img v-if="searchType == 'walmart'" :src="walmartImage" class="card-content-img" alt="">
                </div>
                <div class="card-producto-content">
                    <h4 class="title-producto" v-if="searchType == 'walmart'" v-html="walmartTitle"></h4>

                    <span v-if="searchType == 'walmart'" class="price">S/ {{ ((walmartPrice + (walmartPrice * earnPercentage))*dolarPrice).toFixed(2) }}</span>
                </div>
            </div>
        </NuxtLink>

    </div>
</template>

<script>
export default {
    name:"ProductCard",
    props:{'image':String, 'title':String, 'price':[String, Number], 'id':String, 'searchType':String, 'dolarPrice':Number, 'earnPercentage':Number, 'walmartTitle':String, 'walmartImage':String, 'walmartPrice':[String, Number], "walmartId":String, "walmartUsItemId":String}

}
</script>