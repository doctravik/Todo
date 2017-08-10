<thead>
    <?php if (\App\Models\Auth::check()) : ?>
        <th></th>
    <?php endif ; ?>
    <th>Task
        <a href="?sort=content&order=asc">
            <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
        </a>
        <a href="?sort=content&order=desc">
            <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
        </a>
    </th>
    <th>Username
        <a href="?sort=username&order=asc">
            <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
        </a>
        <a href="?sort=username&order=desc">
            <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
        </a>
    </th>
    <th>Email
        <a href="?sort=email&order=asc">
            <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
        </a>
        <a href="?sort=email&order=desc">
            <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
        </a>
    </th>
    <th>Status
        <a href="?sort=is_completed&order=asc">
            <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
        </a>
        <a href="?sort=is_completed&order=desc">
            <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
        </a>
    </th>
    <th>Image</th>
    <?php if (\App\Models\Auth::check()) : ?>
        <th>Actions</th>
    <?php endif ; ?>
</thead>