<template>
    <div>
        <search v-on:stations-filtered="updateStations" v-on:loading="loading = $event"></search>
        <available-bikes :stations="stations" :loading="loading"></available-bikes>
    </div>
</template>

<script>
import AvailableBikes from "../components/AvailableBikes";
import Search from "../components/Search";
import axios from "axios";
export default {
    name: "Index",
    components: {
        AvailableBikes,
        Search
    },
    data() {
        return {
            stations: [],
            loading: true,
        }
    },
    methods: {
        updateStations(stations) {
            this.stations = stations;
        }
    },
    beforeMount: function () {
        axios.get('/api/networks/BR')
            .then((res) => {
                this.stations = res.data.stations;
                this.loading = false;
            })
            .catch((err) => {
                console.log(err);
            });
    }
}
</script>
