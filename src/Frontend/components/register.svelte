<script>
  import password from "./passwordRegister.svelte";
  import oauth from "./oauthRegister.svelte";
  import fido from "./fidoRegister.svelte";

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

<h1>Register</h1>
<svelte:component this={comp} />
