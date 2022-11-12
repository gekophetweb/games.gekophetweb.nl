
    <form method="post">
        <div class="input-block">
            <input type="text" name="user" value="" placeholder="user">
        </div>
        <div class="input-block">
            <input type="password" name="password" placeholder="password">
        </div>
        <div class="">
            <input type="submit" value="login">
            <input type="hidden" name="token" value="<?= $token ?>">
        </div>
    </form>

