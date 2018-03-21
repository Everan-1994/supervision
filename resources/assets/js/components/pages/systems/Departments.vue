<template>
    <div>
        <div style="margin-bottom: 10px;">
            <Button type="primary" icon="plus-round" @click="departmentModel">新增组织机构</Button>
        </div>
        <Table stripe :columns="columns" :data="departments" :loading="loading"></Table>
        <div style="margin: 10px; padding-bottom: 1px; " v-if="total > 0">
            <div style="float: right;">
                <Page :total="total"
                      :current="page"
                      :page-size="pageSize"
                      @on-change="changePage">
                </Page>
            </div>
        </div>
        <Modal v-model="dModel"
               @on-cancel="cancelModel"
               width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon :type="department_id > 0 ? 'edit' : 'plus-round'"></Icon>
                <span>{{ department_id > 0 ? '编辑' : '新增' }}组织机构</span>
            </p>
            <div style="text-align:center">
                <Form :model="formData" ref="formData" :rules="ruleValidate" :label-width="72">
                    <FormItem label="名称：" prop="department">
                        <Input v-model="formData.department" placeholder="输入组织机构名称"></Input>
                    </FormItem>
                </Form>
            </div>
            <div slot="footer">
                <Button :type="department_id > 0 ? 'warning' : 'primary'" size="large" long :loading="modal_loading" @click="department">提交</Button>
            </div>
        </Modal>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                formData: {
                    department: ''
                },
                ruleValidate: {
                    department: [
                        {required: true, message: '请填写组织机构', rigger: 'blur'}
                    ],
                },
                department_id: 0,
                total: 0,
                page: 1,
                pageSize: 15,
                loading: true,
                modal_loading: false,
                columns: [
                    {
                        key: 'id',
                        title: '序号',
                        align: 'center',
                        width: 60
                    },
                    {
                        key: 'department',
                        title: '名称',
                        align: 'center'
                    },
                    {
                        key: 'action',
                        title: '操作',
                        align: 'center',
                        width: 220,
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'primary',
                                        size: 'small',
                                        icon: 'edit'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.department_id = params.row.id;
                                            this.departmentModel();
                                        }
                                    }
                                }, '编辑'),
                                h('Poptip', {
                                    props: {
                                        confirm: true,
                                        title: '确定要删除这条数据吗?',
                                        transfer: true
                                    },
                                    on: {
                                        'on-ok': () => {
                                            this.deleteDepartmentById(params.row.id, params.index)
                                        }
                                    }
                                }, [
                                    h('Button', {
                                        style: {
                                            marginRight: '5px'
                                        },
                                        props: {
                                            type: 'error',
                                            size: 'small',
                                            placement: 'top',
                                            icon: 'trash-a'
                                        }
                                    }, '删除')
                                ])
                            ])
                        }
                    }
                ],
                departments: [],
                dModel: false
            }
        },
        mounted() {
            this.getDepartmentList();
        },
        methods: {
            getDepartmentList() {
                let _this = this;
                let params = {
                    page: _this.page,
                    pageSize: _this.pageSize
                };
                axios.get('/api/departments', {params}).then(response => {
                    _this.departments = response.data.data;
                    _this.total = response.data.meta.pagination.total;
                    _this.loading = false;
                })
            },
            changePage (value) {
                this.loading = true;
                this.page = value;
                this.getDepartmentList();
            },
            departmentModel() {
                let _this = this;
                if (_this.department_id > 0) {
                    axios.get('/api/departments/' + _this.department_id).then(response => {
                        _this.formData.department = response.data.department;
                        _this.department_id = response.data.id;
                    }).catch(error => {
                        _this.$Message.error('初始化数据失败，待会再试！', 1.5);
                    });
                }
                _this.dModel = true;
            },
            cancelModel() {
                this.formData.department = '';
                this.department_id = 0;
                this.modal_loading = false;
                this.$refs['formData'].resetFields();
            },
            department() {
                let _this = this;
                _this.modal_loading = true;
                this.$refs['formData'].validate((valid) => {
                    if (valid) {
                        let formData = {
                            department: _this.formData.department
                        };
                        if (_this.department_id > 0) {
                            axios.patch('/api/departments/' + _this.department_id, formData).then(response => {
                                _this.respond('更新成功');
                            }).catch(error => {
                                _this.$Notice.error({
                                    title: '错误提醒',
                                    desc: error.response.data.errors.department[0] || '更新失败，请重试！'
                                });
                            });
                            _this.modal_loading = false;
                        } else {
                            axios.post('/api/departments', formData).then(response => {
                                _this.respond('添加成功');
                            }).catch(error => {
                                _this.$Notice.error({
                                    title: '错误提醒',
                                    desc: error.response.data.errors.department[0] || '添加失败，请重试！'
                                });
                            });
                            _this.modal_loading = false;
                        }
                    }
                })
            },
            respond(msg) {
                let _this = this;
                _this.dModel = false;
                _this.$Message.success(msg);
                _this.getDepartmentList();
                _this.$refs['formData'].resetFields();
            },
            deleteDepartmentById (id, index) {
                let _this = this;
                axios.delete('/api/departments/' + id).then(response => {
                    _this.$Message.success('删除成功', 1.5);
                    _this.remove(index);
                }).catch(error => {
                    _this.$Message.error('删除失败', 1.5);
                });
            },
            remove (index) {
                this.departments.splice(index, 1)
            },
        }
    }

</script>
