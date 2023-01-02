<script>
    export let name,
        data = [],
        field,
        value='professional';
</script>

<select {name} id="" bind:value class="p-3 rounded-md">
    <option value="">--Seleccione un rol--</option>
    {#each data as dato}
        <option value={dato[field]}>{dato[field]}</option>
    {/each}
</select>
