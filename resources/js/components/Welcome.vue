<template>
<div>
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <vue-header :loggedUser="user" @getUser="user = $event"></vue-header>

        <left-aside></left-aside>

        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <!-- BEGIN: Subheader -->
                <div class="m-subheader ">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="m-subheader__title m-subheader__title--separator">{{ $t('Calendar') }}</h3>
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="#" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="" class="m-nav__link">
                                        <span class="m-nav__link-text">{{ $t('Calendar') }}</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="" class="m-nav__link">
                                        <span class="m-nav__link-text">{{ $t('Calendar') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
       
                <!-- END: Subheader -->  
                
                <div class="m-content">
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
                                <template v-if="this.user.role === 'trainee'">
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
                .then(res => res.json())
                .then(res => {
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
            fetch('/api/schedules', {
                method: 'put',
                body: JSON.stringify({ date: this.date, status: this.status }),
                headers: this.$store.state.headers
            }).then(res => {
                this.fetchSchedule();
            });
        }
    }
};
</script>
