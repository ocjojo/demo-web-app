<script>
  import login from "./components/login.svelte";
  import register from "./components/register.svelte";

  let mech = "register";
  let auth = "password";
  $: isLogin = mech === "login";
  $: comp = isLogin ? login : register;
  $: other = isLogin ? "register" : "login";

  function changeAuth(a) {
    auth = a;
  }
</script>

<style>
  .container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%);
    background: #fff;
    border-radius: 1rem;
    max-width: 380px;
    display: flex;
    flex-direction: column;
    align-items: center;

    margin: 0 auto;
    padding: 20px;
  }
  a {
    padding: 10px;
    font-size: 1.2rem;
  }
</style>

<div class="container">
  <div class="auth">
    <a href="#" on:click|preventDefault={e => (auth = 'password')}>password</a>
    <a href="#" on:click|preventDefault={e => (auth = 'oauth')}>oauth</a>
    <a href="#" on:click|preventDefault={e => (auth = 'fido2')}>fido2</a>
  </div>
  <svelte:component this={comp} {auth} />
  <a href="/{other}" on:click|preventDefault={e => (mech = other)}>{other}</a>
</div>
