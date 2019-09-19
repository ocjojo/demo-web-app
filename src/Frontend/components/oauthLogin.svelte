<script>
  function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log("ID: " + profile.getId()); // Don't send this directly to your server!
    console.log("Full Name: " + profile.getName());
    console.log("Given Name: " + profile.getGivenName());
    console.log("Family Name: " + profile.getFamilyName());
    console.log("Image URL: " + profile.getImageUrl());
    console.log("Email: " + profile.getEmail());

    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    console.log("ID Token: " + id_token);

    const params = {
      email: profile.getEmail(),
      token: id_token
    };
    const oauthCredentials = Object.keys(params)
      .map(key => {
        return encodeURIComponent(key) + "=" + encodeURIComponent(params[key]);
      })
      .join("&");

    fetch("/oauthlogin", {
      method: "POST",
      cache: "no-cache",
      credentials: "same-origin",
      headers: {
        "Content-Type": "application/json"
      },
      redirect: "follow",
      referrer: "no-referrer",
      body: oauthCredentials
    })
      .then(response => {
        if (!response || !response.status || response.status !== 200) {
          throw new Error("Authentication failed");
        }
        alert("Successful login!");
        return response.json();
      })
      .then(console.log);
  }
</script>

<svelte:head>
  <meta name="google-signin-scope" content="profile email" />
  <meta
    name="google-signin-client_id"
    content="51421602149-2e475m1bndhn7kfqtrjkjjrhpnes262l.apps.googleusercontent.com" />
  <script src="https://apis.google.com/js/platform.js" async defer>

  </script>
</svelte:head>

<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark" />
