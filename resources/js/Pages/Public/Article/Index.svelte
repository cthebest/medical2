<script>
    import { Inertia } from "@inertiajs/inertia";
    import { LightPaginationNav } from "svelte-paginate";
    import PublicLayout from "../../../components/organism/layout/public/PublicLayout.svelte";
    export let articles;
    let currentPage = articles.current_page;
    function truncateString(str, num) {
        if (str.length > num) {
            return str.slice(0, num) + "...";
        } else {
            return str;
        }
    }
</script>

<PublicLayout>
    <div>
        <div class="grid grid-cols-4 gap-4 w-full">
            {#each articles.data as article}
                <a href={article.url}>
                    <div class="h-64">
                        {#if article.url_photo}
                            <img src={article.url_photo} alt="" />
                        {/if}
                        <div class="p-2">
                            <h3 class="font-bold text-xl">{article.title}</h3>
                            <p>{@html truncateString(article.body, 100)}</p>
                        </div>
                    </div>
                </a>
            {/each}
        </div>
        <LightPaginationNav
            totalItems={articles.total}
            pageSize={articles.per_page}
            {currentPage}
            limit={1}
            showStepOptions={true}
            on:setPage={(e) => {
                const params = new URLSearchParams({
                    page: e.detail.page,
                });
                Inertia.get("articulos?" + params.toString());
                currentPage = e.detail.page;
            }}
        />
    </div>
</PublicLayout>
