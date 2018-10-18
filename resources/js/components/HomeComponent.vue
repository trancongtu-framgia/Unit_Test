<template>
    <div>hello user</div>
</template>

<script type="text/javascript">
    export default {
        name: 'home',
        mounted() {
            this.$store.dispatch('getUser')
        }
    }
</script>
