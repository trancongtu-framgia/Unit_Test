<template>
<div>
    <vue-master @getUser="user = $event">
        <template slot="title">
            {{ $t('Welcome') }}
        </template>
        <span slot="head-title">{{ $t('Calendar') }}</span>
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
                                    <h3 class="m-portlet__head-text">
                                        {{ $t('Calendar') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <template v-if="isTrainee(user)">
                            <div class="m-portlet__body">
                                <full-calendar ref="calendar" @event-selected="showEdit" :events="events" :config="config" :header="header"></full-calendar>
                            </div>
                            <select ref="editCalendar" v-show="editting" name="status" class="form-select col-md-9" v-model="status" @change="changeStatus">
                                <option value="0">{{ $t('Skip') }}</option>
                                <option value="1">{{ $t('Morning') }}</option>
                                <option value="2">{{ $t('Afternoon') }}</option>
                                <option value="3">{{ $t('Fulltime') }}</option>
                            </select>                                    
                        </template>
                        <template v-else>
                            <div class="m-portlet__body">
                                <full-calendar ref="calendar" :events="events" :config="config" :header="header"></full-calendar>
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
                defaultView: 'month'
            },
            header: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            editting: false,
            status: '',
            oldstatus: '',
            date: ''
        };
    },

    created() {
        this.fetchSchedule();
    },

    methods: {
        fetchSchedule() {
            fetch('/api/schedules', {
                headers: this.$store.state.headers
            })
                .then((res) => res.json())
                .then((res) => {
                    let self = this;
                    res.data.forEach(function(event) {
                        event.title = self.$t(event.title);
                        if (event.count) {
                            event.title = event.title + ' : ' + event.count;
                        }
                    });
                    this.events = res.data;
                });
        },
        showEdit: function(date, jsEvent, view) {
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
            for (var i = 0; i < element.childNodes.length; i++) {
                let ele = element.childNodes[i];
                if (element.childNodes[i].innerHTML === note.innerHTML) {
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
            }).then((res) => {
                this.fetchSchedule();
            });
        }
    }
};
</script>
