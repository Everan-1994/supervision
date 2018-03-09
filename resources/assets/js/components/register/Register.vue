<template>
    <Row :style="{ 'margin-top': '70px' }">
        <Col span="8" offset="8">
        <Card>
            <p slot="title" style="text-align: center;">
                <Icon type="social-octocat"></Icon> 用户注册
            </p>
            <Form ref="userData" :model="userData" :rules="ruleValidate" :label-width="83">
                <FormItem label="系部：" prop="department">
                    <Select v-model="userData.department" style="width: 94%;">
                        <Option value="0">计算机系</Option>
                        <Option value="1">工商系</Option>
                        <Option value="2">汽车系</Option>
                    </Select>
                </FormItem>
                <FormItem label="姓名：" prop="truename">
                    <Input style="width: 94%;" v-model="userData.truename"
                           placeholder="Enter your truename"></Input>
                </FormItem>
                <FormItem label="密码：" prop="password">
                    <Input style="width: 94%;" v-model="userData.password" type="password"
                           placeholder="Enter your password"></Input>
                </FormItem>
                <FormItem label="确认密码：" prop="confirmPassword">
                    <Input style="width: 94%;" v-model="userData.confirmPassword" type="password"
                           placeholder="Enter confirm password"></Input>
                </FormItem>
                <FormItem label="邮箱：" prop="mail">
                    <div style="display:inline-block;width:66%;">
                        <AutoComplete  v-model="userData.mail"
                                       :data="mailData"
                                       @on-search="handleSearch"
                                       placeholder="Enter your e-mail">
                        </AutoComplete>
                    </div>
                    <div style="display:inline-block;position:relative;">
                        <Button @click="getIdentifyCode" :disabled="canGetIdentifyCode">{{ gettingIdentifyCodeBtnContent }}</Button>
                        <div class="own-space-input-identifycode-con" v-if="inputCodeVisible">
                            <div style="background-color:white;z-index:110;margin:10px;">
                                <Input v-model="securityCode" placeholder="请填写验证码" ></Input>
                                <div style="margin-top:10px;text-align:right">
                                    <Button type="ghost" @click="cancelInputCodeBox">取消</Button>
                                    <Button type="primary" @click="submitCode" :loading="checkIdentifyCodeLoading">确定</Button>
                                </div>
                            </div>
                        </div>
                    </div>
                </FormItem>
                <FormItem label="性别：">
                    <RadioGroup v-model="userData.sex">
                        <Radio label="1">男</Radio>
                        <Radio label="2">女</Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem label="注册身份：">
                    <RadioGroup v-model="userData.identify">
                        <Radio label="1">校内</Radio>
                        <Radio label="2">校外</Radio>
                    </RadioGroup>
                </FormItem>
                <div class="ivu-form-item-content" style="text-align: center;">
                    <Button type="primary" @click="handleSubmit('userData')" style="margin-left: 8px">
                        <Icon type="android-done"></Icon>
                        注册
                    </Button>
                    <Button type="ghost" @click="handleReset('userData')" style="margin-left: 8px">
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
    export default {
        data() {
            const valideRePassword = (rule, value, callback) => {
                if (value !== this.userData.password) {
                    callback(new Error('两次输入密码不一致！'));
                } else {
                    callback();
                }
            };
            return {
                userData: {
                    department: '',
                    truename: '',
                    mail: '',
                    password: '',
                    confirmPassword: '',
                    sex: '1',
                    identify: '1'
                },
                mailData: [], // 自动补全数组
                inputCodeVisible: false, // 显示填写验证码box
                securityCode: '', // 验证码
                gettingIdentifyCodeBtnContent: '获取验证码', // “获取验证码”按钮的文字
                hasGetIdentifyCode: false, // 是否点了获取验证码
                canGetIdentifyCode: false, // 是否可点获取验证码
                checkIdentifyCodeLoading: false,
                isValid: false,
                ruleValidate: {
                    department: [
                        {required: true, message: '请选择系部！', trigger: 'change'}
                    ],
                    truename: [
                        {required: true, message: '请写填姓名！', trigger: 'blur'}
                    ],
                    mail: [
                        {required: true, message: '请填写邮箱！', trigger: 'blur'},
                        {type: 'email', message: '邮箱格式不正确！', trigger: 'change'}
                    ],
                    password: [
                        {required: true, message: '请填写密码！', trigger: 'blur'},
                        {min: 6, message: '密码不得少于6位！', trigger: 'blur'},
                        {max: 18, message: '密码不得超出18位！', trigger: 'blur'}
                    ],
                    confirmPassword: [
                        {required: true, message: '请再次输入密码！', trigger: 'blur'},
                        {validator: valideRePassword, trigger: 'blur'}
                    ],
                }
            };
        },
        methods: {
            handleSearch (value) {
                this.mailData = !value ? [] : [
                    value + '@qq.com',
                    value + '@163.com',
                    value + '@126.com',
                    value + '@sina.com',
                    value + '@aliyun.com'
                ];
            },
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid || this.isValid) {
                        this.$Message.success('Success!');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            handleReset(name) {
                this.$refs[name].resetFields();
            },
            getIdentifyCode () {
                this.hasGetIdentifyCode = true;

                this.$refs['userData'].validate((valid) => {
                    if (valid) {
                        this.canGetIdentifyCode = true;
                        let timeLast = 60;
                        let timer = setInterval(() => {
                            if (timeLast >= 0) {
                                this.gettingIdentifyCodeBtnContent = timeLast + '秒后重试';
                                timeLast -= 1;
                            } else {
                                clearInterval(timer);
                                this.gettingIdentifyCodeBtnContent = '获取验证码';
                                this.canGetIdentifyCode = false;
                            }
                        }, 1000);
                        this.inputCodeVisible = true;
                        // you can write ajax request here
                        let email = this.userData.mail;
                        axios.post('/api/verificationCodes', { 'email': email }).then(response => {
                            console.log(response);
                        });
                    }
                });
            },
            cancelInputCodeBox () {
                this.inputCodeVisible = false;
            },
            getCode (email) {

            },
            submitCode () {
                let vm = this;
                vm.checkIdentifyCodeLoading = true;
                if (this.securityCode.length === 0) {
                    this.$Message.error('请填写验证码');
                } else {
                    // 已验证
                    vm.isValid = true;
                    setTimeout(() => {
                        this.$Message.success('验证码正确');
                        this.inputCodeVisible = false;
                        this.checkIdentifyCodeLoading = false;
                    }, 1000);
                }
            },
        }
    }
</script>
