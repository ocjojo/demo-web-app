import App from "./App.svelte";

const app = new App({
  target: document.getElementById("login"),
  props: {
    name: "world"
  }
});

export default app;
