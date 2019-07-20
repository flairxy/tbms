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
                            <input type="checkbox" v-model="selected"/>
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1"
                            v-for="headerName in headers"
                            colspan="1" aria-label="Name: activate to sort column ascending">{{headerName}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr role="row" class="odd">
                        <td class="text-center"><input type="checkbox" v-model="checked"></td>
                        <td class="font-w600">Jack Estrada</td>
                        <td class="d-none d-sm-table-cell">customer9@example.com</td>
                        <td class="d-none d-sm-table-cell">
                            <span class="badge badge-info">Business</span>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                    data-toggle="tooltip" title="" data-original-title="View Customer">
                                <i class="fa fa-user"></i>
                            </button>
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
    export default {
        props: [
            'selected', 'search'
        ],
        data() {
            return {
                headers: [],
                rows: [],
                filterKey: String,
                dtHandle: null,
                checked: ''
            }
        },
        watch: {
            users(val, oldVal) {
                let vm = this;
                vm.rows = [];
                // You should _probably_ check that this is changed data... but we'll skip that for this example.
                // val.forEach(function (item) {
                //     // Fish out the specific column data for each item in your data set and push it to the appropriate place.
                //     // Basically we're just building a multi-dimensional array here. If the data is _already_ in the right format you could
                //     // skip this loop...
                //     let row = [];
                //
                //     row.push(item.id);
                //     row.push(item.username);
                //     row.push(item.name);
                //     row.push(item.phone);
                //
                //     vm.rows.push(row);
                // });

                // Here's the magic to keeping the DataTable in sync.
                // It must be cleared, new rows added, then redrawn!
                vm.dtHandle.clear();
                vm.dtHandle.rows.add(vm.rows);
                vm.dtHandle.draw();
            }
        },
        mounted() {
            let vm = this;
            // Instantiate the datatable and store the reference to the instance in our dtHandle element.
            vm.dtHandle = $(this.$el).DataTable({
                // Specify whatever options you want, at a minimum these:
                columns: vm.headers,
                data: vm.rows,
                searching: false,
                paging: false,
                info: false
            });
        }
    }
</script>
