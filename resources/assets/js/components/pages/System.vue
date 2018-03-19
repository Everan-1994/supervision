<template>
    <div style="min-height: 200px;">
        <Content :style="{padding: '24px 0', minHeight: '280px', background: '#fff'}">
            <Layout>
                <Sider hide-trigger :style="{background: '#fff'}">
                    <Menu :active-name="menu.childMenu" @on-select="menus" theme="light" width="auto" :open-names="['system', 'plans']">
                        <Submenu name="system">
                            <template slot="title">
                                <Icon type="ios-navigate"></Icon>
                                系统管理
                            </template>
                            <router-link :to="{name: 'configures'}">
                                <MenuItem name="configures">
                                    系统配置
                                </MenuItem>
                            </router-link>
                            <router-link :to="{name: 'notices'}">
                                <MenuItem name="notices">
                                    公告列表
                                </MenuItem>
                            </router-link>
                            <router-link :to="{name: 'departments'}">
                                <MenuItem name="departments">
                                    组织机构
                                </MenuItem>
                            </router-link>
                        </Submenu>
                        <Submenu name="plans">
                            <template slot="title">
                                <Icon type="ios-keypad"></Icon>
                                授课计划
                            </template>
                            <MenuItem name="statistics">
                                <router-link :to="{name: 'statistics'}">
                                    统计概览
                                </router-link>
                            </MenuItem>
                            <MenuItem name="plans">
                                <router-link :to="{name: 'plans'}">
                                    授课计划列表
                                </router-link>
                            </MenuItem>
                        </Submenu>
                    </Menu>
                </Sider>
                <Content :style="{padding: '24px', minHeight: '280px', background: '#fff'}">
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
                this.$store.dispatch('setMenu', {'activeMenu': 'system_setup', 'childMenu': name});
            }
        }
    }
</script>
