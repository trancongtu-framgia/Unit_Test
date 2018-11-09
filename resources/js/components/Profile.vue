<template>
    <div>
        <vue-master @getUser="user = $event">
            <template slot="title">
                {{ $t('Profile') }}
            </template>
            <template slot="content">
                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <div class="m-portlet m-portlet--full-height  ">
                            <div class="m-portlet__body">
                                <div class="m-card-profile">
                                    <div class="m-card-profile__pic">
                                        <div class="m-card-profile__pic-wrapper">
                                            <img v-bind:src="this.$store.state.urlImage + 'users/user4.jpg'" alt="" />
                                        </div>
                                    </div>
                                    <div class="m-card-profile__details">
                                        <span class="m-card-profile__name">{{ user.name }}</span>
                                        <a href="" class="m-card-profile__email m-link">{{ user.email }}</a>
                                    </div>
                                </div>
                                <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                    <li class="m-nav__item">
                                        <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                            <span class="m-nav__link-title">
                                                <span class="m-nav__link-wrap">
                                                    <span class="m-nav__link-text">{{ $t('My Profile') }}</span>
                                                    <span class="m-nav__link-badge">
                                                        <span class="m-badge m-badge--success">2</span>
                                                    </span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="m-portlet__body-separator"></div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-tools">
                                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                                <i class="flaticon-share m--hide"></i>
                                                {{ $t('Update Profile') }}
                                            </a>
                                        </li>
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#change_password_tab" role="tab">
                                                {{ $t('Change Password') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_user_profile_tab_1">
                                    <form class="m-form m-form--fit m-form--label-align-right" method="post" @submit.prevent="submit">
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
                                                <div class="col-7 d-flex align-items-center">
                                                    <span class="m--regular-font-size-lg1">{{ user.email }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Univerity') }}</label>
                                                <div class="col-7">
                                                    <input name="school" class="form-control m-input" type="text" v-model="school">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Batch') }}</label>
                                                <div class="col-7 d-flex align-items-center">
                                                    <span class="m--regular-font-size-lg1">{{ user.batch }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Role') }}</label>
                                                <div class="col-7 d-flex align-items-center">
                                                    <span class="m--regular-font-size-lg1">{{ user.role }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Workspace') }}</label>
                                                <div class="col-7 d-flex align-items-center">
                                                    <span class="m--regular-font-size-lg1">{{ user.workspace }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Team') }}</label>
                                                <div class="col-7 d-flex align-items-center">
                                                    <span class="m--regular-font-size-lg1">{{ user.team }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Type') }}</label>
                                                <div class="col-7 d-flex align-items-center">
                                                    <span class="m--regular-font-size-lg1">{{ user.type }}</span>
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
                                <div class="tab-pane" id="change_password_tab">
                                    <div class="m-portlet__body">
                                        <form class="m-form m-form--fit m-form--label-align-right" method="post" @submit.prevent="password">
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('New Password') }}</label>
                                                <div class="col-7 d-flex align-items-center">
                                                    <input name="password" class="form-control m-input" type="password" required v-model="data.password">
                                                </div>
                                                <span class="text-danger error">{{ $t(response.password[0]) }}</span>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="example-text-input" class="col-2 col-form-label">{{ $t('Confirm New Password') }}</label>
                                                <div class="col-7 d-flex align-items-center">
                                                    <input name="password_confirmation" class="form-control m-input" type="password" required v-model="data.password_confirmation">
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
            school: '',
            data: {
                password: '',
                password_confirmation: ''
            },
            response: {
                password: ['']
            },
            errors: {
                name: ['']
            }
        };
    },
    mounted() {
        this.getProfile();
    },
    watch: {
        user: function() {
            this.name = this.user.name;
            this.school = this.user.school;
        }
    },
    methods: {
        editing ($event) {
            this.errors.name = ''
        },

        getProfile() {
            axios('/profile').then((res) => {
                this.user = res.data.data;
            });
        },

        submit() {
            axios
                .patch('profile', {
                    name: this.name,
                    school: this.school
                })
                .then((res) => {
                   if (res.data.errors) {
                        let keys = Object.keys(res.data.errors);
                        for (let i = 0; i < keys.length; i++) {
                            this.errors[keys[i]] = res.data.errors[keys[i]];
                        }
                    } else {
                        alert(res.data.message)
                    }
                })
                .catch((error) => {
                    if (error) {
                        alert(error);
                    }
                });
        },

        password() {
            axios.patch('password', this.data).then((res) => {
                if (res.data.success) {
                    alert(res.data.success);
                }
                let keys = Object.keys(res.data.message);
                for (let i = 0; i < keys.length; i++) {
                    this.response[keys[i]] = res.data.message[keys[i]];
                }
            });
        }
    }
}
</script>
