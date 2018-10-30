<template>
    <div>
        <vue-master @getUser="user = $event">
            <template slot="title">
                {{ $t('Welcome') }}
            </template>
            <span slot="head-title">{{ $t('Calendar') }}</span>
            <template slot="content">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ $t('report.Daily') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end mr-5">
                        <a class="m-menu__link btn btn-success" data-toggle="modal" data-target="#m_modal_workdpace">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{ $t('Add Workspaces') }}</span>
                        </a>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                <tr>
                                    <th>{{ $t('ID') }}</th>
                                    <th>{{ $t('Name Workspace') }}</th>
                                    <th>{{ $t('Delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="workspace in workspaces" :key="workspace.id">
                                    <td>{{ workspace.id }}</td>
                                    <td>
                                        <ItemWorkspace :content="workspace.name" :id="workspace.id" @finishedEdit="finishedEdit"></ItemWorkspace>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" @click="deleteWorkspace(workspace.id)">{{ $t('Delete') }}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>
        </vue-master>
        <div class="modal fade" id="m_modal_workdpace" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="create">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $t('Add workspace') }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">{{ $t('Name') }}</label>
                            <input type="text" class="form-control" v-model="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $t('Close') }}</button>
                        <button type="submit" class="btn btn-primary" @click="create" data-dismiss="modal">{{ $t('Add workspace') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</template>

<script>
import ItemWorkspace from './ItemWorkspace.vue';

export default {
    components: {
        ItemWorkspace
    },
    
    data () {
        return {
            name: '',
            edit: false,
            workspaces: []
        }
    },

    mounted () {
        this.getWorkspace();
    },

    methods: {
        create () {
            this.$store.dispatch('workspace/add', {
                name: this.name
            })
            .then(res => {
                this.getWorkspace()
                this.name = ''
            })
        },

        editing () {
            this.edit = true;
        },

        doneEdit ($event) {
            this.name = $event
        },

        getWorkspace () {
            this.$store.dispatch('workspace/getWorkspace')
            .then(res => {
                this.workspaces = res;
            })
        },

        finishedEdit (data) {
            this.$store.dispatch('workspace/editWorkspace', {
                name: data.workspace,
                id: data.id
            });
        },

        deleteWorkspace (id) {
            this.$store.dispatch('workspace/deleteWorkspace', {
                id: id
            })
            .then(res => {
                this.getWorkspace()
            })
        }
    }
}
</script>
