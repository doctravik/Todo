<ul>
    <li>TodoApp</li>
    <li><a href="/tasks">Tasks</a></li>
    <li>
        <?php if (\App\Models\Auth::check()) : ?>
            <form action="/admin/logout" method="post" id="logout-form">
                <a href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout
                </a>    
            </form>
        <?php else : ?>
            <a href="/admin">Admin</a>                
        <?php endif; ?>
    </li>
</ul>
