<template>
    <div>
        <vue-master @getUser="user = $event">
            <template slot="title">{{ $t('Welcome') }}</template>
            <span slot="head-title">{{ $t('Calendar') }}</span>
            <template slot="content">
                <div class="m-portlet m-portlet--mobile position-relative">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">{{ $t('Daily Report') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="report-section-mini">
                            <!--begin: Datatable -->
                            <table
                                class="table table-editable table-striped- table-bordered table-hover table-checkable"
                                id="m_table_1"
                            >
                                <thead>
                                    <tr>
                                        <th>{{ $t('Subject') }}</th>
                                        <th class="th-report-content">{{ $t('Content') }}</th>
                                        <th class="th-report-item">{{ $t('Link') }}</th>
                                        <th class="th-report-item">{{ $t('Test Link') }}</th>
                                        <th class="th-report-item">{{ $t('Lesson') }}</th>
                                        <th class="th-report-item">{{ $t('Status') }}</th>
                                        <th class="th-report-item">{{ $t('Review') }}</th>
                                    </tr>
                                </thead>
                                <tbody v-for="(subject, x) in subjects" :key="x">
                                    <tr v-for="(n,index) in subject.day" :key="n">
                                        <td>
                                            <h3>{{ subject.name }}</h3>
                                            ({{ subject.day }} day)
                                            <hr>
                                            <div>Day: {{ n }}</div>
                                        </td>
                                        <template v-if="subjects[x].reports[n - 1].day == n">
                                            <td class="p-0 pl-1 pr-1">
                                                <div
                                                    class="edittor"
                                                    @click="edittingReport($event, subjects[x].reports[n - 1].id, 'content')"
                                                    v-html="subjects[x].reports[n - 1].content"
                                                ></div>
                                            </td>
                                            <td class="p-0 pl-1 pr-1">
                                                <div
                                                    class="edittor"
                                                    @click="edittingReport($event, subjects[x].reports[n - 1].id, 'link')"
                                                    v-html="subjects[x].reports[n - 1].link"
                                                ></div>
                                            </td>
                                            <td class="p-0 pl-1 pr-1">
                                                <div
                                                    class="edittor"
                                                    @click="edittingReport($event, subjects[x].reports[n - 1].id, 'test_link')"
                                                    v-html="subjects[x].reports[n - 1].test_link"
                                                ></div>
                                            </td>
                                            <td class="p-0 pl-1 pr-1">
                                                <div
                                                    class="edittor"
                                                    @click="edittingReport($event, subjects[x].reports[n - 1].id, 'lesson')"
                                                    v-html="subjects[x].reports[n - 1].lesson"
                                                ></div>
                                            </td>
                                            <td class="p-0 pl-1 pr-1">
                                                <div
                                                    class="edittor"
                                                    @click="edittingReport($event, subjects[x].reports[n - 1].id, 'status')"
                                                    v-html="subjects[x].reports[n - 1].status"
                                                ></div>
                                            </td>
                                            <td class="p-0 pl-1 pr-1">
                                                <div v-html="subjects[x].reports[n - 1].review"></div>
                                            </td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                            <ckeditor
                                ref="edittorReport"
                                v-model="content"
                                v-show="editting"
                                class="edittor"
                                @blur="editReport($event)"
                                type="balloon"
                            ></ckeditor>
                        </div>
                    </div>
                    <div class="loading" v-show="loading === true">
                        <br>
                        <span>{{ $t('Loading') }}...</span>
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
                id: null
            },
            changed: false,
            loading: true,
            editting: false,
            oldElement: '',
            oldParent: '',
            content: ''
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
            axios('/reports').then(res => {
                this.subjects = res.data;
                this.loading = false;
            });
        },
        newReport() {
            return {
                id: null,
                subject_id: null,
                day: null
            };
        },
        editReport(event) {
            let element = event.sourceElement;
            let edittor = this.$refs.edittorReport;
            let id = edittor.$el.getAttribute('data-id');
            let property = edittor.$el.getAttribute('data-property');
            this.report.id = id;
            this.report[property] = edittor.$el.innerHTML;
            this.oldElement.innerHTML = edittor.$el.innerHTML;
            element.replaceWith(this.oldElement);
            axios.post('/reports', this.report);
        },
        inputReport(event, property) {
            let element = event;
            this.report[property] = event;
        },
        edittingReport(event, id, property) {
            let element = event.currentTarget;
            this.editting = true;
            let edittor = this.$refs.edittorReport;
            edittor.$el.setAttribute('data-id', id);
            edittor.$el.setAttribute('data-property', property);
            this.content = element.innerHTML;
            let parent = element.parentElement;
            element.replaceWith(edittor.$el);
            parent.childNodes[0].focus();
            if (document.activeElement.tagName !== 'BODY') {
                this.oldParent.appendChild(this.oldElement);
            }
            this.oldElement = element;
            this.oldParent = parent;
        }
    }
};
</script>
