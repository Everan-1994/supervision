<style>
    .ivu-input-group-append {
        border: 0 !important;
        padding: 0 !important;
        background-color: #fff !important;
    }
</style>
<template>
    <Row :style="{ 'margin-top': '100px' }">
        <Col span="8" offset="8">
        <Card>
            <p slot="title" style="text-align: center;">
                <Icon type="android-person"></Icon>
                登 陆
            </p>
            <Form ref="formData" :model="formData" :rules="ruleValidate" :label-width="75">
                <FormItem label="邮箱：" prop="mail">
                    <Input style="width: 94%;" v-model="formData.mail" placeholder="Enter your e-mail"></Input>
                </FormItem>
                <FormItem label="密码：" prop="password">
                    <Input type="password" style="width: 94%;" v-model="formData.password" placeholder="Enter your password"></Input>
                </FormItem>
                <FormItem label="验证码：" prop="captcha">
                    <Input style="width: 94%; border-right: 0;" v-model="formData.captcha"
                           placeholder="Enter veriyf code">
                    <span slot="append">
                            <img ref="captcha" src="../../../images/everan.gif" title="刷新验证码" alt="验证码"
                                 @click="codeInit" class="img-code">
                        </span>
                    </Input>
                </FormItem>
                <div class="ivu-form-item-content" style="text-align: center;">
                    <Button type="primary" @click="handleSubmit('formData')" style="margin-left: 8px">
                        <Icon type="android-done"></Icon>
                        登陆
                    </Button>
                    <Button type="ghost" @click="handleReset('formData')" style="margin-left: 8px">
                        <Icon type="refresh"></Icon>
                        重置
                    </Button>
                </div>
            </Form>
        </Card>
        </Col>
    </Row>

</template>
<script>
    import JWT from '../../helpers/jwt';

    export default {
        data() {
            return {
                formData: {
                    mail: '',
                    password: '',
                    captcha: ''
                },
                captcha_key: 'captcha-no',
                default_src: '../../../images/everan.gif',
                ruleValidate: {
                    mail: [
                        {required: true, message: '请填写邮箱', trigger: 'blur'},
                        {type: 'email', message: '邮箱格式不正确', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '请填写密码', trigger: 'blur'}
                    ],
                    captcha: [
                        {required: true, message: '请填写验证码', trigger: 'blur'}
                    ],
                }
            }
        },
        mounted() {
            this.$store.dispatch('setMenu', 'login');
            this.codeInit();
        },
        methods: {
            handleSubmit(name) {
                let _this = this;
                let formData = {
                    'email': _this.formData.mail,
                    'password': _this.formData.password,
                    'captcha': _this.formData.captcha,
                    'captcha_key': _this.captcha_key
                };
                _this.$refs[name].validate((valid) => {
                    if (valid) {
                        axios.post('/api/authorizations', formData).then(response => {
                            JWT.setToken(response.data.meta.access_token);
                            _this.$store.dispatch('setAuthUser', response.data);
                            _this.$Message.success({
                                content: '登陆成功',
                                onClose: () => {
                                    _this.$router.push({ name: 'profile' })
                                }
                            });
                        }).catch(error => {
                            _this.$Message.error(error.response.data.message || '服务器异常');
                        });
                    }
                })
            },
            handleReset(name) {
                this.$refs[name].resetFields();
            },
            codeInit() {
                let _this = this;
                _this.$refs.captcha.src = _this.default_src;
                axios.get('/api/captchas/' + _this.captcha_key).then(response => {
                    _this.captcha_key = response.data.captcha_key;
                    setTimeout(() => {
                        _this.$refs.captcha.src = response.data.captcha_image_content;
                    }, 1000)
                });
            }
        }
    }
</script>
