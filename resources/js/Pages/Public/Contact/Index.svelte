<script>
    import { Inertia } from "@inertiajs/inertia";
    import ButtonPrimary from "../../../components/atoms/buttons/ButtonPrimary.svelte";
    import Form from "../../../components/atoms/form/Form.svelte";
    import Panel from "../../../components/atoms/panel/Panel.svelte";
    import InputLabel from "../../../components/molecules/form/InputLabel.svelte";
    import PublicLayout from "../../../components/organism/layout/public/PublicLayout.svelte";
    import { page } from "@inertiajs/inertia-svelte";
    export let errors;
    let contactUs = {};
    let processing = false;
    function sendMessage() {
        Inertia.post(route("contacts.send"), contactUs);
    }
</script>

<Panel class="panel-md">
    <Form {processing}>
        <h1>Contactenos</h1>
        <InputLabel
            title="Nombre *"
            type="text"
            name="name"
            errorType={errors?.name}
            bind:value={contactUs.name}
        />
        <InputLabel
            title="Email *"
            type="email"
            name="email"
            errorType={errors?.email}
            bind:value={contactUs.email}
        />

        <ButtonPrimary on:click={sendMessage}>Enviar mensaje</ButtonPrimary>
    </Form>
</Panel>
