<template>

    <div>
        <div class="loader-cover-custom" v-show="loading == true">
			<div class="loader-custom"></div>
		</div>

    </div>

</template>

<script>
export default {
    name:"Loading",
    props:["loading"]
}
</script>

<style>

    .loader-cover-custom{
        position: fixed;
        left:0;
        right: 0;
        z-index: 99999999;
        background-color: rgba(0, 0, 0, 0.6);
        top: 0;
        bottom: 0;
    }

    .loader-custom {
        margin-top:45vh;
        margin-left: 45%;
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>