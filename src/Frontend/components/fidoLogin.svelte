<script>
  let user = "";
  async function auth() {
    if (!user) return;

    const publicKeyCredentialRequestOptions = {
      challenge: Uint8Array.from("randomStringFromServer", c =>
        c.charCodeAt(0)
      ),
      allowCredentials: [
        {
          id: Uint8Array.from(
            "LuNxHbNCmgnGnMpSS3OTYiE-8iq7KTvoDwwaSNUlQkzD5S6VvSdG7nwVXHODw7f9",
            c => c.charCodeAt(0)
          ),
          type: "public-key",
          transports: ["usb", "ble", "nfc"]
        }
      ],
      timeout: 60000
    };

    const assertion = await navigator.credentials
      .get({
        publicKey: publicKeyCredentialRequestOptions
      })
      .catch(console.error);

    const fidoCredentials = Object.keys(assertion)
      .map(key => {
        return (
          encodeURIComponent(key) + "=" + encodeURIComponent(assertion[key])
        );
      })
      .join("&");

    fetch("/fidologin", {
      method: "POST",
      cache: "no-cache",
      credentials: "same-origin",
      headers: {
        // "Content-Type": "application/json"
        "Content-Type": "application/x-www-form-urlencoded"
      },
      redirect: "follow",
      referrer: "no-referrer",
      body: fidoCredentials
    })
      .then(response => {
        if (!response || !response.status || response.status !== 200) {
          throw new Error("Login failed");
        }
        alert("Successful login!");
        return response.json();
      })
      .then(console.log)
      .catch(console.error);
    console.log();

    console.log(assertion);
  }
</script>

<input type="text" placeholder="username" name="user" bind:value={user} />
<button type="submit" on:click={auth}>Sign in</button>
