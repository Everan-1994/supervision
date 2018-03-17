<template>
    <Card>
        <div style="min-height: 200px;">
            <p>Content</p>
        </div>
    </Card>
</template>

<script>

    export default {
        mounted() {
            this.$store.dispatch('setMenu', 'index');
        }
    }

</script>
