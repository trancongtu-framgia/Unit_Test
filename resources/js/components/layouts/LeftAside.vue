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
                    <a href="../../index.html" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-line-graph"></i>
                        <span class="m-menu__link-title">
                            <span class="m-menu__link-wrap">
                                <span class="m-menu__link-text">Dashboard</span>
                                <span class="m-menu__link-badge">
                                    <span class="m-badge m-badge--danger">2</span>
                                </span>
                            </span>
                        </span>
                    </a>
                </li>
                <li class="m-menu__section">
                    <h4 class="m-menu__section-text">Components</h4>
                    <i class="m-menu__section-icon flaticon-more-v3"></i>
                </li>

                <li class="m-menu__item m-menu__item--submenu m-menu__item--open m-menu__item--expanded" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:;" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-calendar"></i>
                        <span class="m-menu__link-text">Calendar</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                                <span class="m-menu__link">
                                    <span class="m-menu__link-text">Calendar</span>
                                </span>
                            </li>
                            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
                                <a href="../../components/calendar/google.html" class="m-menu__link ">
                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Google Calendar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <li class="m-menu__item " aria-haspopup="true">
                        <a class="m-menu__link" data-toggle="modal" data-target="#m_modal_1">
                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                <span></span>
                            </i>
                            <span class="m-menu__link-text">Work Space</span>
                        </a>
                    </li>
                </li>
            </ul>
        </div>

        <!-- END: Aside Menu -->
    </div>
    <!-- all modal -->
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form @submit.prevent="addWorkSpace">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create work space</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Name</label>
                            <input type="text" class="form-control" id="recipient-name" v-model="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" @click="addWorkSpace" data-dismiss="modal">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- end modal -->
</div>
</template>

<script type="text/javascript">
    export default {
        name: 'left-aside',
        data () {
            return {
                name: '',
            }
        },

        methods: {
            addWorkSpace () {
                this.$store.dispatch('workspace/addWorkSpace', {
                    name: this.name
                })
                .then(res => {
                    this.hideModel = 'modal'
                    confirm('Add success!!')

                })
                .catch(error => {
                    
                })
            },
        },
    }
</script>
