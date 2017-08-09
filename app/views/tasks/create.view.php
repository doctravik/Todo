<form action="/tasks" method="POST">
    <div>
        <input type="text" name="username" placeholder="User name">
        <span><?= errors('username')->first() ; ?></span>
    </div>
    <div>
        <input type="email" name="email" placeholder="Email">
        <span><?= errors('email')->first() ; ?></span>        
    </div>
    <div>
        <textarea name="content" placeholder="Task content"></textarea>
        <span><?= errors('content')->first() ; ?></span>          
    </div>
    <button type="submit">Create task</button>
</form>