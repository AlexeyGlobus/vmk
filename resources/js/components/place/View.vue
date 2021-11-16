<template>
	<h1>{{ $route.params.name }}</h1>
</template>

<script>
	    export default {
        name: "PlaceView",
        props: ['name'],
        place: {},
        errors: [],
        mounted() {
            axios
              .get('/places/' + this.$route.params.name )
              .then(response => {
                if (response.status >= 200 && response.status < 300) {
                        return response;
                    } else {
                        let error = new Error(response.statusText);
                        error.response = response;
                        throw error
                    }
                }).then(response => {
                    if (response.headers['content-type'] !== 'application/json') {
                        let error = new Error('Некорректный ответ от сервера');
                        error.response = response;
                        throw error
                    }
                    return response.data;
                }).then(json => {
                    if (typeof json.place === 'object') {
                        this.place = json.place;
                    }
                }).catch(error => {
                     if (typeof error.message !== 'undefined') {
                        this.errors.push(this.$t(error.message));
                     }
                });
        },
        computed: {
        }
    }
</script>