<script>
  let user = "";
  let password = "";
  function auth() {
    if (!user || !password) return;

    return fetch("/passwordlogin", {
      method: "POST",
      cache: "no-cache",
      credentials: "same-origin",
      headers: {
        "Content-Type": "application/json"
      },
      redirect: "follow",
      referrer: "no-referrer",
      body: JSON.stringify({
        username: user,
        password
      })
    })
      .then(response => {
        if (!response || !response.status || response.status !== 200) {
          throw new Error("Login failed");
        }
        alert("Successful login!");
        user = "";
        password = "";
        return response.json();
      })
      .then(console.log);
  }
</script>

<input type="text" placeholder="username" name="user" bind:value={user} />
<input
  type="password"
  placeholder="password"
  name="password"
  bind:value={password} />
<button type="submit" on:click={auth}>Sign in</button>
