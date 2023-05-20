const {createApp} = Vue;

createApp({
    data(){
        return{
            admins:[],
            // search[],
            adminid:0,
            username:'',
            password:'',
            first_name:'',
            last_name:''
        }
    },
    methods:{
        //   searchUser: function(search) {
        //   var data = new FormData();
        //   const vue = this;
        //   data.append('method','fnGetUsers');
        //   axios.post('modal/userModel',data)
        //     .then(function(r) {
        //       vm.users = [];
        //       for (var v of r.data) {
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

        fnUnlockAccount:function(adminid){
            const vm = this;   
            const data = new FormData();
            data.append("adminid",adminid);
            data.append('method','fnUnlockAccount');
            axios.post('model/adminModel.php',data)
            .then(function(r){
                alert('Account is unlocked');
                vm.fnGetAdmins(0);
            })
        },
        fnSave:function(e){
            const vm = this;
            e.preventDefault();    
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append("adminid",this.adminid);
            data.append('method','fnSave');
            axios.post('model/adminModel.php',data)
            .then(function(r){
                console.log(r);
                if(r.data == 1){
                    alert("Admin successfully saved");
                    //  window.location.href = 'userlist.php';
                       // document.querySelector(".btn").reset();
                    vm.fnGetAdmins(0);
                }
                else{
                    alert('There was an error.');
                }
            })
        },
        DeleteAdmin:function(adminid){
            if(confirm("Are you sure you want to delete this Admin?")){
                const data = new FormData();
                const vm = this;
                data.append("method","DeleteAdmin");
                data.append("adminid",adminid);
               axios.post('model/adminModel.php',data)
                .then(function(r){
                    vue.fnGetAdmins();
                })
            }
        },
        fnGetAdmins:function(adminid){
            const vm = this;
            const data = new FormData();
            data.append("method","fnGetAdmins");
            data.append("adminid",adminid);
            axios.post('model/adminModel.php',data)
            .then(function(r){
                if(adminid == 0){
                    vm.admins = [];
                    
                    r.data.forEach(function(v){
                        
                            vm.admins.push({
                                username: v.username,
                                address: v.address,
                                mobile:v.mobile,
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
                        vm.password = v.password;
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
        this.fnGetAdmins(0);
    }
}).mount('#register-app')