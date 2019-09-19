<script>
  let user = "";
  async function register() {
    if (!user) return;

    const publicKeyCredentialCreationOptions = {
      challenge: Uint8Array.from("randomStringFromServer", c =>
        c.charCodeAt(0)
      ),
      rp: {
        name: "Thesis Security",
        id: "thesis.local"
      },
      user: {
        id: Uint8Array.from("UZSL85T9AFC", c => c.charCodeAt(0)),
        name: user,
        displayName: user
      },
      pubKeyCredParams: [{ alg: -7, type: "public-key" }],
      authenticatorSelection: {
        authenticatorAttachment: "cross-platform"
      },
      timeout: 60000,
      attestation: "none" // "direct", "indirect"
    };

    const credential = await navigator.credentials
      .create({
        publicKey: publicKeyCredentialCreationOptions
      })
      .catch(console.error);

    const params = {
      credential
    };
    const fidoCredentials = Object.keys(params)
      .map(key => {
        return encodeURIComponent(key) + "=" + encodeURIComponent(params[key]);
      })
      .join("&");

    fetch("/fidoregister", {
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
          throw new Error("Registration failed");
        }
        alert("Successful registration!");
        return response.json();
      })
      .then(console.log)
      .catch(console.error);
    console.log();
  }
</script>

<input type="text" placeholder="username" name="user" bind:value={user} />
<button type="submit" on:click={register}>Register</button>
