<template>
    <div @dblclick="editWorkspace" v-if="!editing" v-html="workspace"></div>
    <input v-else type="text" v-model="workspace" @blur="doneEdit" @keyup.enter="doneEdit" @keyup.esc="cancelEdit" v-focus>
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
                editing: false,
                workspace: this.content,
                idWorkspace: this.id
            }
        },

        methods: {
            editWorkspace () {
                this.editing = true
                console.log(this.editing)
            },

            doneEdit () {
                this.editing = false
                this.$emit('finishedEdit', {
                    'id': this.idWorkspace,
                    'workspace': this.workspace
                })
            },
        }
    }
</script>
