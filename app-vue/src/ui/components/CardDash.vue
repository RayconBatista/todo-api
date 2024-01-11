<template>
    <div :class="`p-4 bg-${color}-500 text-white`">
        <h2 class="text-xl font-semibold">{{ title }}</h2>
        <p class="text-3xl">{{ dataCount }}</p>
    </div>
</template>
<script>
export default {
    name: "CardDash",
    props: {
        title: {
            type: String,
            default: "Card",
        },
        color: {
            type: String,
            default: "blue",
        },
        dataCount: {
            type: Number,
            default: 0,
        },
    }
}
</script>