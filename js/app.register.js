const {createApp} = Vue;

createApp({
    data(){
        return{
            users:[],
            // search:[],
            userid:0,
            fullname:'',
            username:'',
            password:'',
            address:'',
            mobile:'',
            email:''
        }
    },
    methods:{
        //   searchUser: function(search) {
        //     const vm = this;   
        //     const data = new FormData();
        //   data.append('method','fnGetUsers');
        //   axios.post('modal/userModel',data)
        //     .then(function(r) {
        //       vm.users = [];
        //       for (const v of r.data) {
        //           if (v.userid.toString().includes(search.toString()) ||
        //           v.fullname.toLowerCase().includes(search.toLowerCase()) ||
        //           v.password.toLowerCase().includes(search.toLowerCase()) ||
        //           v.address.toLowerCase().includes(search.toLowerCase()) ||
        //           v.email.toLowerCase().includes(search.toLowerCase()) ||
        //           v.datecreated.toLowerCase().includes(search.toLowerCase()) ||
        //           v.status.toLowerCase().includes(search.toLowerCase()) ||
        //           v.counterlock.toString().includes(search.toString())) {
        //             vm.users.push({
        //               userid : v.userid,
        //               fullname : v.fullname,
        //               password : v.password,
        //               address : v.address,
        //               email : v.email,
        //               datecreated : v.datecreated,
        //               status : v.status,
        //               counterlock : v.counterlock,
        //           })
        //         }
        //       }
        //   })
        // },

        fnUnlockAccount:function(userid){
            const vm = this;   
            const data = new FormData();
            data.append("userid",userid);
            data.append('method','fnUnlockAccount');
            axios.post('model/userModel.php',data)
            .then(function(r){
                alert('Account is unlocked');
                vm.fnGetUsers(0);
            })
        },
    fnSave: function(e) {
  const vm = this;
  e.preventDefault();
  var form = e.currentTarget;
  const data = new FormData(form);
  data.append("userid", this.userid);
  data.append("method", "fnSave");
  axios.post("model/userModel.php", data)
    .then(function(response) {
      console.log(response);
      if (response.data === 1) {
        alert("User successfully saved");
        window.location.href = "userlist.php";
        // document.querySelector("#update").reset();
        vm.fnGetUsers(0);
      } else if (response.data === "exists_username") {
        alert("This username has already been registered. Please choose another username.");
      } else if (response.data === "exists_password") {
        alert("This password has already been registered. Please choose another password.");
      } else if (response.data === "exists_username_password") {
        alert("Both the username and password have already been registered. Please choose different values for both.");
      } else {
        alert("There was an error.");
      }
    })
    .catch(function(error) {
      console.log(error);
      alert("There was an error.");
    });
},


        
        DeleteUser:function(userid){
            if(confirm("Are you sure you want to delete this user?")){
                window.location.href = 'userlist.php';
                const data = new FormData();
                const vm = this;
                data.append("method","DeleteUser");
                data.append("userid",userid);
               axios.post('model/userModel.php',data)
                .then(function(r){
                    vm.fnGetUsers();
                })
            }
        },
        RestoreUser: function(userid) {
    if (confirm("Are you sure you want to restore this user?")) {
        const data = new FormData();
        data.append("method", "RestoreUser");
        data.append("userid", userid);

        axios.post('model/userModel.php', data)
            .then(function(response) {
                // Handle the restoration process
                console.log("User restored successfully!");
            })
            .catch(function(error) {
                console.log(error);
            });
    }
},

updateUser: function(e) {
    e.preventDefault();
    const vm = this;
    var form = e.currentTarget;
    const data = new FormData(form);

    if (confirm("Are you sure you want to update this User")) {
        data.append('method', 'updateUser');
        axios.post('model/userModel.php', data)
            .then(function(r) {
                console.log(r);
                if (r.data == 1) {
                    alert("Your personal information has been updated.");
                    window.location.href = "profile.php";
                } else if (r.data == 2) {
                    alert("There was an error updating your information!");
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }
},

        updatePassword: function(e) {
          e.preventDefault(); // Prevents the default form submission behavior
          const form = e.currentTarget; // Get the form element
          const formData = new FormData(form); // Create a new FormData object with form data
          
          const userid = formData.get('userid'); // Get the value of the 'userid' field from the form data
          const password = formData.get('password'); // Get the value of the 'password' field from the form data

          const requestData = new FormData(); // Create a new FormData object for the request data
          requestData.append('method', 'updatePassword'); // Append the method parameter to the request data
          requestData.append('userid', userid); // Append the userid parameter to the request data
          requestData.append('password', password); // Append the password parameter to the request data

          return axios.post('model/userModel.php', requestData) // Send a POST request to the userModel.php file with the request data
            .then(function(response) {
              return response.data === true; // Return true if the response data is true, indicating a successful update
            });
        },

        verifyPassword: function(e) {
          e.preventDefault(); // Prevents the default form submission behavior
          const form = e.currentTarget; // Get the form element
          const formData = new FormData(form); // Create a new FormData object with form data
          
          const userid = formData.get('userid'); // Get the value of the 'userid' field from the form data
          const password = formData.get('password'); // Get the value of the 'password' field from the form data

          const requestData = new FormData(); // Create a new FormData object for the request data
          requestData.append('method', 'verifyPassword'); // Append the method parameter to the request data
          requestData.append('userid', userid); // Append the userid parameter to the request data
          requestData.append('password', password); // Append the password parameter to the request data

          return axios.post('model/userModel.php', requestData) // Send a POST request to the userModel.php file with the request data
            .then(function(response) {
              return response.data === true; // Return true if the response data is true, indicating a successful verification
            });
        },

        fnGetUsers:function(userid){
            const vm = this;
            const data = new FormData();
            data.append("method","fnGetUsers");
            data.append("userid",userid);
            axios.post('model/userModel.php',data)
            .then(function(r){
                if(userid == 0){
                    vm.users = [];
                    
                    r.data.forEach(function(v){
                        
                            vm.users.push({
                                fullname: v.fullname,
                                username: v.username,
                                address: v.address,
                                mobile:v.mobile,
                                // password : v.password,
                                email: v.email,
                                datecreated : v.date_created,
                                userid:v.userid,
                                counterlock: v.counterlock
                            })
                                            
                        
                    })
                }
                else{
                    r.data.forEach(function(v){
                        vm.fullname = v.fullname;
                        vm.username = v.username;
                        // vm.password = v.password;
                         vm.address = v.address;
                           vm.mobile = v.mobile;
                        vm.email = v.email;
                        vm.userid = v.userid;
                    })
                }
            })
        }
    },
  

    created:function(){
        this.fnGetUsers(0);
    }
}).mount('#register-app')