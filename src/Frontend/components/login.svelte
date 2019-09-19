<script>
  import password from "./passwordLogin.svelte";
  import oauth from "./oauthLogin.svelte";
  import fido from "./fidoLogin.svelte";

  export let auth;
  let comp = password;
  $: if (auth === "oauth") {
    comp = oauth;
  } else if (auth === "fido2") {
    comp = fido;
  } else {
    comp = password;
  }
</script>

<h1>Sign In</h1>
<svelte:component this={comp} />
