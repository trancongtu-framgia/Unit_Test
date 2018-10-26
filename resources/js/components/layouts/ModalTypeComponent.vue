<template>
    <div class="modal fade" id="m_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="addTeam">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Types</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Name</label>
                            <input type="text" class="form-control" v-model="name">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Shorthand</label>
                            <input type="text" class="form-control" v-model="shorthand">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" @click="addTeam" data-dismiss="modal">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    name: 'modal-team',
    data() {
        return {
            name: '',
            shorthand: ''
        };
    },

    methods: {
        addTeam() {
            this.$store
                .dispatch('type/addType', {
                    name: this.name,
                    shorthand: this.shorthand
                })
                .then((res) => {
                    this.hideModel = 'modal';
                    confirm('Add success!!');
                })
                .catch((error) => {});
        }
    }
};
</script>
