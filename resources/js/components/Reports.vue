<template>
    <vue-master @getUser="user = $event">
        <template slot="title">{{ $t('Reports') }}</template>
        <template slot="head-title">{{ $t('Reports') }}</template>
        <template slot="content">
            <div>
                <select name="batch" class="form-select" v-model="batch_selected">
                    <template v-for="batch in batches">
                        <option :value="batch.id">{{ batch.name }}</option>
                    </template>
                </select>
                <div class="report-section">
                    <table class="table table-with-border">
                        <thead>
                            <th class="th-trainee">{{ $t('Trainee') }}</th>
                            <th class="th-report" v-for="subject in subjects">{{ subject.name }}</th>
                            <th class="th-report">{{ $t('Review') }}</th>
                        </thead>
                        <tbody>
                            <tr v-for="trainee in reports">
                                <td>{{ trainee.name }}</td>
                                <td v-for="report in trainee.report" class="td-report">
                                    <table class="tb-report">
                                        <tbody>
                                            <tr v-for="daily_report in report">
                                                <td class="td-day">{{ frontEndDateFormat(daily_report.created_at) }}</td>
                                                <td>
                                                    <p>{{ daily_report.content }}</p>
                                                    <div>
                                                        <label for="">{{ $t('Link: ') }}</label>
                                                        <a v-bind:href="daily_report.link">{{ daily_report.link }}</a>
                                                    </div>
                                                    <div>
                                                        <label for="">{{ $t('Test: ') }}</label>
                                                        <a v-if="daily_report.test_link" v-bind:href="daily_report.link">{{ daily_report.link }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </vue-master>
</template>

<script>
export default {
    data() {
        return {
            user: {
                role: ''
            },
            reports: [''],
            batches: [''],
            batch_selected: '',
            subjects: ['']
        };
    },
    created() {
        this.getSubjects();
        this.getBatches();
    },
    watch: {
        user: function() {
            this.batch_selected = this.user.batch_id;
            this.getReports();
        },
        batch_selected: function() {
            this.getReports();
        }
    },
    methods: {
        getSubjects() {
            axios('/subjects').then((res) => {
                this.subjects = res.data.data;
            });
        },
        getReports() {
            axios(`/reports/batch/${this.batch_selected}`).then((res) => {
                this.reports = res.data.data;
            });
        },
        getBatches() {
            axios('/batches').then((res) => {
                this.batches = res.data.data;
            });
        },
        frontEndDateFormat: function(date) {
            return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        },

        backEndDateFormat: function(date) {
            return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
        }
    }
};
</script>
