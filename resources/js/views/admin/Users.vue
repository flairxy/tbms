<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">USERS</span>
        </nav>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">USERS
                </h3>
            </div>
            <div class="block-content block-content-full">
                <my-data-table
                    :columns="['Username', 'email', 'Status', 'joined']"
                    :fetch-url="queryParams" transaction-type="user"
                >
                </my-data-table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: '',
                queryParams: {
                    type: null
                }
            }
        },

    }
</script>
