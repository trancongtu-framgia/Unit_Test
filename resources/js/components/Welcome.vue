<template>
    <div>
        <vue-master @getUser="user = $event">
            <template slot="title">{{ $t('Welcome') }}</template>
            <template slot="content">
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Portlet-->
                        <div class="m-portlet" id="m_portlet">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon">
                                            <i class="flaticon-calendar-2"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">{{ $t('Calendar') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <template v-if="trainee">
                                <div class="m-portlet__body">
                                    <full-calendar
                                        ref="calendar"
                                        @event-selected="showEdit"
                                        :events="events"
                                        :config="config"
                                        :header="header"
                                    ></full-calendar>
                                </div>
                                <div ref="editCalendar" v-show="editting">
                                    <select
                                        name="status"
                                        class="form-select col-md-7"
                                        v-model="status"
                                        @change="changeStatus"
                                    >
                                        <option value="0" selected>{{ $t('Skip') }}</option>
                                        <option value="1">{{ $t('Morning') }}</option>
                                        <option value="2">{{ $t('Afternoon') }}</option>
                                        <option value="3">{{ $t('Fulltime') }}</option>
                                    </select>
                                    <button
                                        class="btn btn-primary"
                                        @click="cancel($event)"
                                    >{{ $t('Cancel') }}</button>
                                </div>
                            </template>
                            <template v-if="isTrainer">
                                <div class="col-md-5">
                                    <select v-model="selected_batch" class="form-control">
                                        <option
                                            v-for="batch in batches"
                                            :value="batch.id"
                                        >{{ batch.name }}</option>
                                    </select>
                                </div>
                                <div class="m-portlet__body">
                                    <full-calendar
                                        ref="calendar"
                                        @event-render="eventRender"
                                        :events="events"
                                        :config="config"
                                        :header="header"
                                    ></full-calendar>
                                </div>
                            </template>
                        </div>

                        <!--end::Portlet-->
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
            user: {
                role: ''
            },
            events: [''],
            config: {
                defaultView: 'month',
                eventStartEditable: false,
                hiddenDays: [0, 6]
            },
            header: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            selected_batch: '',
            batches: [''],
            editting: false,
            status: '',
            oldstatus: '',
            date: '',
            trainee: false,
            isTrainer: false,
            oldElement: ''
        };
    },
    watch: {
        user: function() {
            if (this.isTrainee(this.user)) {
                this.trainee = true;
                if (this.user.batch_id !== '')
                    this.selected_batch = this.user.batch_id;
            } else {
                this.isTrainer = true;
            }
        },
        selected_batch: function() {
            this.fetchSchedule();
        }
    },

    created() {
        this.fetchBatches();
    },

    methods: {
        fetchBatches() {
            axios('/batches').then(res => {
                this.batches = res.data.data;
                if (this.user.role) this.selected_batch = this.batches[0].id;
            });
        },
        eventRender: function(event, jsEvent, view) {
            let users = event.users;
            $(jsEvent).tooltip({
                title: function() {
                    let title = '';
                    users.forEach(function(user) {
                        title += `<p>${user.name}</p>`;
                    });

                    return title;
                },
                placement: 'auto',
                html: true,
                trigger: 'hover',
                container: 'body'
            });
        },
        fetchSchedule() {
            let url = 'schedules/';
            url += this.isTrainee(this.user)
                ? `user/${this.user.id}`
                : `batch/${this.selected_batch}`;

            axios(url).then(res => {
                let self = this;
                res.data.data.forEach(function(event) {
                    event.title = self.$t(event.title);
                    if (event.count) {
                        event.title = event.title + ' : ' + event.count;
                    }
                });
                this.editting = false;
                this.events = res.data.data;
            });
        },
        showEdit: function(date, jsEvent, view) {
            let today = new Date();
            let day = new Date(date.start._i);
            day.setHours(0, 0, 0);
            today.setHours(0, 0, 0);

            if (this.editting === true || day < today) {
                return;
            }

            this.editting = true;
            let element = this.$refs.editCalendar;
            this.date = date.start._i;
            let doc = jsEvent.target;
            let note = null;
            if (doc.className === 'fc-title') {
                note = doc;
            } else {
                for (var i = 0; i < doc.childNodes.length; i++) {
                    if (doc.childNodes[i].className == 'fc-title') {
                        note = doc.childNodes[i];
                        break;
                    }
                }
            }
            let select = element.childNodes[0];
            for (var i = 0; i < select.childNodes.length; i++) {
                let ele = select.childNodes[i];
                if (select.childNodes[i].innerHTML === note.innerHTML) {
                    this.status = ele.value;
                    this.oldstatus = this.status;
                    break;
                }
            }
            let parent = jsEvent.target;
            while (parent) {
                if (parent.className === 'fc-event-container') break;
                parent = parent.parentElement;
            }
            this.oldElement = parent.childNodes[0];
            parent.childNodes[0].replaceWith(element);
        },
        changeStatus() {
            if (this.oldstatus != 0) {
                if (
                    !confirm(this.$t('Are you sure want to change schedule?'))
                ) {
                    this.fetchSchedule();

                    return;
                }
            }

            fetch('/api/schedules', {
                method: 'put',
                body: JSON.stringify({ date: this.date, status: this.status }),
                headers: this.$store.state.headers
            }).then(res => {
                this.fetchSchedule();
            });
        },
        cancel(event) {
            let element = event.target.parentElement;
            element.replaceWith(this.oldElement);
            this.editting = false;
        }
    }
};
</script>
