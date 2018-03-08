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
        <div class="login-register">
            <MenuItem name="5">
                <router-link to="/login">
                    <Button type="ghost">
                        <Icon type="log-in"></Icon> 登陆
                    </Button>
                </router-link>
            </MenuItem>
            <MenuItem name="6">
                <router-link to="/register">
                    <Button type="ghost">
                        <Icon type="edit"></Icon> 注册
                    </Button>
                </router-link>
            </MenuItem>
        </div>
    </Menu>
</template>

<script>
    export default {

    }
</script>