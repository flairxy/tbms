<template>
    <div class="card card-inactive">
        <div class="card-body">
            <p class="card-text">
                <button @click="handleClick" class="btn btn-outline-info mb-2">
                    <i class="fa fa-plus"></i>
                    {{modalTitle}}
                </button>
            </p>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['modal-title'],
        methods: {
            handleClick () {
                this.$emit('show-modal')
            }
        }
    }
</script>
