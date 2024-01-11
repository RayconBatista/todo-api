<template>
    <div class="p-4">
        <canvas ref="canvasRef"></canvas>
    </div>
</template>

<script>
import { onMounted, ref, watch } from 'vue';
import Chart from 'chart.js/auto';

export default {
    name: "PieChart",
    props: {
        data: {
            type: Object,
            default: null
        },
        title: {
            type: String,
            default: 'Gráfico de Pizza',
        },
    },
    setup(props) {
        const canvasRef = ref(null);
        let chart = null;

        const updateChart = async () => {
            if (chart) {
                chart.destroy();
            }

            const ctx = canvasRef.value.getContext('2d');
            let data = {
                datasets: [{
                    data: props.data ? props.data.values : [], // Use props.data para obter os valores
                    backgroundColor: props.data ? props.data.colors.map(color => `${color}80`) : [] // Use props.data para obter as cores
                }],
                labels: props.data ? props.data.labels : [] // Use props.data para obter os rótulos
            };

            chart = new Chart(ctx, {
                data,
                type: 'pie',
                options: getDefaultOptions(),
            });
        };

        const getDefaultOptions = () => ({
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: props.title,
                    color: "#ffffff"
                },
                labels: {
                    render: 'percentage',
                    precision: 2
                }
            }
        });

        onMounted(updateChart);

        watch(() => props.data, updateChart);

        return {
            canvasRef
        };
    }
};
</script>