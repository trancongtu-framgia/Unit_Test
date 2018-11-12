<template>
    <div>
        <vue-master @getUser="user = $event">
            <template slot="title">
                {{ $t('Profile') }}
            </template>
            <template slot="content">
                <div class="col-xl-12 col-lg-12">
                    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-tools">
                                <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                            <i class="flaticon-share m--hide"></i>
                                            {{ $t('Edit Batch') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_user_profile_tab_1">
                                <form class="m-form m-form--fit m-form--label-align-right" method="post" @submit.prevent="edit">
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
                                            <div class="col-6">
                                                 <label for="example-text-input" class="col-3 col-form-label">{{ $t('Start Day') }}</label>
                                                <div class="col-12">
                                                    <input name="start_day" class="form-control m-input" type="date" v-model="batches.start_day" @change="editing($event)">
                                                    <span class="text-danger" v-if="errors.start_day[0] != ''">
                                                        {{ errors.start_day[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="example-text-input" class="col-5 col-form-label">{{ $t('Stop day') }}</label>
                                                <div class="col-12">
                                                    <input name="stop_day" class="form-control m-input" type="date" v-model="batches.stop_day" @change="editing($event)">
                                                    <span class="text-danger" v-if="errors.stop_day[0] != ''">
                                                        {{ errors.stop_day[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-6">
                                                <div>
                                                    <label for="example-text-input" class="col-5 col-form-label">{{ $t('Type') }}</label>
                                                    <div class="col-12">
                                                        <select name="type_id" class="form-control" v-model="batches.type_id" @change="editing($event)">
                                                            <option v-for="type in types" :key="type.id" :value="type.id">
                                                                {{ type.name }}
                                                            </option>
                                                        </select>
                                                        <span class="text-danger" v-if="errors.type_id[0] != ''">
                                                            {{ errors.type_id[0] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="example-text-input" class="col-5 col-form-label">{{ $t('Subjects') }}</label>
                                                <div class="col-12">
                                                    <select name="subject_ids" class="form-control m-input" multiple v-model="subject" @change="editing($event)">
                                                        <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                                            {{ subject.name }}
                                                        </option>
                                                    </select>
                                                    <span class="text-danger" v-if="errors.subject_ids[0] != ''">
                                                        {{ errors.subject_ids[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-6">
                                                <label for="example-text-input" class="col-5 col-form-label">{{ $t('Workspace') }}</label>
                                                <div class="col-12">
                                                    <select name="workspace_id" class="form-control m-input" v-model="batches.workspace_id" @change="editing($event)">
                                                        <option disabled selected value="">{{ $t('Select workspace') }}</option>
                                                        <option v-for="workspace in workspaces" :key="workspace.id" :value="workspace.id">
                                                            {{ workspace.name }}
                                                        </option>
                                                    </select>
                                                    <span class="text-danger" v-if="errors.workspace_id[0] != ''">
                                                        {{ errors.workspace_id[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="example-text-input" class="col-5 col-form-label">{{ $t('Team') }}</label>
                                                <div class="col-12">
                                                   <select name="team_id" class="form-control m-input" v-model="batches.team_id" @change="editing($event)">
                                                        <option disabled selected value="">{{ $t('Select team') }}</option>
                                                        <option v-for="team in teams" :key="team.id" :value="team.id">
                                                            {{ team.name }}
                                                        </option>
                                                    </select>
                                                    <span class="text-danger" v-if="errors.team_id[0] != ''">
                                                        {{ errors.team_id[0] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                        <div class="m-form__actions">
                                            <div class="row">
                                                <div class="col-7">
                                                    <button type="submit" class="btn btn-success m-btn m-btn--air m-btn--custom">{{ $t('Save') }}</button>&nbsp;&nbsp;
                                                    <router-link :to="{name: 'list_batches'}" class="btn btn-info m-btn m-btn--air m-btn--custom">{{ $t('Back') }}</router-link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </vue-master>
    </div>
</template>
<script type="text/javascript">
    export default {
        data () {
            return {
                batches: {},
                workspaces: {},
                teams: {},
                types: {},
                subjects: {},
                start_day: '',
                stop_day: '',
                workspace: '',
                team: '',
                type: '',
                subject: [],
                errors: {
                    start_day: [''],
                    stop_day: [''],
                    workspace_id: [''],
                    team_id: [''],
                    type_id: [''],
                    subject_ids: ['']
                }
            }
        },

        mounted () {
            this.getBatch()
            this.getTeams()
            this.getWorkspaces()
            this.getTypes()
            this.getSubjects()
        },

        methods: {
            editing ($event) {
                for (var i in this.errors) {
                    if (i == $event.target.name) {
                        this.errors[i] = ''
                    }
                }
            },

            getBatch () {
                this.$store.dispatch('batch/getbatch', {
                    id_batch: this.$route.params.id
                })
                .then(res => {
                    this.batches = res
                    for (var i = 0; i < this.batches.subjects.length; i++) {
                        this.subject.push(this.batches.subjects[i].id)
                    }
                })
            },

            getTeams () {
                this.$store.dispatch('team/getTeam')
                .then(res => {
                    this.teams = res
                })
            },

            getWorkspaces () {
                this.$store.dispatch('workspace/getWorkspace')
                .then(res => {
                    this.workspaces = res
                })
            },

            getTypes () {
                this.$store.dispatch('type/getType')
                .then(res => {
                    this.types = res
                })
            },

            getSubjects () {
                this.$store.dispatch('subject/getSubject')
                .then(res => {
                    this.subjects = res.data
                })
            },

            edit () {
                this.$store.dispatch('batch/editBatch', {
                    id: this.batches.id,
                    workspace_id: this.batches.workspace_id,
                    team_id: this.batches.team_id,
                    type_id: this.batches.type_id,
                    subject_ids: this.subject,
                    start_day: this.batches.start_day,
                    stop_day: this.batches.stop_day,
                })
                .then(res => {
                    if (res.data.errors) {
                        let keys = Object.keys(res.data.errors);
                        for (let i = 0; i < keys.length; i++) {
                            this.errors[keys[i]] = res.data.errors[keys[i]];
                        }
                    } else {
                        alert(res.data.message)
                        this.$router.push({name: 'list_batches'})
                    }
                })
            }
        }
    }
</script>
