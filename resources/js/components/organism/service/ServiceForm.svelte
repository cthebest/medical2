<script>
    import Editor from "@tinymce/tinymce-svelte";
    import Select from "svelte-select/Select.svelte";
    import Form from "../../atoms/form/Form.svelte";
    import FormGroup from "../../atoms/group/FormGroup.svelte";
    import Panel from "../../atoms/panel/Panel.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import InputLabel from "../../molecules/form/InputLabel.svelte";
    import { onMount } from "svelte";
    export let processing = false;
    let errors;
    const limit = 120;
    let diff = limit;
    let resources = [];
    export let service = {
        title: null,
        description: null,
        file: null,
        image,
        resource: null,
    };

    const onFileSelected = (e) => {
        let image = e.target.files[0];
        service.file = image;

        let reader = new FileReader();
        reader.readAsDataURL(image);
        reader.onload = (e) => {
            service.image_uri = e.target.result;
        };
    };

    function handleInput(event) {
        let count = event.target.value.length;
        diff = limit - count;
        if (count > limit) {
            service.description = event.target.value.substring(0, limit);
        } else {
            service.description = event.target.value;
        }
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
            .get(route("articles.getArticles"))
            .then((response) => (resources = response.data));
    }

    onMount(() => getResources());
</script>

<Panel class="panel-full">
    <Form {processing} bind:errors>
        <InputLabel
            title="Título"
            name="title"
            id="title"
            errorType={errors?.title}
            bind:value={service.title}
        />
        <div>
            <label for="avatar" class="block">Foto de portada</label>
            {#if service.image_uri}
                <img
                    src={service.image_uri}
                    alt=""
                    class="w-32 h-32 object-contain"
                />
            {:else}
                <img
                    class="w-32 h-32"
                    src="https://cdn4.iconfinder.com/data/icons/small-n-flat/24/user-alt-512.png"
                    alt=""
                />
            {/if}
            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/png, image/jpeg"
                on:change={(e) => onFileSelected(e)}
            />
        </div>
        {#if resources.length > 0}
            <FormGroup class="group">
                <label for="">Recurso</label>
                <Select
                    items={resources}
                    itemId="id"
                    label="title"
                    showChevron={true}
                    placeholder="--Seleccione un recurso--"
                    bind:value={service.resource}
                />
            </FormGroup>
        {/if}
        <div>
            <label for="">Descripción (caracteres restantes: {diff})</label>
            <textarea
                name="description"
                id="description"
                cols="30"
                rows="10"
                class="border w-full rounded-md"
                bind:value={service.description}
                on:input={handleInput}
            />
        </div>

        <ButtonActions on:save on:close permission="create_services" />
    </Form>
</Panel>
