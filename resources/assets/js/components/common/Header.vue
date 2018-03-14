<template>
    <Menu mode="horizontal" active-name="1">
        <div class="layout-logo"></div>
        <div class="layout-nav">
            <MenuItem name="1">
                <Icon type="radio-waves"></Icon>
                系统公告
            </MenuItem>
            <MenuItem name="2">
                <Icon type="ios-bookmarks-outline"></Icon>
                授课计划
            </MenuItem>
        </div>
        <div class="login-register" v-if="!user.authenticated">
            <MenuItem name="5">
                <router-link to="/login">
                    <Button type="ghost">
                        <Icon type="log-in"></Icon>
                        登陆
                    </Button>
                </router-link>
            </MenuItem>
            <MenuItem name="6">
                <router-link to="/register">
                    <Button type="ghost">
                        <Icon type="edit"></Icon>
                        注册
                    </Button>
                </router-link>
            </MenuItem>
        </div>
        <div class="header-avator-con" v-if="user.authenticated">
            <div class="user-dropdown-menu-con">
                <Row type="flex" justify="end" align="middle" class="user-dropdown-innercon">
                    <Dropdown transfer trigger="click">
                        <a href="javascript:void(0)">
                            <span class="main-user-name">{{ user.username }}</span>
                            <Icon type="arrow-down-b"></Icon>
                        </a>
                        <DropdownMenu slot="list">
                            <DropdownItem @click="menus('ownSpace')">个人中心</DropdownItem>
                            <DropdownItem @click="menus('logout')" divided>退出登录</DropdownItem>
                        </DropdownMenu>
                    </Dropdown>
                    <Avatar style="background-color: #87d068; margin-left: 10px;" icon="person"/>
                </Row>
            </div>
        </div>
    </Menu>
</template>

<script>
    import JWT from './../../helpers/jwt';
    import Store from './../../store/modules/auth-user';
    import {mapState} from 'vuex';

    export default {
        computed: {
            ...mapState({
                user: state => state.AuthUser
            }),
        },
        mounted() {
            if (!Store.state.authenticated) {
                this.getUserInfo();
            } else {
                this.refreshToken();
            }
        },
        methods: {
            getUserInfo() {
                let _this = this;
                axios.get('/api/user').then(response => {
                    _this.$store.dispatch('setAuthUser', response.data);
                }).catch(() => {
                    _this.refreshToken();
                });
            },
            refreshToken() {
                let _this = this;
                axios.get('/api/authorizations/curren').then(response => {
                    JWT.setToken(response.data.meta.access_token);
                    _this.$store.dispatch('setAuthUser', response.data);
                }).catch(() => {
                    JWT.removeToken();
                    _this.$store.dispatch('unsetAuthUser');
                    _this.$Message.warning({
                        content: '身份信息已过期，请重新登陆。',
                        onClose: () => {
                            _this.$router.push({name: 'login'});
                        }
                    });
                });
            },
            menus(name) {
                let _this = this;
                if (name === 'ownSpace') {
                    _this.$router.push({
                        name: 'profile'
                    });
                } else if (name === 'logout') {
                    JWT.removeToken();
                    _this.$store.dispatch('unsetAuthUser');
                    _this.$Message.success({
                        content: '已安全退出',
                        onClose: () => {
                            _this.$router.push({name: 'login'});
                        }
                    });
                }
            }
        }
    }
</script>