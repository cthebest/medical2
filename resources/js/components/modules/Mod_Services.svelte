<script>
    // Default theme
    import { Splide, SplideSlide } from "@splidejs/svelte-splide";
    import "@splidejs/svelte-splide/css";
    import axios from "axios";
    import { onMount } from "svelte";
    export let services = [];

    onMount(() => getServices());

    function getServices() {
        axios
            .get(route("services.getAll"))
            .then((response) => (services = response.data));
    }
</script>

<div class="container mx-auto px-4 py-8">
    <div
        class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center content-center"
    >
        {#each services as service}
            <div class="bg-white rounded-lg p-8">
                <img
                    src={service.image_uri}
                    class="rounded-full w-32 h-32 mx-auto object-cover bg-[#006699]"
                />
                <h3 class="text-lg font-medium mt-4 text-center">
                    {service.title}
                </h3>
                <p class="text-gray-700 mt-2 text-center">
                    {service.description}
                </p>
                <div class="flex justify-center">
                    <button class="p-2 rounded-md bg-[#c7f768]"
                        >Más información</button
                    >
                </div>
            </div>
        {/each}
    </div>
</div>
