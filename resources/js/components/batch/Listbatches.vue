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
                                    {{ $t('Batches') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end mr-5">
                        <router-link :to="{name: 'add_batches'}" class="m-menu__link btn btn-success">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{ $t('Add Batch') }}</span>
                        </router-link>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                <tr>
                                    <th>{{ $t('ID') }}</th>
                                    <th>{{ $t('Name') }}</th>
                                    <th>{{ $t('Start day') }}</th>
                                    <th>{{ $t('Stop day') }}</th>
                                    <th>{{ $t('Batch') }}</th>
                                    <th>{{ $t('Workspace') }}</th>
                                    <th>{{ $t('Team') }}</th>
                                    <th>{{ $t('Type') }}</th>
                                    <th>{{ $t('Subjects') }}</th>
                                    <th>{{ $t('Delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="batch in batches" :key="batch.id">
                                    <td>{{ batch.id }}</td>
                                    <td>{{ batch.name }}</td>
                                    <td>{{ batch.start_day }}</td>
                                    <td>{{ batch.stop_day }}</td>
                                    <td>{{ batch.batch }}</td>
                                    <td>{{ batch.workspace }}</td>
                                    <td>{{ batch.team }}</td>
                                    <td>{{ batch.type }}</td>
                                    <td>
                                        <div v-for="subject in batch.subjects">
                                            {{ subject.name }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" @click="deletebatch(batch.id)">{{ $t('Delete') }}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>
        </vue-master>
    </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getbatches();
    },

    data() {
        return {
            batches: []
        };
    },

    methods: {
        getbatches() {
            this.$store.dispatch('batch/getbatches').then((res) => {
                this.batches = res.data;
            });
        },

        deletebatch(id) {
            if (!confirm(this.$t('Are you sure?'))) {
                return;
            }
            this.$store
                .dispatch('batch/deletebatch', {
                    id: id
                })
                .then((res) => {
                    this.getbatches();
                });
        }
    }
};
</script>
