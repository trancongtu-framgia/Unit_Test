<template>
    <div>
        <button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>
        <div id="m_aside_left" class="m-grid__item m-aside-left m-aside-left--skin-dark ">

            <!-- BEGIN: Aside Menu -->
            <div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
                <ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow">
                    <li class="m-menu__item" aria-haspopup="true">
                        <router-link :to="{ name: 'index' }" class="m-menu__link">
                            <i class="m-menu__link-icon flaticon-line-graph"></i>
                            <span class="m-menu__link-title">
                                <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">{{ $t('Dashboard') }}</span>
                                </span>
                            </span>
                        </router-link>
                    </li>
                    <li class="m-menu__section">
                        <h4 class="m-menu__section-text">{{ $t('Components') }}</h4>
                        <i class="m-menu__section-icon flaticon-more-v3"></i>
                    </li>

                    <li class="m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                            <i class="m-menu__link-icon flaticon-calendar"></i>
                            <router-link :to="{ name: 'index'}" class="m-menu__link">
                                <span class="m-menu__link-text">{{ $t('Calendar') }}</span>
                            </router-link>
                        </a>
                    </li>
                    <template v-if="user.role && user.role !== 'trainee'">
                        <li class="m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <router-link :to="{ name: 'reports' }" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-calendar"></i>
                                <span class="m-menu__link-text">{{ $t('Reports') }}</span>
                            </router-link>
                        </li>

                        <li @click="toggleItem($event)" class="m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-menu-button"></i>
                                <span class="m-menu__link-text">{{ $t('Manager') }}</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item" aria-haspopup="true">
                                        <router-link :to="{name: 'list_workspace'}" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ $t('Workspaces') }}</span>
                                        </router-link>
                                    </li>
                                    <li class="m-menu__item" aria-haspopup="true">
                                        <router-link :to="{name: 'list_team'}" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ $t('Team') }}</span>
                                        </router-link>
                                    </li>

                                    <li class="m-menu__item" aria-haspopup="true">
                                        <router-link :to="{name: 'list_type'}" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ $t('Types') }}</span>
                                        </router-link>
                                    </li>

                                    <li class="m-menu__item" aria-haspopup="true">
                                        <router-link :to="{name: 'list_subjects'}" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ $t('Subjects') }}</span>
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <router-link :to="{name: 'register-account-trainee'}" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-menu-button"></i>
                                <span class="m-menu__link-text">{{ $t('Register trainee') }}</span>
                            </router-link>
                        </li>
                    </template>
                    <template v-else>
                        <li class="m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <router-link :to="{ name: 'manager_report' }" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-calendar"></i>
                                <span class="m-menu__link-text">{{ $t('Reports') }}</span>
                            </router-link>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
        <modalTeam></modalTeam>
        <modalType></modalType>
    </div>
</template>

<script type="text/javascript">
import modalTeam from './ModalTeamsComponent.vue';
import modalType from './ModalTypeComponent.vue';
export default {
    name: 'left-aside',
    components: {
        modalTeam,
        modalType
    },
    props: ['user'],
    methods: {
        toggleItem(event) {
            let element = event.currentTarget;
            element.classList.toggle('m-menu__item--open');
            element.children[1].classList.toggle('d-none');
        }
    }
};
</script>
