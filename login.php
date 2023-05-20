<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/s.css">
    <link rel = "icon" href = "img/logo.png" type = "image/x-icon">
    <style>
        .form-control{
            margin-bottom:10px;
        }
        a{
            text-decoration: none;
            color: white;
        }
          body {
    margin: 0;
    padding: 0;
    font-family: emoji;
    background-size: cover;
         background: linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.7)), url('images/cakess.jpg');
  }
    </style>
</head>
<body>
  
     <div class="login-box"  id="login-app">
        <h2>Login</h2>
        <form @submit="fnLogin($event)">
          <div class="user-box">
            <input type="text" name="username" required="">
            <label>Username</label>
          </div>
          <div class="user-box">
            <input type="password" name="password" required="">
            <label>Password</label>
          </div>
         <button type="submit">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Sign In 
         </button>
          <button style="margin-left: 50px;"> 
            <a href="reg.php">
            <span></span>
            <span></span>
            <span></span>
            <span></span>

            Sign Up
        </a>
         </button>
        </form>
      </div>
    <script src="js/vue.3.js"></script>
    <script src="js/axios.js"></script>
    <script>
        const {createApp} = Vue;

createApp({
    data(){
        return{
            
        }
    },
    methods:{
        fnLogin:function(e){
            const vm = this;
            e.preventDefault();    
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append('method','fnLogin');
            axios.post('model/userModel.php',data)
            .then(function(r){
                if(r.data == 1){

                    window.location.href = 'indexx.php';
                }
                else if(r.data == 2){
                    window.location.href = 'dashboard.php';
                }
                else if(r.data == 3){
                    alert('Invalid Username or Password');
                }
                else if(r.data == 4){
                    alert('Account is locked');
                }
                
            })
        },
        
    },
    created:function(){
        
    }
}).mount('#login-app')
    </script>
</body>
</html>