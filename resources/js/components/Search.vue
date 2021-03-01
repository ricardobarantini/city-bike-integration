<template>
    <div class="container">
        <form class="d-flex mt-3" v-on:submit.prevent>
            <input class="form-control me-2" type="search" placeholder="Name or Location" aria-label="Search" v-model="search">
            <button class="btn btn-secondary" type="submit" v-on:click="filterByNameOrLocation">Search</button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'Search',
    data() {
        return {
            search: '',
        }
    },
    methods: {
        filterByNameOrLocation() {
            this.$emit('loading', true);
            axios.get(`/api/networks/${this.search}`)
                .then((res) => {
                    this.$emit('stations-filtered', res.data.stations);
                    this.$emit('loading', false);
                })
                .catch((err) => {
                    //
                });
        }
    }
}
</script>
