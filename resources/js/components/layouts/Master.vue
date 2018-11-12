<template>
    <div>
        <slot name="title"></slot>
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <vue-header @getUser="user = $event"></vue-header>

            <left-aside :user="user"></left-aside>

            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-content">
                        <slot name="content"></slot>
                    </div>
                </div>
            </div>
            <vue-footer></vue-footer>
        </div>
        <div id="m_scroll_top" class="m-scroll-top">
            <i class="la la-arrow-up"></i>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: ''
        };
    },
    created() {
        document.title = this.$slots.title[0].text;
    },
    watch: {
        user: function() {
            this.$emit('getUser', this.user);
        }
    }
};
</script>
