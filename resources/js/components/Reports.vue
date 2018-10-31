<template>
    <vue-master @getUser="user = $event">
        <template slot="title">{{ $t('Reports') }}</template>
        <!-- <template slot="head-title">{{ $t('Reports') }}</template> -->
        <template slot="content">
            <div>
                <select name="batch" class="form-select mb-3" v-model="batch_selected">
                    <template v-for="batch in batches">
                        <option :value="batch.id">{{ batch.name }}</option>
                    </template>
                </select>
                <div class="report-section">
                    <table class="table table-with-border">
                        <thead>
                            <th class="th-trainee">{{ $t('Trainee') }}</th>
                            <th class="th-report" v-for="subject in subjects">{{ subject.name }}</th>
                        </thead>
                        <tbody>
                            <tr v-for="trainee in reports">
                                <td>{{ trainee.name }}</td>
                                <td v-for="reports in trainee.reports" class="td-report">
                                    <table class="tb-report">
                                        <thead v-if="reports.length > 0">
                                            <tr>
                                                <th>{{ $t('Date') }}</th>
                                                <th class="daily-report">{{ $t('Report') }}</th>
                                                <th>{{ $t('Review') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="daily_report in reports">
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
                                                <td @dblclick="show(daily_report, $event)" nochilddrag>
                                                    <span v-html="daily_report.review"></span>
                                                    <div class="d-none">
                                                        <ckeditor type="classic" v-bind:value="daily_report.review" v-model="review.content"></ckeditor>
                                                        <button class="btn btn-success" @click="submitReview(daily_report.review, $event)">{{ $t('Save') }}</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
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
            subjects: [''],
            review: {
                id: '',
                report_id: '',
                user_id: '',
                content: ''
            },
            editting: false
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
        submitReview(value, event) {
            let element = event.currentTarget.parentElement;
            element.parentElement.children[0].innerHTML = this.review.content;
            axios.put('/reviews', {
                id: this.review.id,
                report_id: this.review.report_id,
                user_id: this.review.user_id,
                content: this.review.content
            });

            element.classList.add('d-none');
            element.parentElement.children[0].classList.remove('d-none');
            this.editting = false;
        },
        show(daily_report, event) {
            if (this.editting == true) {
                return;
            }

            this.editting = true;

            this.review.id = daily_report.review_id;
            this.review.report_id = daily_report.id;
            this.review.user_id = this.user.id;

            let element = event.currentTarget;
            this.review.content = event.currentTarget.children[0].innerHTML;
            element.children[0].classList.add('d-none');
            element.children[1].classList.remove('d-none');
        },
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
