<template>
    <div >
            <pie-chart :chart-data="data" :height="80"  :options="{responsive: true, maintainAspectRatio: true}" />
    </div>
</template>

<script>
    import PieChart from '../../helpers/PieChart';
    import { get } from '../../helpers/api';
    export default {
        name: "AppChart",
        data () {
            return  {
                    data: []
            }
        },
        components: {
            PieChart
        },
        mounted() {

            this.update();
        },

        methods: {
            update() {
                get('/api/chart').then((res=>{
                    if (res.data.status){

                        this.data=res.data;
                    }

                }))

            }
        }
    }
</script>

<style scoped>

</style>
