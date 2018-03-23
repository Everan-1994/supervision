<template>
    <div style="min-height: 200px;">
        <Content :style="{padding: '24px 0', minHeight: '280px', background: '#fff'}">
            <Layout>
                <Sider hide-trigger :style="{background: '#fff'}">
                    <Menu :active-name="menu.childMenu" @on-select="menus" theme="light" width="auto" :open-names="['plans']">
                        <Submenu name="plans">
                            <template slot="title">
                                <Icon type="folder"></Icon>
                                授课计划管理
                            </template>
                            <router-link :to="{name: 'write_plan'}">
                                <MenuItem name="write_plan">
                                    <Icon type="compose"></Icon>
                                    填写授课计划
                                </MenuItem>
                            </router-link>
                            <router-link :to="{name: 'plans'}">
                                <MenuItem name="plans">
                                    <Icon type="ios-bookmarks-outline"></Icon>
                                    我的授课计划
                                </MenuItem>
                            </router-link>
                            <router-link :to="{name: 'review_plans'}">
                                <MenuItem name="review_plans">
                                    <Icon type="clipboard"></Icon>
                                    审核审核计划
                                </MenuItem>
                            </router-link>
                        </Submenu>
                    </Menu>
                </Sider>
                <Content :style="{padding: '24px', minHeight: '325px', background: '#fff'}">
                    <transition name="fade" mode="out-in">
                        <router-view></router-view>
                    </transition>
                </Content>
            </Layout>
        </Content>
    </div>
</template>
<script>
    import {mapState} from 'vuex';

    export default {
        computed: {
            ...mapState({
                menu: state => state.Menu
            })
        },
        methods: {
            menus(name) {
                this.$store.dispatch('setMenu', {'activeMenu': 'plan', 'childMenu': name});
            }
        }
    }
</script>
