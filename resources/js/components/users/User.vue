<template>
    <vue-master>
        <template slot="title">{{ $t('Users Manager') }}</template>
        <template slot="content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{ $t('Users Manager') }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    <!--begin: Search Form -->
                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                        <div class="row align-items-center">
                            <div class="col-xl-8 order-2 order-xl-1">
                                <div class="form-group m-form__group row align-items-center">
                                    <div class="col-md-4">
                                        <div class="m-form__group m-form__group--inline">
                                            <div class="m-form__label">
                                                <label>{{ $t('Role') }}</label>
                                            </div>
                                            <div class="m-form__control">
                                                <select class="form-control m-bootstrap-select" v-model="selected_role">
                                                    <option value="">{{ $t('All') }}</option>
                                                    <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="d-md-none m--margin-bottom-10"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="m-input-icon m-input-icon--left">
                                            <input type="text" v-model="search" @keyup.enter="getUsers" class="form-control m-input" placeholder="Search...">
                                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                                <span>
                                                    <i class="la la-search"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                <router-link :to="{ name: 'register-account-trainee' }" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span>{{ $t('New User') }}</span>
                                    </span>
                                </router-link>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div>
                        </div>
                    </div>

                    <!--end: Search Form -->

                    <!--begin: Datatable -->
                    <div class="m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                        <table class="text-center" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ $t('Num.') }}</th>
                                    <th class="avatar">{{ $t('Avatar') }}</th>
                                    <th>{{ $t('Name') }}</th>
                                    <th>{{ $t('Email') }}</th>
                                    <th>{{ $t('School') }}</th>
                                    <th>{{ $t('Batch') }}</th>
                                    <th>{{ $t('Role') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users">
                                    <td>{{ user.id }}</td>
                                    <td><img v-bind:src="user.avatar" alt="avatar" class="img-avatar"></td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.school }}</td>
                                    <td>{{ user.batch }}</td>
                                    <td>{{ user.role }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!--end: Datatable -->
                    <div class="mt-4 text-center">
                        <pagination ref="child" :fetchList="getUsers" :pagination="pagination" @makePagination="pagination = $event"></pagination>
                    </div>
                </div>
            </div>
        </template>
    </vue-master>
</template>

<script>
export default {
    data() {
        return {
            users: '',
            pagination: {},
            search: '',
            roles: [''],
            selected_role: ''
        };
    },
    created() {
        this.getUsers();
        this.getRoles();
    },
    watch: {
        selected_role: function() {
            this.getUsers();
        }
    },
    methods: {
        getUsers(url) {
            url = url && typeof url === 'string' ? url : '/users';
            axios(url, {
                params: {
                    search: this.search,
                    role_id: this.selected_role
                }
            }).then((res) => {
                this.users = res.data.data;
                this.$refs.child.makePagination(res.data.meta, res.data.links);
            });
        },
        getRoles() {
            axios('/roles').then((res) => {
                this.roles = res.data.data;
            });
        }
    }
};
</script>
