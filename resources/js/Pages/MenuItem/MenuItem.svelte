<script>
    import { Inertia } from "@inertiajs/inertia";

    export let item;
    export let index;

    function edit() {
        Inertia.get(
            route("menu-items.edit", {
                menu_item: item,
            })
        );
    }
</script>

<div class="grid grid-cols-5 py-4 px-2">
    <p>{item.title}</p>
    <p class="break-words">{item.path}</p>
    <p>{item.created_at}</p>
    <p>{item.updated_at}</p>
    <div>
        <button on:click={edit} class="text-blue-600">Editar</button>
        <button
            class="text-red-600"
            on:click={() =>
                Inertia.delete(
                    route("articles.destroy", {
                        menu_item: item.id,
                    })
                )}>Eliminar</button
        >
    </div>
</div>
