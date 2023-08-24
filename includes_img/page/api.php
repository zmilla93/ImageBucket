<div id="contentWrapper">

    <div id="sidebar">
        <h4>Endpoints</h4>
        <a href="api/#_users">/users</a>
        <a href="api/#_users_username">/users/{username}</a>
        <a href="api/#_users_username_images">/users/{username}/images</a>
        <a href="api/#_images">/images</a>
        <a href="api/#_images_uuid">/images/{uuid}</a>
        <!-- <br> -->
        <a href="api/#" onclick="scrollToTop();">Back To Top</a>
    </div>

    <div id="apiWrapper">

        <div class="entryWrapper apiInfo">
            <h1>ImageBucket API</h1>
            <p>
                The ImageBucket API allows you to fetch information about users and images.
                <br>
                All API calls should be made to <code>https://img.zrmiller.com/api/{endpoint}</code>.
            </p>
        </div>

        <?php
        // NOTE : If reading files seems slow, look into curl_multi_exec
        // https://www.php.net/manual/en/function.curl-multi-exec.php

        // Dependencies
        include "classes/Node.php";
        include "classes/Doc.php";

        // Output all documentation
        include "api/documentation.php";

        ?>

    </div>

</div>

<!-- </div> -->