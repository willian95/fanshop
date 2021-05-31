<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination" v-if="isSearch == true">
            <li class="page-item" v-if="actualPage > 1"><a class="page-link cursor-pointer" @click="setPage(actualPage - 1)">Atrás</a></li>
            <li class="page-item"><a class="page-link cursor-pointer" @click="setPage(actualPage + 1)">Siguiente</a></li>
        </ul>
        <ul class="pagination" v-else>
            <li class="page-item" v-for="page in pages" v-bind:key="page"><a class="page-link cursor-pointer" @click="setPage(page)">{{ page }}</a></li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name:"Paginator",
        props:["pages", "setPage", "isSearch", "actualPage"]
    }
</script>

<style>
    .cursor-pointer{
        cursor: pointer;
    }
</style>