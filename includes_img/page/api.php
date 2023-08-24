<div id="contentWrapper">

    <div id="sidebar">
        <a>Back To Top</a>
        <a>/users</a>
        <a>/users/{username}</a>
        <a>/users/{username}/images</a>
        <a>/images</a>
        <a>/images/{uuid}</a>
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