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

        // lccked user
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
        //save user
        fnSave: function(e) {
            const vm = this;
            e.preventDefault();
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append("userid", this.userid);
            data.append("method", "fnSave");
            axios.post('model/userModel.php', data)
              .then(function(r) {
                console.log(r);
                if (r.data == 1) {
                  // Show success message using SweetAlert
                  Swal.fire({
                    title: "Success",
                    text: "User successfully saved",
                    icon: "success"
                  }).then(function() {
                    // Redirect to "userlist.php"
                    window.location.href = 'userlist.php';
                  });
                  vm.fnGetUsers(0);
                } else {
                  // Show error message using SweetAlert
                  Swal.fire({
                    title: "Error",
                    text: "There was an error.",
                    icon: "error"
                  });
                }
              });
          },

          // Delete User:
          DeleteUser: function(userid) {
            Swal.fire({
              title: "Confirmation",
              text: "Are you sure you want to delete this user?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, delete it!"
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'userlist.php';
                const data = new FormData();
                const vm = this;
                data.append("method", "DeleteUser");
                data.append("userid", userid);
                axios.post('model/userModel.php', data)
                  .then(function(r) {
                    vm.fnGetUsers();
                  });
              }
            });
          },
          
          // Get User
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