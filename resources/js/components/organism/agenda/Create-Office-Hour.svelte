<script>
    import { onMount } from "svelte";
    import Modal from "../../molecules/modal/Modal.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Intervals from "./timer/Intervals.svelte";
    import Form from "../../atoms/form/Form.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import { page } from "@inertiajs/inertia-svelte";
    let weekdays = [];
    let officeHours = { weekdays: [], intervals: [{}] };
    let processing = false;

    function store() {
        let officeHour = officeHours.weekdays.map((weekday) => {
            return { id: weekday, values: officeHours.intervals };
        });
        Inertia.post(
            route("office-hours.store", {
                resource_user: $page.props.query.resource_user, // TODO este es el id del usuario autenticado
                dialog: "create-office-hours",
                view: $page.props.query.view,
            }),
            {
                officeHours: officeHour,
            },
            {
                onStart: () => {
                    processing = true;
                },
                onFinish: () => {
                    processing = false;
                },
            }
        );
    }

    function close() {
        Inertia.get(
            route("agenda.index", {
                resource_user: $page.props.query.resource_user,
                dialog: "show-office-hours",
                view: $page.props.query.view,
            })
        );
    }

    onMount(() => getWeekdays());

    function getWeekdays() {
        axios
            .get(
                route("agenda.getWeekdays", {
                    resource_user: $page.props.query.resource_user,
                })
            )
            .then((response) => (weekdays = response.data));
    }

    function removeEntry(index) {
        officeHours.intervals = officeHours.intervals.filter(
            (e, i) => i !== index
        );
    }

    function addEntry() {
        if (
            !officeHours.intervals[officeHours.intervals.length - 1]
                .start_time ||
            !officeHours.intervals[officeHours.intervals.length - 1].end_time
        ) {
            alert("Por favor, ingrese datos en horario inicial y final");
            return;
        }
        officeHours.intervals.push({});
        officeHours.intervals = officeHours.intervals;
    }
</script>

<Modal>
    <h1>Nuevo horario laboral</h1>
    <Form>
        {#if weekdays.length > 0}
            <div class="max-h-56 overflow-y-auto">
                <div class="flex space-x-2">
                    {#each weekdays as weekday}
                        <div>
                            <label for="workdays_id" class="block"
                                >{weekday.name}
                            </label>
                            <input
                                type="checkbox"
                                name="workdays_id"
                                id="workdays_id"
                                value={weekday.id}
                                bind:group={officeHours.weekdays}
                            />
                        </div>
                    {/each}
                </div>
                {#each officeHours.intervals as interval, index}
                    <Intervals
                        on:add={addEntry}
                        on:delete={() => removeEntry(index)}
                        bind:interval
                        {index}
                        bind:intervals={officeHours.intervals}
                    />
                {/each}
            </div>
        {:else}
            <span class="text-red-500 italic"
                >No existen días disponibles para agregar un horario laboral</span
            >
        {/if}
    </Form>
    <ButtonActions
        on:save={store}
        on:close={close}
        permission="create_office_hours"
    />
</Modal>
