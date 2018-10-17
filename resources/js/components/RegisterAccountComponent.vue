<template>
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url(/assets/app/media/img//bg/bg-1.jpg);">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="#">
                            <img v-bind:src="this.$store.state.baseUrlLogo + 'logo-1.png'">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">Sign Up</h3>
                            <div class="m-login__desc">Enter your details to create your account:</div>
                        </div>
                        <form class="m-login__form m-form" @submit.prevent="signup">
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Fullname" name="name" v-model="name">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off" v-model="email">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="password" placeholder="Password" name="password" v-model="password">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="password_confirm" v-model="password_confirm">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="text" placeholder="School" name="school" v-model="school">
                            </div>
                            <div id="margin-top" class="mt-5"></div>
                            <div class="form-group">
                                <select class="form-control m-input m-login__form-input--last" v-model="batchSelected">
                                    <option value="">Select batch</option>
                                    <option v-for="item in batches" :key="item.id" :value="item.id">
                                        {{ item.id }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control m-input m-login__form-input--last" v-model="roleSelected">
                                    <option value="">Select Role</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.id">
                                        {{ role.name }}
                                    </option>
                                </select>

                                {{ roleSelected }}
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Sign Up</button>
                                <router-link :to="{ name: 'login' }" id="m_login_signup_cancel" class="btn btn-outline-focus  m-btn m-btn--pill m-btn--custom">Cancel</router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        name: 'register-account',
        data () {
            return {
                name: '',
                email: '',
                password: '',
                password_confirm: '',
                school: '',
                batches: [],
                batchSelected: '',
                roles: [],
                roleSelected: ''
            }
        },

        methods: {
            signup () {
                this.$store.dispatch('signup', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirm: this.password_confirm,
                    school: this.school,
                    batch_id: this.batchSelected,
                    role_id: this.roleSelected
                })
                .then(response => {
                    this.$router.push({ name: 'login' })
                })
            },

            getBatches() {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token
                if(this.$store.getters.loggedIn) {
                    axios.get('batches')
                        .then(response => {
                            this.batches = response.data
                        })
                }
            },

            getRoles () {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token
                if(this.$store.getters.loggedIn) {
                    axios.get('roles')
                        .then(response => {
                            this.roles = response.data.data
                        })
                }
            }
        },

        created() {
            this.getBatches()
            this.getRoles()
        }
    }
</script>
