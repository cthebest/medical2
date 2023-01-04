<script>
    // Default theme
    import { Splide, SplideSlide } from "@splidejs/svelte-splide";
    import "@splidejs/svelte-splide/css";
</script>

<div class="flex justify-center w-full">
    <Splide
        options={{
            rewind: true,
            width: 900,
            gap: "1rem",
            perPage: 3,
        }}
    >
        <SplideSlide>
            <li class="h-64 w-60  flex flex-col items-center">
                <div class="rounded-full  w-40 h-40 bg-[#006699]">
                    <img src="" alt="" />
                </div>
                <span class="text-center w-full text-[#006699] ">
                    Evaluación y tratamiento de neurologia
                </span>
            </li>
        </SplideSlide>
        <SplideSlide>
            <li class="h-64 w-60  flex flex-col items-center">
                <div class="rounded-full  w-40 h-40 bg-[#006699]">
                    <img src="" alt="" />
                </div>
                <span class="text-center w-full text-[#006699]">
                    Estudios de encefalograma digital y mapeo cerebral
                </span>
            </li>
        </SplideSlide>
        <SplideSlide>
            <li class="h-64 w-60  flex flex-col items-center">
                <div class="rounded-full  w-40 h-40 bg-[#006699]">
                    <img src="" alt="" />
                </div>
                <span class="text-center w-full text-[#006699]">
                    Potenciales visuales y auditivos
                </span>
            </li>
        </SplideSlide>
    </Splide>
</div>
