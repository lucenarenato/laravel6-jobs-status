<template>
    <div class="container">
        <highcharts :options="chartOptions"/>
    </div>
</template>

<script>
    import {Chart} from 'highcharts-vue'
    export default {
        props: [
            'series'
        ],

        components: {
            highcharts: Chart
        },

        data() {
            return {
                chartOptions: {
                    noData: 'There is no data to display',
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: ''
                    },
                    yAxis: {
                        ceiling: 100,
                        floor: 0,
                        title: {
                            text: 'Users who have been or are still in this step'
                        }
                    },
                    xAxis: {
                        ceiling: 100,
                        floor: 0,
                        title: {
                            text: 'Onboarding percentage'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top'
                    },
                    plotOptions: {
                        series: {
                            pointStart: 0
                        },
                        spline: {
                            lineWidth: 4,
                            states: {
                                hover: {
                                    lineWidth: 5
                                }
                            },
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    series: this.series
                }
            }
        }
    }
</script>
