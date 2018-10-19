<template>
<div>
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <vue-header></vue-header>

        <left-aside></left-aside>

        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <!-- END: Subheader -->
                <div class="m-content">
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{ $t('report.Daily')}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                                <thead>
                                    <tr>
                                        <th>{{ $t('report.Subject') }}</th>
                                        <th>{{ $t('report.Content') }}</th>
                                        <th>{{ $t('report.Link') }}</th>
                                        <th>{{ $t('report.Lesson') }}</th>
                                        <th>{{ $t('report.Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody v-for="subject in subjects" :key="subject.id">
                                    <tr v-for="(n,index) in subject.day" :key="n">
                                        <td>
                                            <h3>{{ subject.name }}</h3> ({{ subject.day }} day)
                                            <hr>
                                            <div>Day: {{ n }}</div>
                                        </td>
                                        <td>
                                            <div v-for="report in reports">
                                                <item v-for="item in report.data" v-if="item.subject_id == subject.id && item.day == n" :key="item.id" :content="item.content" :id="item.id" :column="'content'" @doneEdit="doneEdit">
                                                </item>
                                           </div>
                                        </td>
                                       <td>
                                            <div v-for="report in reports">
                                                <item v-for="item in report.data" v-if="item.subject_id == subject.id && item.day == n" :key="item.id" :content="item.link" :id="item.id" :column="'link'" @doneEdit="doneEdit">
                                                </item>
                                           </div>
                                        </td>
                                        <td>
                                            <div v-for="report in reports">
                                                <item v-for="item in report.data" v-if="item.subject_id == subject.id && item.day == n" :key="item.id" :content="item.lesson" :id="item.id" :column="'lesson'" @doneEdit="doneEdit">
                                                </item>
                                           </div>
                                        </td>
                                        <td>
                                            <div v-for="report in reports">
                                                <item v-for="item in report.data" v-if="item.subject_id == subject.id && item.day == n" :key="item.id" :content="item.status" :id="item.id" :column="'status'" @doneEdit="doneEdit">
                                                </item>
                                           </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
import item from './itemReport'
export default {
    components: {
        item
    },

    data () {
        return {
            subjects: [],
            reports: [],
            editReport: false,
            currentStatus: ''
        }
    },

    created() {
        var _vm = this;
        this.$store.dispatch('reports/getSubjects')
        .then(res => {
            this.subjects = res.data.data
        })
        .then(res => {
            this.getReportsBySubject()
        })

    },

    methods: {
        getReportsBySubject () {
            for(var i = 0; i < this.subjects.length; i++) {
                this.$store.dispatch('reports/getReportsBySubject', {
                    subject_id: this.subjects[i].id
                })
                .then(res => {
                    this.reports.push(res)
                })
            }
        },

        doneEdit (data) {
            this.$store.dispatch('reports/edit', data)
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
