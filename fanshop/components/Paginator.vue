<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item" v-for="page in pages" v-bind:key="page"><a class="page-link cursor-pointer" @click="setPage(page)">{{ page }}</a></li>
            <li class="page-item"><a class="page-link cursor-pointer" @click="setPage(page + 1)" >{{ pages + 1 }}</a></li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name:"Paginator",
        props:["pages", "setPage"]
    }
</script>

<style>
    .cursor-pointer{
        cursor: pointer;
    }
</style>