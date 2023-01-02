<script>
    import { onMount } from "svelte";
    import Form from "../../../atoms/form/Form.svelte";
    import InputLabel from "../../../molecules/form/InputLabel.svelte";
    import ButtonActions from "../../../molecules/form/ButtonActions.svelte";
    // Roles que se encuentran en la base de datos
    let roles = [];
    let errors;
    // Objeto usuario para guardar en la base de datos
    export let user = {
        name: null,
        email: null,
        role: "",
    };
    export let processing;



    onMount(() => getRoles());

    function getRoles() {
        axios
            .get(route("admin.roles"))
            .then((response) => (roles = response.data));
    }
</script>

{user.role}
<Form bind:errors {processing}>
    <InputLabel
        type="text"
        name="Nombre"
        title="Nombre de usuario *"
        errorType={errors?.name}
        bind:value={user.name}
    />
    <InputLabel
        type="email"
        name="email"
        title="Correo electrónico *"
        errorType={errors?.email}
        bind:value={user.email}
    />
    <div>
        <label for="">rol</label>
        {#if roles.length > 0}
            <select
                name="role"
                id="role"
                class="border w-full p-2"
                bind:value={user.role}
            >
                <option value="" disabled>--Seleccione un rol--</option>
                {#each roles as role}
                    <option value={role.name}>{role.name}</option>
                {/each}
            </select>
        {/if}
    </div>

    <ButtonActions on:save on:close permission="create_users" />
</Form>
