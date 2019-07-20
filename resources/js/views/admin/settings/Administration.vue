<template>
    <div>
        <nav class="breadcrumb bg-white push">
            <a class="breadcrumb-item" href="javascript:void(0)">Dashboard</a>
            <span class="breadcrumb-item active">Administration</span>
        </nav>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in admins" :key="user.id">
                        <td class="font-w600">{{user.name}}</td>
                        <td class="font-w600">{{user.email}}</td>
                        <td class="font-w600">{{user.role}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary js-tooltip-enabled"
                                        data-toggle="tooltip" title="" data-original-title="Edit"
                                        @click="editModal(user)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" @click="gatewayDelete(user.id, user)" class="btn btn-sm btn-secondary js-tooltip-enabled">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                admins: []
            }
        }
    }
</script>
