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
                                    {{ $t('Teams') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end mr-5">
                        <a class="m-menu__link btn btn-success" data-toggle="modal" data-target="#m_modal_workdpace">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{ $t('Add Team') }}</span>
                        </a>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                <tr>
                                    <th>{{ $t('ID') }}</th>
                                    <th>{{ $t('Team') }}</th>
                                    <th>{{ $t('Delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="team in teams" :key="team.id">
                                    <td>{{ team.id }}</td>
                                    <td>
                                        <ItemTeam :content="team.name" :id="team.id" @finishedEdit="finishedEdit"></ItemTeam>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" @click="deleteTeam(team.id)">{{ $t('Delete') }}</a>
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
                            <h5 class="modal-title" id="exampleModalLabel">{{ $t('Add Team') }}</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="form-control-label">{{ $t('Name') }}</label>
                                <input type="text" class="form-control" v-model="name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $t('Close') }}</button>
                            <button type="submit" class="btn btn-primary" @click="create" data-dismiss="modal">{{ $t('Add Team') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import ItemTeam from './ItemTeam.vue';

export default {
    components: {
        ItemTeam
    },

    data() {
        return {
            name: '',
            edit: false,
            teams: []
        };
    },

    mounted() {
        this.getTeams();
    },

    methods: {
        create() {
            this.$store
                .dispatch('team/addTeam', {
                    name: this.name
                })
                .then((res) => {
                    this.getTeams();
                    this.name = '';
                });
        },

        editing() {
            this.edit = true;
        },

        doneEdit($event) {
            this.name = $event;
        },

        getTeams() {
            this.$store.dispatch('team/getTeam').then((res) => {
                this.teams = res;
            });
        },

        finishedEdit(data) {
            this.$store.dispatch('team/editTeam', {
                name: data.team,
                id: data.id
            });
        },

        deleteTeam(id) {
            if (!confirm(this.$t('Are you sure?'))) {
                return;
            }
            this.$store
                .dispatch('team/deleteTeam', {
                    id: id
                })
                .then((res) => {
                    this.getTeams();
                });
        }
    }
};
</script>
