<template>
    <div @dblclick="editTeam" v-if="!editing" v-html="team"></div>
    <input v-else type="text" v-model="team" @blur="doneEdit" @keyup.enter="doneEdit" @keyup.esc="cancelEdit" v-focus>
</template>
<script type="text/javascript">
    export default {
        props: {
            content: {
                required: true,
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
                team: this.content,
                idTeam: this.id
            }
        },

        methods: {
            editTeam () {
                this.editing = true
                console.log(this.editing)
            },

            doneEdit () {
                this.editing = false
                this.$emit('finishedEdit', {
                    'id': this.idTeam,
                    'team': this.team
                })
            },
        }
    }
</script>
