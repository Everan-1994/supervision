<template>
    <Row :style="{ 'margin-top': '57px' }">
        <Col span="8" offset="8">
        <Card>
            <p slot="title" style="text-align: center;">
                <Icon type="social-octocat"></Icon>
                用户注册
            </p>
            <Form ref="formData" :model="formData" :rules="ruleValidate" :label-width="83">
                <FormItem label="系部：" prop="department">
                    <Select v-model="formData.department" style="width: 94%;">
                        <Option value="1">计算机系</Option>
                        <Option value="2">工商系</Option>
                        <Option value="3">汽车系</Option>
                    </Select>
                </FormItem>
                <FormItem label="姓名：" prop="truename">
                    <Input style="width: 94%;" v-model="formData.truename"
                           placeholder="Enter your truename"></Input>
                </FormItem>
                <FormItem label="邮箱：" prop="mail">
                    <AutoComplete v-model="formData.mail"
                                  :data="mailData"
                                  @on-search="handleSearch"
                                  style="width: 94%;"
                                  ref="mail"
                                  placeholder="Enter your e-mail">
                    </AutoComplete>
                </FormItem>
                <FormItem label="密码：" prop="password">
                    <Input style="width: 94%;" v-model="formData.password" type="password"
                           placeholder="Enter your password"></Input>
                </FormItem>
                <FormItem label="确认密码：" prop="confirmPassword">
                    <Input style="width: 94%;" v-model="formData.confirmPassword" type="password"
                           placeholder="Enter confirm password"></Input>
                </FormItem>
                <FormItem label="验证码：" prop="verifyCode">
                    <div style="display:inline-block;width:66%;">
                        <Input v-model="verifyCode" placeholder="Enter veriyf code"></Input>
                    </div>
                    <div style="display:inline-block;position:relative;">
                        <Button @click="getIdentifyCode" :disabled="canGetIdentifyCode">{{ gettingIdentifyCodeBtnContent
                            }}
                        </Button>
                    </div>
                </FormItem>
                <FormItem label="性别：">
                    <RadioGroup v-model="formData.sex">
                        <Radio label="1">男</Radio>
                        <Radio label="2">女</Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem label="注册身份：">
                    <RadioGroup v-model="formData.identify">
                        <Radio label="1">校内</Radio>
                        <Radio label="2">校外</Radio>
                    </RadioGroup>
                </FormItem>
                <div class="ivu-form-item-content" style="text-align: center;">
                    <Button type="primary" @click="handleSubmit('formData')" style="margin-left: 8px">
                        <Icon type="android-done"></Icon>
                        注册
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
    export default {
        data() {
            const valideRePassword = (rule, value, callback) => {
                if (value !== this.formData.password) {
                    callback(new Error('两次输入密码不一致！'));
                } else {
                    callback();
                }
            };
            const valideEmail = (rule, value, callback) => {
                if (!this.formData.mail) {
                    callback(new Error('请先填写邮箱！'));
                } else {
                    callback();
                }
            };
            return {
                formData: {
                    department: '',
                    truename: '',
                    mail: '',
                    password: '',
                    confirmPassword: '',
                    sex: '1',
                    identify: '1'
                },
                key: '',
                mailData: [], // 自动补全数组
                verifyCode: '', // 验证码
                inputCodeVisible: false, // 显示填写验证码box
                gettingIdentifyCodeBtnContent: '获取验证码', // “获取验证码”按钮的文字
                hasGetIdentifyCode: false, // 是否点了获取验证码
                canGetIdentifyCode: false, // 是否可点获取验证码
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
                    verifyCode: [
                        // {required: true, message: '请输入验证码！', trigger: 'blur'},
                        {validator: valideEmail, trigger: 'blur'}
                    ],
                }
            };
        },
        methods: {
            handleSearch(value) {
                this.mailData = !value ? [] : [
                    value + '@qq.com',
                    value + '@163.com',
                    value + '@126.com',
                    value + '@sina.com',
                    value + '@aliyun.com'
                ];
            },
            handleSubmit(name) {
                let _this = this;
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        let formData = {
                            department_id: _this.formData.department,
                            name: _this.formData.truename,
                            email: _this.formData.mail,
                            password: _this.formData.password,
                            sex: _this.formData.sex,
                            identify: _this.formData.identify,
                            verification_key: _this.key,
                            verification_code: _this.verifyCode
                        };
                        axios.post('/api/users', formData).then(response => {
                            if (response.status == 201) {
                                this.$Message.success('注册成功！');
                                setTimeout(() => {
                                    _this.$router.push({'name': 'login'});
                                }, 1500);
                            } else {
                                this.$Message.error('注册失败，请稍候重试。');
                            }
                        });

                    }
                })
            },
            handleReset(name) {
                this.$refs[name].resetFields();
            },
            getIdentifyCode() {
                let _this = this;
                _this.hasGetIdentifyCode = true;

                _this.$refs['formData'].validate((valid) => {
                    if (valid && !_this.formData.verifyCode) {
                        _this.canGetIdentifyCode = true;
                        let timeLast = 60;
                        let timer = setInterval(() => {
                            if (timeLast >= 0) {
                                _this.gettingIdentifyCodeBtnContent = timeLast + '秒后重试';
                                timeLast -= 1;
                            } else {
                                clearInterval(timer);
                                _this.gettingIdentifyCodeBtnContent = '获取验证码';
                                _this.canGetIdentifyCode = false;
                            }
                        }, 1000);
                        _this.inputCodeVisible = true;
                        // you can write ajax request here
                        let email = _this.formData.mail;
                        axios.post('/api/verificationCodes', {'email': email}).then(response => {
                            if (response.status == 201) {
                                _this.key = response.data.key;
                            } else {
                                _this.$Message.error('获取验证码异常，请重试。');
                            }
                        });
                    }
                });
            },
            submitCode() {
                if (this.formData.verifyCode.length === 0) {
                    this.$Message.error('请填写验证码');
                } else {
                    setTimeout(() => {
                        this.$Message.success('验证码正确');
                        this.inputCodeVisible = false;
                    }, 1000);
                }
            },
        }
    }
</script>
