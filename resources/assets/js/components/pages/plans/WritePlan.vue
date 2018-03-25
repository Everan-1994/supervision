<template>
    <div>
        <Row>
            <Col span="24">
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="80">
                    <Row>
                        <Col span="8">
                            <FormItem label="课程名：" prop="lesson_name">
                                <Input v-model="formValidate.lesson_name" placeholder="课程名称"></Input>
                            </FormItem>
                        </Col>
                        <Col span="8">
                            <FormItem label="授课班级：" prop="class_name">
                                <Input v-model="formValidate.class_name" placeholder="班级名称"></Input>
                            </FormItem>
                        </Col>
                        <Col span="8">
                            <FormItem label="类型：">
                                <RadioGroup v-model="formValidate.exam_type">
                                    <Radio label="1">考查</Radio>
                                    <Radio label="2">考试</Radio>
                                </RadioGroup>
                            </FormItem>
                        </Col>
                    </Row>
                    <Row v-for="(item, index) in formValidate.data" :key="index">
                        <Col span="10">
                            <FormItem label="起止周：" v-if="index == 0">
                                <Slider v-model="item.start_end_week" range :min="1" :max="19"></Slider>
                            </FormItem>
                            <FormItem v-else>
                                <Slider v-model="item.start_end_week" range :min="1" :max="19"></Slider>
                            </FormItem>
                        </Col>
                        <Col span="4">
                            <FormItem label="上课时间：">
                                <Select v-model="item.week" placeholder="周几上课？">
                                    <Option v-for="(w, i) in weeks" :key="i" :value="w.id">{{ w.day }}</Option>
                                </Select>
                            </FormItem>
                        </Col>
                        <Col span="6">
                            <FormItem label="节次："
                                      :prop="'data.' + index + '.lessons'"
                                      :rules="{required: true, message: '请填写课程节次', trigger: 'blur'}">
                                <Input v-model="item.lessons" placeholder="如：1-2-3节"></Input>
                            </FormItem>
                        </Col>
                        <Col span="4">
                            <FormItem v-if="index == 0">
                                <Button type="primary" @click="addData">
                                    <Icon type="plus"></Icon>
                                    增加数据
                                </Button>
                            </FormItem>
                            <FormItem v-else>
                                <Button type="error" @click="del(index)">
                                    <Icon type="close-round"></Icon>
                                    删除此行
                                </Button>
                            </FormItem>
                        </Col>
                    </Row>
                    <FormItem>
                        <Button type="primary" @click="handleSubmit('formValidate')">生成授课计划</Button>
                        <Button type="ghost" @click="handleReset('formValidate')" style="margin-left: 8px">重置</Button>
                    </FormItem>
                </Form>
            </Col>
        </Row>
    </div>
</template>

<script>

    export default {
        data () {
            return {
                formValidate: {
                    lesson_name: '',
                    class_name: '',
                    exam_type: '1',
                    data: [
                        {
                            week: '',
                            lessons: '',
                            start_end_week: [1, 12]
                        }
                    ]
                },
                weeks: [
                    {
                        'id': 1,
                        'day': '周一'
                    },
                    {
                        'id': 2,
                        'day': '周二'
                    },
                    {
                        'id': 3,
                        'day': '周三'
                    },
                    {
                        'id': 4,
                        'day': '周四'
                    },
                    {
                        'id': 5,
                        'day': '周五'
                    },
                    {
                        'id': 6,
                        'day': '周六'
                    },
                    {
                        'id': 7,
                        'day': '周日'
                    }
                ],
                ruleValidate: {
                    lesson_name: [
                        { required: true, message: '请填写课程名称', trigger: 'blur' }
                    ],
                    class_name: [
                        { required: true, message: '请填写班级名称', trigger: 'blur' }
                    ],
                }
            }
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            handleReset(name) {
                this.$refs[name].resetFields();
            },
            addData() {
                this.formValidate.data.push({
                    week: '',
                    lessons: '',
                    start_end_week: [1, 12]
                });
            },
            del(index) {
                this.formValidate.data.splice(index, 1);
            }
        }
    }

</script>
