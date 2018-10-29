<template>
    <div>
        <div @dblclick="editTodo" v-if="!editing" @click="showmodal" :data-toggle="modal" :data-target="'#report' + column + id" v-html="item"></div>
        <div class="modal fade" :id="'report' + column + id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $t('Report title') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ckeditor type="classic" v-model="item"></ckeditor>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">{{ $t('Close') }}</button>
                        <button type="button" class="btn btn-primary" :data-dismiss="modal" @click="doneEdit">{{ $t('Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: {
            content: {
                required: true,
                type: String
            },

            id: {
                required: true
            },

            column: {
                required: true
            }
        },

        directives: {
            focus: {
                inserted: function (el) {
                    el.focus()
                }
            }
        },

        data () {
            return {
                item: this.content,
                editing: false,
                beforeEnter: '',
                idItem: this.id,
                columnEdit: this.column,
                modal: '',
            }
        },

        methods: {
            editTodo () {
                this.editing = true,
                this.beforeEnter = this.item
            },

            exitEdit () {
                this.editing = false,
                this.item = this.beforeEnter
            },

            doneEdit () {
                var column = this.columnEdit
                this.editing = false
                this.$emit('doneEdit', {
                    'contentEdit': this.item,
                    'id': this.idItem,
                    column: this.columnEdit
                })
                this.$router.push({ name: 'manager_report'})
            },

            showmodal () {
                this.modal = 'modal'
            },

            closeModal () {
                this.editing = false,
                this.item = this.beforeEnter
                this.modal = ''
            }
        }
    }
</script>
