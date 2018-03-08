<template>
    <Row :style="{ 'margin-top': '100px' }">
        <Col span="8" offset="8">
            <Card >
                <p slot="title" style="text-align: center;">
                    <Icon type="android-person"></Icon> 登 陆
                </p>
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="70">
                    <FormItem label="邮箱：" prop="mail">
                        <Input style="width: 94%;" v-model="formValidate.mail" placeholder="Enter your e-mail"></Input>
                    </FormItem>
                    <FormItem label="密码：" prop="password">
                        <Input style="width: 94%;" v-model="formValidate.password" placeholder="Enter your password"></Input>
                    </FormItem>
                    <div class="ivu-form-item-content" style="text-align: center;">
                        <Button type="primary" @click="handleSubmit('formValidate')" style="margin-left: 8px">
                            <Icon type="android-done"></Icon> 登陆
                        </Button>
                        <Button type="ghost" @click="handleReset('formValidate')" style="margin-left: 8px">
                            <Icon type="refresh"></Icon> 重置
                        </Button>
                    </div>
                </Form>
            </Card>
        </Col>
    </Row>

</template>
<script>
    export default {
        data () {
            return {
                formValidate: {
                    mail: '',
                    password: ''
                },
                ruleValidate: {
                    mail: [
                        { required: true, message: '请填写邮箱！', trigger: 'blur' },
                        { type: 'email', message: '邮箱格式不正确！', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请填写密码！', trigger: 'blur' }
                    ],
                }
            }
        },
        methods: {
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            handleReset (name) {
                this.$refs[name].resetFields();
            }
        }
    }
</script>
