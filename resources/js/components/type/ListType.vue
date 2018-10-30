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
                        <a class="m-menu__link btn btn-success" data-toggle="modal" data-target="#m_modal_type">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">{{ $t('Add Type') }}</span>
                        </a>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                <tr>
                                    <th>{{ $t('ID') }}</th>
                                    <th>{{ $t('Type') }}</th>
                                    <th>{{ $t('Shorthand') }}</th>
                                    <th>{{ $t('Delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="type in types" :key="type.id">
                                    <td>{{ type.id }}</td>
                                    <td>
                                        <ItemType :content="type.name" :id="type.id" :column="'name'" @finishedEdit="finishedEdit"></ItemType>
                                    </td>

                                    <td>
                                        <ItemType :content="type.shorthand" :id="type.id" :column="'shorthand'" @finishedEdit="finishedEdit"></ItemType>
                                    </td>

                                    <td>
                                        <a href="javascript:void(0)" @click="deleteType(type.id)">{{ $t('Delete') }}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>
        </vue-master>
        <div class="modal fade" id="m_modal_type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="addType">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $t('Create type') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">{{ $t('Name') }}</label>
                            <input type="text" class="form-control" v-model="name">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">{{ $t('Shorthand') }}</label>
                            <input type="text" class="form-control" v-model="shorthand">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ $t('Close') }}</button>
                        <button type="submit" class="btn btn-primary" @click="addType" data-dismiss="modal">{{ $t('Create') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</template>

<script>
import ItemType from './ItemType.vue';

export default {
    components: {
        ItemType
    },
    
    data () {
        return {
            name: '',
            shorthand: '',
            edit: false,
            types: []
        }
    },

    mounted () {
        this.getTypes();
    },

    methods: {
        addType () {
            this.$store.dispatch('type/addType', {
                name: this.name,
                shorthand: this.shorthand
            })
            .then(res => {
                this.getTypes()
                this.name = '',
                this.shorthand = ''
            })
        },

        editing () {
            this.edit = true;
        },

        doneEdit ($event) {
            this.name = $event
        },

        getTypes () {
            this.$store.dispatch('type/getType')
            .then(res => {
                this.types = res;
            })
        },

        finishedEdit (data) {
            this.$store.dispatch('type/editType', data)
        },

        deleteType (id) {
            this.$store.dispatch('type/deleteType', {
                id: id
            })
            .then(res => {
                this.getTypes()
            })
        }
    }
}
</script>
