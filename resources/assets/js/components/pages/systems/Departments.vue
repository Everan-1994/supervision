<template>
    <div>
        <Table :columns="columns" :data="departments" :loading="loading"></Table>
        <div style="margin: 10px; padding-bottom: 1px; ">
            <div style="float: right;">
                <Page :total="count"
                      :current="current_page"
                      :page-size="pre_page"
                      @on-change="changePage"
                      @on-page-size-change="changePageSize"
                      show-sizer
                      show-elevator
                      show-total
                      :page-size-opts="pageSizeOpts"
                      :placement="'top'">
                </Page>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                department_id: 0,
                count: 0,
                current_page: 1,
                pre_page: 10,
                pageSizeOpts: [10, 20, 30, 50],
                loading: true,
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
                                        icon: 'search'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.department_id = params.row.id;
                                        }
                                    }
                                }, '编辑'),
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small',
                                        icon: 'gear-a'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.del(params.row.id);
                                        }
                                    }
                                }, '删除')
                            ])
                        }
                    }
                ],
                departments: []
            }
        },
        mounted() {
            this.getDepartmentList();
        },
        methods: {
            getDepartmentList() {
                let _this = this;
                let params = {
                    current_page: _this.current_page,
                    per_page: _this.per_page
                };
                axios.get('/api/departments', {params}).then(response => {
                    _this.departments = response.data.data;
                    _this.count = response.data.meta.pagination.count;
                    _this.loading = false;
                })
            },
            changePage (value) {
                this.loading = true;
                this.current_page = value;
                this.getDepartmentList();
            },
            changePageSize (value) {
                this.loading = true;
                this.per_page = value;
                this.getDepartmentList();
            },
            del(id) {
                console.log(id);
            }
        }
    }

</script>
