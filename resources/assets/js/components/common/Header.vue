<template>
    <Menu mode="horizontal" :active-name="menu.activeMenu" @on-select="select">
        <div class="layout-logo"></div>
        <div class="layout-nav">
            <MenuItem name="index">
                <Icon type="radio-waves"></Icon>
                系统公告
            </MenuItem>
            <MenuItem name="lesson" v-if="user.authenticated">
                <Icon type="easel"></Icon>
                总课表
            </MenuItem>
            <MenuItem name="process_table" v-if="user.authenticated">
                <Icon type="ios-bookmarks-outline"></Icon>
                授课进程表
            </MenuItem>
            <MenuItem name="heads" v-if="user.authenticated">
                <Icon type="ios-people"></Icon>
                负责人名单
            </MenuItem>
            <router-link to="/plan">
                <MenuItem name="plan" v-if="user.authenticated">
                    <Icon type="ios-bookmarks-outline"></Icon>
                    授课计划
                </MenuItem>
            </router-link>
            <router-link to="/system">
                <MenuItem name="system_setup" v-if="user.authenticated">
                    <Icon type="gear-b"></Icon>
                    系统设置
                </MenuItem>
            </router-link>
        </div>
        <div class="login-register" v-if="!user.authenticated">
            <MenuItem name="login">
                <router-link to="/login">
                    <Button type="ghost">
                        <Icon type="log-in"></Icon>
                        登陆
                    </Button>
                </router-link>
            </MenuItem>
            <MenuItem name="register">
                <router-link to="/register">
                    <Button type="ghost">
                        <Icon type="paper-airplane"></Icon>
                        注册
                    </Button>
                </router-link>
            </MenuItem>
        </div>
        <div class="header-avator-con" v-if="user.authenticated">
            <div class="user-dropdown-menu-con">
                <Row type="flex" justify="end" align="middle" class="user-dropdown-innercon">
                    <Dropdown transfer trigger="click">
                        <a href="javascript:;">
                            <span class="main-user-name">{{ user.username }}</span>
                            <Icon type="arrow-down-b"></Icon>
                        </a>
                        <DropdownMenu slot="list">
                            <DropdownItem name="own">
                                <span @click="menus('own')">个人中心</span>
                            </DropdownItem>
                            <DropdownItem name="logout" divided>
                                <span @click="menus('logout')">安全退出</span>
                            </DropdownItem>
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
    import {mapState} from 'vuex';

    export default {
        computed: {
            ...mapState({
                user: state => state.AuthUser,
                menu: state => state.Menu
            })
        },
        mounted() {
            // this.getUserInfo(); // 现获取用户信息 && 判断token是否过期
        },
        methods: {
//            getUserInfo() {
//                let _this = this;
//                axios.get('/api/user').then(response => {
//                    _this.$store.dispatch('setAuthUser', response.data);
//                }).catch(() => {
//                    _this.refreshToken();
//                });
//            },
//            refreshToken() {
//                let _this = this;
//                axios.get('/api/authorizations/curren').then(response => {
//                    JWT.setToken(response.data.meta.access_token);
//                    _this.$store.dispatch('setAuthUser', response.data);
//                }).catch(() => {
//                    JWT.removeToken();
//                    _this.$store.dispatch('unsetAuthUser');
//                    _this.$Message.warning({
//                        content: '身份信息已过期，请重新登陆。',
//                        duration: 2,
//                        onClose: () => {
//                            _this.$router.push({name: 'login'});
//                        }
//                    });
//                });
//            },
            menus(name) {
                let _this = this;
                if (name === 'own') {
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
            },
            select(name) {
                switch (name) {
                    case 'system_setup':
                        this.$store.dispatch('setMenu', {'activeMenu': name, 'childMenu': 'configures'});
                        break;
                    case 'plan':
                        this.$store.dispatch('setMenu', {'activeMenu': name, 'childMenu': 'write_plan'});
                        break;
                    default:
                        this.$store.dispatch('setMenu', {'activeMenu': name});
                        break;
                }
            }
        }
    }
</script>