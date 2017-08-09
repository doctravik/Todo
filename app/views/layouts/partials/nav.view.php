<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="/">TodoApp</a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
                <li><a href="/tasks">Tasks</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <?php if (\App\Models\Auth::check()) : ?>
                    <li>
                        <a href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout
                        </a>

                        <form action="/admin/logout" method="post" id="logout-form"></form>
                    </li>
                <?php else : ?>
                    <li><a href="/admin">Admin</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
