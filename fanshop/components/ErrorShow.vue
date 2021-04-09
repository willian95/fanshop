<template>

    <div v-if="error">
        <small class="text-danger" v-if="error.hasOwnProperty(name)">{{ error[name][0] }}</small>
    </div>

</template>

<script>
    export default {
        name: 'ErrorShow',
        props: ['error', "name", ],
    }
</script>