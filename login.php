<form action="" method="post">
    <h2>Login:</h2>
    <label>Brugernavn;</labek>
    <input type="text" name="username" placeholder="Brugernavn">
    <label>Password</label>
    <input type="password" name="password" placeholder="password">
    <button type="submit">Login</button>
    <p style="color: red"><?=@$errorMsg;?></p>
</form>