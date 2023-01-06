<script>
    import Form from "../../atoms/form/Form.svelte";
    import Panel from "../../atoms/panel/Panel.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import InputLabel from "../../molecules/form/InputLabel.svelte";
    import { onMount } from "svelte";
    import Select from "svelte-select";
    import FormGroup from "../../atoms/group/FormGroup.svelte";

    export let processing = false;

    let errors;
    let components = [];
    let resources = [];

    const itemId = "id";

    export let menuItem = {
        title: null,
        icon: "",
        module: "",
        resource: "",
    };

    onMount(() => {
        getComponents();
        if (menuItem.module) getResources();
    });

    function getComponents() {
        axios
            .get(route("components"))
            .then((response) => (components = response.data));
    }

    /**
     * Reset the resources array and the resource property of the
     * menuItem object, and then fetch new resources.
     *
     * @returns {undefined}
     */
    function selectedModule() {
        resources = [];
        menuItem.resource = "";
        getResources();
    }
    /**
     * Fetch resources for the current module and store them in the
     * resources array.
     *
     * @returns {undefined}
     */
    function getResources() {
        // Make an HTTP GET request to the specified route, passing
        // the current module's ID as a parameter
        axios
            .get(
                route("components.resources", {
                    module_id: menuItem.module.id,
                })
            )
            .then((response) => (resources = response.data));
    }
</script>

<Panel class="panel-full">
    <Form {processing} bind:errors>
        <InputLabel
            title="Título"
            name="title"
            id="title"
            errorType={errors?.title}
            bind:value={menuItem.title}
        />

        <InputLabel
            title="Ícono"
            name="icon"
            id="icon"
            errorType={errors?.icon}
            bind:value={menuItem.icon}
        />

        <FormGroup class="group">
            <label for="">Módulos</label>
            <Select
                {itemId}
                items={components}
                showChevron={true}
                placeholder="--Seleccione un módulo--"
                bind:value={menuItem.module}
                on:change={selectedModule}
            />
        </FormGroup>

        {#if resources.length > 0}
            <FormGroup class="group">
                <label for="">Recurso</label>
                <Select
                    items={resources}
                    {itemId}
                    label="title"
                    showChevron={true}
                    placeholder="--Seleccione un recurso--"
                    bind:value={menuItem.resource}
                />
            </FormGroup>
        {/if}

        <ButtonActions on:save on:close permission="create_menu_items" />
    </Form>
</Panel>
