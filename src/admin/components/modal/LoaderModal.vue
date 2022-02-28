<template>
        <div class="loading" style="font-size:200px;--duration:2s;--num-dot:10;">
        <div style="--index:0"></div>
        <div style="--index:1"></div>
        <div style="--index:2"></div>
        <div style="--index:3"></div>
        <div style="--index:4"></div>
        <div style="--index:5"></div>
        <div style="--index:6"></div>
        <div style="--index:7"></div>
        <div style="--index:8"></div>
        <div style="--index:9"></div>
    </div>
</template>

<script>
export default {
    name: 'Loader',

}
</script>

<style scoped>
.loading{
  font-size:100px; /* Default value */
  --duration:0.1s; /* Default value */
  --num-dot:10; /* Default value */
  --color-dot:rgb(3, 32, 8); /* Default value */
  --box-color:rgb(253, 253, 253); /* Default value */
}
.loading > *{
  position:absolute;
  width:100%;
  height:100%;
  top:0;
  left:0;
  transform:rotate(calc((360deg / var(--num-dot) /* Number of child */) * var(--index)));
}
.loading > *::before{
  position:absolute;
  content:'';
  top:.15em;
  left:.45em;
  width:.1em;
  height:.1em;
  transform:scale(0); /* First state is scale from 0 */
  border-radius:50%;
  background-color:var(--color-dot);
  animation:scaleTo1 var(--duration) ease-in-out calc(var(--duration) / var(--num-dot) * var(--index)) infinite reverse;
}
@keyframes scaleTo1 {
  0% {
    transform:scale(0);
  }
  100% {
    transform:scale(1);
  }
}


/*  Box style only  */
.loading{
  width:1em;
  aspect-ratio:1;
  margin-left: 40%;
  position:relative;
}
/* Box style only */
.loading::before{
  content:'';
  position:absolute;
  top:1px;
  left:1px;
  right:1px;
  bottom:1px;
  border-radius:.2em;
  background-color:var(--box-color);
}

/* Background style only */
body{
  width:100vw;
  height:100vh;
  margin:0;
  background-color:rgb(253, 253, 253);
  display:grid;
  place-items:center;
}
</style>