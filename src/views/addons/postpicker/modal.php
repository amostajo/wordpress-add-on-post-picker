<div id="post-picker-addon"
    style="display: none;"
>

    <div class="picker-modal">

        <div class="sidebar">

            <input type="text"
                placeholder="Search..."
                v-model="formData.search"
            />

        </div>

        <div class="content">

            <div class="header">

                <h2><?php echo $title ?></h2>

            </div>

            <div class="body">

                <div class="post"
                    v-repeat="results"
                >
                    <input type="checkbox"
                        name="posts[]"
                        style="display: none;"
                        value="{{ ID }}"
                    />

                    <span class="img-container">
                        <img alt="{{ title }}"
                            v-attr="src: url"
                        />
                    </span>

                    <div class="info">

                        <h3>{{ title }}</h3>
                        <p>{{ excerpt }}</p>

                    </div>

                </div>

            </div>

            <div class="footer">

                <button type="button"
                    class="button button-primary"
                ><?php _e( 'Add selected' ) ?></button>

            </div>

        </div>

    </div>

</div>
