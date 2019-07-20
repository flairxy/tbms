<template>
    <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="DataTables_Table_2_length"><label>Show <select
                    name="DataTables_Table_2_length" aria-controls="DataTables_Table_2"
                    class="custom-select custom-select-sm form-control form-control-sm">
                    <option value="5">5</option>
                    <option value="8">8</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select> entries</label></div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="DataTables_Table_2_filter" class="dataTables_filter"><label>Search:<input
                    type="search" class="form-control form-control-sm" placeholder="search..."
                    aria-controls="DataTables_Table_2" v-model="search"></label></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table
                    class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination dataTable no-footer"
                    id="DataTables_Table_2" role="grid" aria-describedby="DataTables_Table_2_info">
                    <thead>
                    <tr role="row">
                        <th class="text-center" tabindex="0" aria-controls="DataTables_Table_2"
                            rowspan="1" colspan="1">
                            #
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1"
                            v-for="column in columns" :key="column"
                            colspan="1" aria-label="Name: activate to sort column ascending">{{column}}
                        </th>
                        <th class="text-center" tabindex="0" aria-controls="DataTables_Table_2"
                            rowspan="1" colspan="1">Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd" v-for="(data, index) in tableData" :key="data.id">
                        <td class="text-center">
                            {{index + 1}}</td>
                        <td class="font-w600" v-for="(column, indexHeader) in data" :key="indexHeader">
                            <div v-if="indexHeader == '1' && transactionType == 'deposit'" class="text-success">{{column}}</div>
                            <div v-else-if="indexHeader == '1' && transactionType == 'withdraw'" class="text-danger">{{column}}</div>
                            <div v-else>{{column}}</div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button v-if="transactionType == 'user'" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                        data-toggle="tooltip" title="" data-original-title="view">
                                    <i class="fa fa-address-book"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="DataTables_Table_2_info" role="status" aria-live="polite">
                    Showing 1 to 15 of 15 entries
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_2_paginate">
                    <ul class="pagination">
                        <li class="paginate_button page-item first disabled" id="DataTables_Table_2_first">
                            <a href="#" aria-controls="DataTables_Table_2" data-dt-idx="0" tabindex="0"
                               class="page-link">First</a></li>
                        <li class="paginate_button page-item previous disabled"
                            id="DataTables_Table_2_previous"><a href="#" aria-controls="DataTables_Table_2"
                                                                data-dt-idx="1" tabindex="0"
                                                                class="page-link">Previous</a></li>
                        <li class="paginate_button page-item active"><a href="#"
                                                                        aria-controls="DataTables_Table_2"
                                                                        data-dt-idx="2" tabindex="0"
                                                                        class="page-link">1</a></li>
                        <li class="paginate_button page-item next disabled" id="DataTables_Table_2_next"><a
                            href="#" aria-controls="DataTables_Table_2" data-dt-idx="3" tabindex="0"
                            class="page-link">Next</a></li>
                        <li class="paginate_button page-item last disabled" id="DataTables_Table_2_last"><a
                            href="#" aria-controls="DataTables_Table_2" data-dt-idx="4" tabindex="0"
                            class="page-link">Last</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {RepositoryFactory} from '../repository/RepositoryFactory'

    const UsersRepository = RepositoryFactory.get('users');
    export default {
        props: {
            selected: Array,
            search: String,
            columns: {type: Array, required: true},
            fetchUrl: {type: Object, required: true},
            transactionType: {type: String, required: true}
        },
        data() {
            return {
                tableData: [],
                filterKey: String,
                dtHandle: null,
                checked: []
            }
        },
        methods: {
            fetchData(params) {
                let type = this.transactionType;
                if (type === 'deposit') {
                    UsersRepository.fetchDeposits(params).then(response => {
                        this.tableData = response.data;
                    })
                } else if (type === 'withdraw') {
                    UsersRepository.fetchWithdrawals(params).then(response => {
                        this.tableData = response.data;
                    })
                } else {
                    UsersRepository.fetchUsers(params).then(response => {
                        this.tableData = response.data;
                    })
                }

            }
        },
        created() {
            return this.fetchData(this.fetchUrl)
        }
    }
</script>
