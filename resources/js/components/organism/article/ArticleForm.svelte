<script>
    import Editor from "@tinymce/tinymce-svelte";
    import Form from "../../atoms/form/Form.svelte";
    import Panel from "../../atoms/panel/Panel.svelte";
    import ButtonActions from "../../molecules/form/ButtonActions.svelte";
    import InputLabel from "../../molecules/form/InputLabel.svelte";

    export let processing = false;
    let errors;
    export let article = {
        title: "",
        file: "",
        body: "",
        url_photo: "",
    };

    const onFileSelected = (e) => {
        let image = e.target.files[0];
        article.file = image;

        let reader = new FileReader();
        reader.readAsDataURL(image);
        reader.onload = (e) => {
            article.url_photo = e.target.result;
        };
    };
</script>

<Panel class="panel-full">
    <Form {processing} bind:errors>
        <InputLabel
            title="Título"
            name="title"
            id="title"
            errorType={errors?.title}
            bind:value={article.title}
        />
        <div>
            <label for="avatar" class="block">Foto de portada</label>
            {#if article.url_photo}
                <img
                    src={article.url_photo}
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
        <Editor
            apiKey="2b1c61f1wtvokeiudot95vc7iu0bdr8pm9rzyj8lmgdc5n1o"
            bind:value={article.body}
        />

        <ButtonActions on:save on:close permission="create_articles" />
    </Form>
</Panel>
