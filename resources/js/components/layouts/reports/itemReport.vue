<template>
    <div>
        <div @dblclick="editTodo" v-if="!editing">{{ item }}</div>
        <input v-else type="text" v-model="item" @keyup.esc="exitEdit" v-focus @keyup.enter="doneEdit" @blur="doneEdit">
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
                columnEdit: this.column
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
            }
        }
    }
</script>
