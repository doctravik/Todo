<?php $layout = 'app/views/layouts/app.view.php'; ?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">It's educational project.</h3>
            </div>
            <div class="panel-body">
                <p class="about__title"><b>Client section:</b></p>
                <ul class="about__list">
                    <li>Guest can create a new user.</li>
                    <li>Guest can create a new task for the selected user.</li>
                    <li>Guest can attach photo to the created task.</li>
                    <li>Guest can sort task by content, username, email, status.</li>
                    <li>Task's list has pagination that considers sort attribute.</li>
                </ul>

                <p class="about__title"><b>Admin section:</b></p>
                <ul class="about__list">
                    <li>Admin can edit task's content and mark task as completed.</li>
                    <li>Admin can attach new photo to the task.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
