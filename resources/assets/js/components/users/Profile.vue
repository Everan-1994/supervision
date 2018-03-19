<template>
    <Card>
        <div style="min-height: 200px;">
            个人中心
        </div>
    </Card>
</template>

<script>

    export default {
        mounted() {
            this.$store.dispatch('setMenu', {'activeMenu': null, 'childMenu': null});
        },
    }

</script>
