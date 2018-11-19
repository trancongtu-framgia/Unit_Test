<template>
    <div>
        <vue-master @getUser="user = $event">
            <template slot="title">
                {{ $t('Profile') }}
            </template>
            <template slot="content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-tools">
                                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                                <i class="flaticon-share m--hide"></i>
                                                {{ $t('Register Trainee') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_user_profile_tab_1">
                                    <form class="m-form m-form--fit m-form--label-align-right" method="post" @submit.prevent="register">
                                        <div class="m-portlet__body">
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Full Name') }}</label>
                                                <div class="col-7">
                                                    <input name="name" class="form-control m-input" type="text" v-model="name" @input="editing($event)">
                                                    <span class="text-danger" v-if="errors.name[0] != ''">
                                                        {{ errors.name[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Email') }}</label>
                                                <div class="col-7">
                                                    <input name="email" class="form-control m-input" type="text" v-model="email" @input="editing($event)">
                                                    <span class="text-danger" v-if="errors.email[0] != ''">
                                                        {{ errors.email[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Univerity') }}</label>
                                                <div class="col-7">
                                                    <input name="school" class="form-control m-input" type="text" v-model="school">
                                                    <!-- <span class="text-danger">
                                                        {{ errors.school[0] }}
                                                    </span> -->
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Role') }}</label>
                                                <div class="col-7">
                                                    <select class="form-control" @change="editing($event)" v-model="role_id" name="role_id">
                                                        <option disabled value="">{{ $t('Select Role') }}</option>
                                                        <option v-for="item in roles" :value="item.id">
                                                            {{ item.name }}
                                                        </option>
                                                    </select>
                                                    <span class="text-danger" v-if="errors.role_id != ''">
                                                        {{ errors.role_id[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row" v-if="! notbatch">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Batch') }}</label>
                                                <div class="col-7 d-flex align-items-center">
                                                    <select class="form-control" v-model="batch_id">
                                                        <option disabled value="">{{ $t('Select batches') }}</option>
                                                        <option v-for="batch in batches" :value="batch.id">
                                                            {{ batch.name }}
                                                        </option>
                                                    </select>
                                                    <!--  <span class="text-danger">
                                                        {{ errors.batch_id[0] }}
                                                    </span> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                            <div class="m-form__actions">
                                                <div class="row">
                                                    <div class="col-2">
                                                    </div>
                                                    <div class="col-7">
                                                        <button type="submit" class="btn btn-success m-btn m-btn--air m-btn--custom">{{ $t('Save') }}</button>&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </vue-master>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: '',
            name: '',
            email: '',
            school: '',
            batch_id: '',
            batches: {},
            role_id: '',
            notbatch: false,
            roles: {},
            errors: {
                name: [''],
                email: [''],
                school: [''],
                batch_id: [''],
                role_id: ['']
            },
            message: ''
        };
    },
    mounted() {
        this.getbatches();
        this.getRoles();
    },

    methods: {
        getbatches() {
            this.$store.dispatch('trainee/getbatches').then((res) => {
                this.batches = res.data;
            });
        },

        getRoles() {
            this.$store.dispatch('trainee/getRoles').then((res) => {
                this.roles = res.data;
            });
        },

        editing(event) {
            if (event.target.tagName == 'SELECT') {
                const nameOption =
                    event.target.options[event.target.options.selectedIndex]
                        .text;
                if (nameOption === 'Admin' || nameOption === 'Trainer') {
                    this.notbatch = true;
                } else {
                    this.notbatch = false;
                }
            }
            if (event.target.name == 'role_id') {
                this.errors.role_id = '';
            }

            for (var i in this.errors) {
                if (i == event.target.name) {
                    this.errors[i] = '';
                }
            }
        },

        register() {
            this.$store
                .dispatch('trainee/register', {
                    batch_id: this.batch_id,
                    name: this.name,
                    email: this.email,
                    role_id: this.role_id,
                    school: this.school
                })
                .then((res) => {
                    if (res.errors) {
                        let keys = Object.keys(res.errors);
                        for (let i = 0; i < keys.length; i++) {
                            this.errors[keys[i]] = res.errors[keys[i]];
                        }
                    } else {
                        this.message = res.message;
                        alert(this.message);
                        (this.message = ''),
                            (this.user = ''),
                            (this.name = ''),
                            (this.email = ''),
                            (this.school = '');
                    }
                });
        }
    }
};
</script>
