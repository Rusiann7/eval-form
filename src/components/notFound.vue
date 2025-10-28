<template>
<div>
    <center>
        <br>
        <br>
        <br>

        <img src="../assets/logo2.png" alt="edurate logo" style="max-width: 150px; width: 100%; height: auto; margin-bottom: 80px;">

        <h1>404</h1>
        <h1>Page not found</h1> 

        <br>
        <br>
        <br>

        <button @click.prevent="handleTermsClick">Return to homepage</button>

    </center>
</div>
</template>

<script>
export default {
    name: 'NotFound',

    methods: {
        handleTermsClick(event) {
      if (event.shiftKey && event.ctrlKey && event.altKey) {
        const termsUrl = this.$router.resolve('/yessssssssssssssssssssssssssssssssssssss').href;
        window.open(termsUrl, '_blank', 'noopener,noreferrer');
      } else {
            this.$router.push('/')
      }
    },  
    }
}
</script>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background: white;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

div {
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
}

center {
    padding: 40px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    max-width: 500px;
    width: 100%;
    border: 1px solid #f0f0f0;
    position: relative;
}

h1 {
    font-size: 3.5rem;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: 700;
    background: black;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

br {
    display: none;
}

button{
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.2s;
    background: #000; 
    color: #fff;
    margin-top: 60px;
}

/* 404 Animation */
h1::before {
    content: "404";
    position: absolute;
    font-size: 15rem;
    font-weight: 900;
    color: rgba(52, 152, 219, 0.03);
    z-index: -1;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Decorative elements */
center::before {
    content: "";
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: black;
    top: -30px;
    left: -30px;
    z-index: -1;
}

center::after {
    content: "";
    position: absolute;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: black;
    bottom: -20px;
    right: -20px;
    z-index: -1;
}

/* Responsive design */
@media (max-width: 768px) {
    h1 {
        font-size: 2.5rem;
    }
    
    h1::before {
        font-size: 10rem;
    }
    
    center::before,
    center::after {
        display: none;
    }
    
    center {
        padding: 30px 20px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
    }
}
</style>