<template>
    <header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">

                <!-- BEGIN: Brand -->
                <div class="m-stack__item m-brand  m-brand--skin-dark ">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <router-link :to="{ name: 'index' }" class="m-brand__logo-wrapper">
                                <img v-bind:src="$store.state.baseUrlLogo" />
                            </router-link>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">

                            <!-- BEGIN: Left Aside Minimize Toggle -->
                            <a href="javascript:;" @click="toggleAside" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                                <span></span>
                            </a>

                            <!-- END -->

                            <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                            <a href="javascript:;" @click="toggleAsideMini" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>

                            <!-- END -->

                            <!-- BEGIN: Topbar Toggler -->
                            <a id="m_aside_header_topbar_mobile_toggle" @click="toggleTopbar" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>

                            <!-- BEGIN: Topbar Toggler -->
                        </div>
                    </div>
                </div>

                <!-- END: Brand -->
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                    <!-- BEGIN: Horizontal Menu -->
                    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                        <i class="la la-close"></i>
                    </button>
                    <!-- BEGIN: Topbar -->
                    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                            <ul class="m-topbar__nav m-nav m-nav--inline">
                                <li class="m-nav__item">
                                    <div class="m-nav__link">
                                        <div class="lang">
                                            <select name="language" class="form-select" @change="changeLanguage" v-model="language">
                                                <option value="en">English</option>
                                                <option value="vi">Tiếng Việt</option>
                                            </select>
                                        </div>
                                    </div>
                                </li>
                                <li ref="dropdown" class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img 
                                m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill 
                                m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle" @click="dropDown">
                                        <span class="m-topbar__userpic userpic">
                                            <img v-bind:src="user.avatar" class="m--img-rounded m--marginless" alt="" />
                                        </span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center" v-bind:style="'background: url(' + this.$store.state.urlImage + 'misc/user_profile_bg.jpg); background-size: cover;'">
                                                <div class="m-card-user m-card-user--skin-dark">
                                                    <div class="m-card-user__pic userpic">
                                                        <img v-bind:src="user.avatar" class="m--img-rounded m--marginless" alt="" />

                                                    </div>
                                                    <div class="m-card-user__details">
                                                        <span class="m-card-user__name m--font-weight-500">{{ user.name }}</span>
                                                        <a href="" class="m-card-user__email m--font-weight-300 m-link">{{ user.email }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__item">
                                                            <router-link :to="{ name: 'profile'}" class="m-nav__link">
                                                                <span class="m-nav__link-title">
                                                                    <span class="m-nav__link-wrap">
                                                                        <span class="m-nav__link-text">{{ $t('My Profile') }}</span>
                                                                    </span>
                                                                </span>
                                                            </router-link>
                                                        </li>
                                                        <li class="m-nav__separator m-nav__separator--fit">
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <router-link :to="{ name: 'logout'}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">{{ $t('Logout') }}</router-link>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- END: Topbar -->
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    data() {
        return {
            user: '',
            language: this.$i18n.locale
        };
    },
    created() {
        this.getUser();
    },
    methods: {
        dropDown() {
            this.$refs.dropdown.classList.toggle('m-dropdown--open');
        },
        toggleAside() {
            document
                .getElementById('body')
                .classList.toggle('m-brand--minimize');
            document
                .getElementById('body')
                .classList.toggle('m-aside-left--minimize');
        },
        toggleAsideMini() {
            document
                .getElementById('m_aside_left')
                .classList.toggle('m-aside-left--on');
        },
        toggleTopbar() {
            document.getElementById('body').classList.toggle('m-topbar--on');
        },
        getUser() {
            axios.get('current-user').then((res) => {
                this.user = res.data.data;
                this.$emit('getUser', this.user);
                this.$store.state.user = this.user;
            });
        },
        changeLanguage() {
            localStorage.setItem('language', this.language);
            this.$i18n.locale = this.language;
            location.reload();
        }
    }
};
</script>
