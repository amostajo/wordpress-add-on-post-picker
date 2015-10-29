<div id="post-picker-addon"
    style="display: none;"
    data-url="<?php echo admin_url( 'admin-ajax.php?action=addon_post_picker' ) ?>"
>

    <div class="picker-modal">

        <div class="sidebar">

            <form v-on:submit="onSubmit">

                <input type="text"
                    placeholder="Search [press enter]"
                    v-model="filter.search"
                />

                <div class="form-group">
                    <label for="limit">Limit results to:</label>
                    <select id="limit"
                        v-model="filter.limit"
                        v-on:change="onSubmit"
                    >
                        <option value="8" selected>8 posts</option>
                        <option value="16" selected>16 posts</option>
                        <option value="24">24 posts</option>
                        <option value="32">32 posts</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type">Post type:</label>
                    <select id="type"
                        v-model="filter.type"
                        v-on:change="onSubmit"
                    >
                        <?php foreach ($types as $type) { ?>
                            <option value="<?php echo $type->name ?>"
                                <?php if ($type->name == 'post') { ?>selected<?php }?>
                            >
                                <?php echo $type->label ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

            </form>

        </div>

        <div class="content">

            <div class="header">

                <a class="close"
                    v-on:click="onClose"
                >
                    <i class="fa fa-times"></i>
                </a>

                <h2>
                    <?php echo $title ?>
                    <span class="loader" v-show="isLoading">
                        <i class="fa fa-refresh fa-spin"></i>
                    </span>
                </h2>

            </div>

            <div class="body">

                <div class="post post-{{ post.ID }}"
                    v-for="post in results"
                    v-on:click="onSelect($index)"
                    v-bind:class="{ selected: post.selected }"
                >
                    <span class="img-container">
                        <img alt="{{ post.title }}"
                            v-show="post.thumb_image_url"
                            v-bind:src="post.thumb_image_url"
                        />
                        <span class="img-sub" v-show="!post.thumb_image_url"></span>
                        <span class="indicator selected">
                            <i class="fa fa-check"></i>
                        </span>
                        <span class="indicator deselect">
                            <i class="fa fa-times"></i>
                        </span>
                    </span>

                    <div class="info">

                        <h3>{{ post.title }}</h3>
                        <p>{{ post.excerpt }}</p>

                    </div>

                </div>

            </div>

            <div class="footer">

                <button type="button"
                    class="button button-primary"
                    v-on:click="onAddSelection"
                ><?php _e( 'Add selected' ) ?></button>

            </div>

        </div>

    </div>

</div>
