<template>
    <div>
    	<h1 v-if="$auth.check()">GLOBUS-1 {{ name }}</h1>	
        <h2 v-if="$auth.check()">{{ placesCount }}</h2>
    </div>   
</template>

<script>
    export default {
        data: function () {
            return {
                name: 'Vue',
                places: [],
                errors: []
            }
        },
        mounted() {
            axios
              .get('/places')
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
                    if (typeof json.places === 'object') {
                        this.places = json.places;
                        console.log(this.places)
                    }
                }).catch(error => {
                     console.log(typeof error);
                     if (typeof error.message !== 'undefined') {
                        this.errors.push(this.$t(error.message));
                     }
                     console.log(this.errors);
            });
        },
        computed: {
            placesCount() {
                return this.places.length;
            }
        }
    }
</script>