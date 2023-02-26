<template>
    <div>
        <portal to="title">
            <page-title icon="layer-group">ExampleAddon</page-title>
        </portal>
    </div>
</template>

<script>
export default {
    head: {
        title() {
            return {
                inner: 'ExampleAddon'
            }
        }
    },

    data() {
        return {
        }
    },

    computed: {
    },

    methods: {
    },

    // beforeRouteEnter(to, from, next) {
    //     next((vm) => {
    //     })
    // },

    // beforeRouteUpdate(to, from, next) {
    //     next()
    // }
}
</script>

<style>

</style>