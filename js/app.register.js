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
        fnSave:function(e){
            const vm = this;
            e.preventDefault();    
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append("userid",this.userid);
            data.append('method','fnSave');
            axios.post('model/userModel.php',data)
            .then(function(r){
                console.log(r);
                if(r.data == 1){
                    alert("User successfully saved");
                     window.location.href = 'userlist.php';
                    //    document.querySelector("#update").reset();
                    vm.fnGetUsers(0);
                }
                else{
                    alert('There was an error.');
                }
            })
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