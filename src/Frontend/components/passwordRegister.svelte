<script>
  let user = "";
  let password = "";
  function register() {
    if (!user || !password) return;

    const parameters = {
      username: user,
      password
    };
    const loginParameters = Object.keys(parameters)
      .map(key => {
        return (
          encodeURIComponent(key) + "=" + encodeURIComponent(parameters[key])
        );
      })
      .join("&");

    return fetch("/passwordregister", {
      method: "POST",
      cache: "no-cache",
      credentials: "same-origin",
      headers: {
        // "Content-Type": "application/json"
        "Content-Type": "application/x-www-form-urlencoded"
      },
      redirect: "follow",
      referrer: "no-referrer",
      body: loginParameters
    })
      .then(response => {
        if (!response || !response.status || response.status !== 200) {
          throw new Error("Registration failed");
        }
        alert("Successful registration!");
        user = "";
        password = "";
        return response.json();
      })
      .then(console.log)
      .catch(console.error);
  }
</script>

<input type="text" placeholder="username" name="user" bind:value={user} />
<input
  type="password"
  placeholder="password"
  name="password"
  bind:value={password} />
<button type="submit" on:click={register}>Register</button>
