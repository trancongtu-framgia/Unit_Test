<template>
    <div>
        <vue-master @getUser="user = $event">
            <template slot="title">
                {{ $t('Welcome') }}
            </template>
            <span slot="head-title">{{ $t('Calendar') }}</span>
            <template slot="content">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ $t('Daily Report') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="report-section-mini">
                            <!--begin: Datatable -->
                            <table class="table table-editable table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                                <thead>
                                    <tr>
                                        <th>{{ $t('Subject') }}</th>
                                        <th class="th-report-content">{{ $t('Content') }}</th>
                                        <th class="th-report-item">{{ $t('Link') }}</th>
                                        <th class="th-report-item">{{ $t('Test Link') }}</th>
                                        <th class="th-report-item">{{ $t('Lesson') }}</th>
                                        <th class="th-report-item">{{ $t('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody v-for="(subject, x) in subjects" :key="x">
                                    <tr v-for="(n,index) in subject.day" :key="n">
                                        <td>
                                            <h3>{{ subject.name }}</h3> ({{ subject.day }} day)
                                            <hr>
                                            <div>Day: {{ n }}</div>
                                        </td>
                                        <template class="edittor" v-if="subjects[x].reports[n - 1].day == n">
                                            <td>
                                                <ckeditor @blur="editReport(x, n, 'content')" type="balloon" v-model="subjects[x].reports[n - 1].content" v-bind:html="report.content">
                                                </ckeditor>
                                            </td>
                                            <td>
                                                <ckeditor class="edittor" @blur="editReport(x, n, 'link')" type="balloon" v-model="subjects[x].reports[n - 1].link" v-bind:html="report.link">
                                                </ckeditor>
                                            </td>
                                            <td>
                                                <ckeditor class="edittor" @blur="editReport(x, n, 'test_link')" type="balloon" v-model="subjects[x].reports[n - 1].test_link" v-bind:html="report.test_link">
                                                </ckeditor>
                                            </td>
                                            <td>
                                                <ckeditor class="edittor" @blur="editReport(x, n, 'lesson')" type="balloon" v-model="subjects[x].reports[n - 1].lesson" v-bind:html="report.lesson">
                                                </ckeditor>
                                            </td>
                                            <td>
                                                <ckeditor class="edittor" @blur="editReport(x, n, 'status')" type="balloon" v-model="subjects[x].reports[n - 1].status" v-bind:html="report.status">
                                                </ckeditor>
                                            </td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </vue-master>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: '',
            subjects: [
                {
                    reports: ['']
                }
            ],
            report: {
                id: null,
                subject_id: null,
                day: null
            },
            changed: false
        };
    },

    created() {
        this.getReports();
    },

    methods: {
        up(str) {
            return str && str.replace(/./, str.toUpperCase()[0]);
        },
        getReports() {
            axios('/reports').then((res) => {
                this.subjects = res.data;
            });
        },
        newReport() {
            return {
                id: null,
                subject_id: null,
                day: null
            };
        },
        editReport(x, n, property) {
            let currentReport = this.subjects[x].reports[n - 1];
            this.report = this.newReport();
            this.report.id = currentReport.id;
            this.report.subject_id = currentReport.subject_id;
            this.report[property] = currentReport[property];
            this.report.day = n;
            axios.post('/reports', this.report);
        },
        inputReport(event, property) {
            let element = event;
            this.report[property] = event;
        }
    }
};
</script>
