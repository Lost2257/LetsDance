<template>
    <div class="my-bg">

        <div class="container">
            <full-calendar
                :events="events"
                :config="config"
                :header="{
                left: 'prev,next, today',
                center: 'title',
                right: 'month,listWeek'
            }">
            </full-calendar>
            <!--        LENTELE-->
            <table class="table">

                <thead>
                <tr>
                    <th scope="col">
                        <button class="btn btn-success" data-toggle="modal" data-target="#addNew">Add event</button>
<!--                        <button class="btn btn-success" @click="newModal">Add event</button>-->
                    </th>
                    <th scope="col">
                        <p class="spalva">Eventai</p>
                    </th>
                    <th scope="col">
                        <p class="spalva">Pavadinimas</p>
                    </th>
                    <th scope="col">
                        <p class="spalva">Veiksmai</p>
                    </th>

                </tr>
                </thead>
                <tbody v-for="event in events" :key="event.id">
                <tr>
                    <th scope="row">
                        <p class="spalva">{{ event.id }}</p>
                    </th>
                    <th scope="row">
                        <p class="spalva">{{ event.start }} -> {{ event.end }}</p>
                    </th>
                    <td>
                       <p class="spalva">{{ event.title }}</p>
                    </td>
                    <td>
                    <span class="btn btn-danger" v-on:click="deleteEvent(event.id)">
                    <i class="fas fa-trash-alt"></i>
                    Delete
                    </span>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--        LENTELES PABAIGA-->
        </div>
        <!--        MODAL-->
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewLabel">Prideti eventa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent>
                            <div class="form-group">
                                <label for="event_name">Event Name</label>
                                <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="event_start">Start Date</label>
                                        <input type="datetime-local" id="event_start" class="form-control"
                                               v-model="newEvent.event_start">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="event_end">End Date</label>
                                        <input type="datetime-local" id="event_end" class="form-control"
                                               v-model="newEvent.event_end">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4" v-if="addingMode">
                                    <button class="btn btn-sm btn-primary" @click="addNewEvent">Save Event</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--        MODAL END-->
    </div>
</template>

<script>
import {FullCalendar} from 'vue-full-calendar'

export default {
    components: {
        FullCalendar
    },
    data() {
        return {
            events: [],
            newEvent: {
                event_name: "",
                event_start: "",
                event_end: "",
            },
            config: {
                locale: 'lt',
                defaultView: 'month'
            },
            addingMode: true,
            indexToUpdate: "",
            edit: false
        };
    },
    created() {
        this.getEvents();
    },
    methods: {
        addNewEvent() {
            axios
                .post("/api/calendar/save", {
                    ...this.newEvent
                })
                .then(data => {
                    this.getEvents(); //updatina musu event lista
                    this.resetForm(); //resetina iputus
                })
                .catch(err =>
                    console.log("negalima prideti ivikio", err.response.data)
                );
            $('addNew').modal('hide')
        },
        showEvent(arg) {
            this.addingMode = false;
            const {id, title, start, end} = this.events.find(
                event => event.id === +arg.event.id
            );
            this.indexToUpdate = id;
            this.newEvent = {
                event_name: title,
                event_start: start,
                event_end: end
            };
        },
        UpdateEvent() {
            axios
                .put("/api/calendar/" + this.indexToUpdate, {
                    ...this.newEvent
                })
                .then(resp => {
                    this.resetForm();
                    this.getEvents();
                    this.addingMode = !this.addingMode;
                })
                .catch(err =>
                    console.log("neupdatinsi", err.response.data)
                );
        },
        deleteEvent: function (event) {
            if (!window.confirm('ar tikrai ištrinti?')) {
                return;
            }
            try {
                axios.get('/api/delete' + event).then((response) => {
                    this.getEvents();
                })
            } catch (errors) {

            }
        },
        getEvents() {
            axios
                .get("/api/calendar")
                .then(resp => (this.events = resp.data.data))
                .catch(err => console.log(err.response.data));
        },
        resetForm() {
            Object.keys(this.newEvent).forEach(key => {
                return (this.newEvent[key] = "");
            });
        },
    },
    watch: {
        indexToUpdate() {
            return this.indexToUpdate;
        }
    }
}
</script>
