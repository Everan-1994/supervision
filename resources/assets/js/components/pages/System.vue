<template>
    <div style="min-height: 200px;">
        <Content :style="{padding: '24px 0', minHeight: '280px', background: '#fff'}">
            <Layout>
                <Sider hide-trigger :style="{background: '#fff'}">
                    <Menu active-name="1-1" theme="light" width="auto" :open-names="['1', '2']">
                        <Submenu name="1">
                            <template slot="title">
                                <Icon type="ios-navigate"></Icon>
                                系统管理
                            </template>
                            <MenuItem name="1-1">
                                <router-link to="/configures">
                                    系统配置
                                </router-link>
                            </MenuItem>
                            <MenuItem name="1-2">
                                <router-link to="/notices">
                                    公告列表
                                </router-link>
                            </MenuItem>
                            <MenuItem name="1-3">
                                <router-link to="/departments">
                                    组织机构
                                </router-link>
                            </MenuItem>
                        </Submenu>
                        <Submenu name="2">
                            <template slot="title">
                                <Icon type="ios-keypad"></Icon>
                                授课计划
                            </template>
                            <MenuItem name="2-1">
                                <router-link to="/statistics">
                                    统计概览
                                </router-link>
                            </MenuItem>
                            <MenuItem name="2-2">
                                <router-link to="/statistics">
                                    授课计划列表
                                </router-link>
                            </MenuItem>
                        </Submenu>
                    </Menu>
                </Sider>
                <Content :style="{padding: '24px', minHeight: '280px', background: '#fff'}">
                    Content
                </Content>
            </Layout>
        </Content>
    </div>
</template>
<script>
    export default {

    }
</script>
