<template>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                Showing all records
            </div>
            <div class="card-body">
                <div v-if="loading" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <table v-else class="table">
                    <thead class="table-light">
                    <tr>
                        <th>Place</th>
                        <th>Location</th>
                        <th>Available Bikes (qty)</th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr v-if="stations.length > 0" v-for="station in stations" :key="station.id">
                            <td>{{ station.name }}</td>
                            <td>{{ station.network.city }} - {{ station.network.country }}</td>
                            <td>{{ station.free_bikes }}</td>
                        </tr>
                        <tr v-else>
                            <td colspan="3">There is no station available in the system.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AvailableBikes',
    props: {
        stations: Array,
        loading: {
            type: Boolean,
            default: true,
        }
    }
}
</script>

