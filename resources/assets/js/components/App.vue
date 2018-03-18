<template>
    <div>
        <div class="layout">
            <Layout>
                <Header class="header" :style="{position: 'fixed', width: '100%', 'z-index': '999'}"></Header>
                <Content :style="{padding: '80px 35px 30px', 'background-color': '#FFFFFF'}">
                    <router-view></router-view>
                </Content>
            </Layout>
        </div>
        <BackTop></BackTop>
    </div>
</template>

<script>
    import Header from './common/Header';

    export default {
        components: {
            Header
        }
    }
</script>
