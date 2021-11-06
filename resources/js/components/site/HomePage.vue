<template>
	<h1 v-if="$auth.check()">GLOBUS-1 {{ name }}</h1>	
</template>

<script>
	    export default {
        data: function () {
            return {
                name: 'Vue'
            }
        },
        mounted() {
            console.log(this.$auth.check())
            console.log(this.$auth.user())
        }
    }
</script>