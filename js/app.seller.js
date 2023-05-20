const {createApp} = Vue;

createApp({
    data(){
        return{
            sellers:[],
            sellerid:0,
            fullname:'',
            username:'',
            password:'',
            address:'',
            mobile:'',
            email:''
        }
    },
    methods:{

        fnUnlockAccount:function(sellerid){
            const vm = this;   
            const data = new FormData();
            data.append("sellerid",sellerid);
            data.append('method','fnUnlockAccount');
            axios.post('model/sellerModel.php',data)
            .then(function(r){
                alert('Account is unlocked');
                vm.fnGetSellers(0);
            })
        },
        fnSaveSeller:function(e){
            const vm = this;
            e.preventDefault();    
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append("sellerid",this.sellerid);
            data.append('method','fnSaveSeller');
            axios.post('model/sellerModel.php',data)
            .then(function(r){
                console.log(r);
                if(r.data == 1){
                    alert("User successfully saved");
                    window.location.href = 'loginseller.php';
                    vm.fnGetSellers(0);
                }
                else{
                    alert('There was an error.');
                }
            })
        },
        DeleteSeller:function(sellerid){
            if(confirm("Are you sure you want to delete this user?")){
                const data = new FormData();
                const vm = this;
                data.append("method","DeleteSeller");
                data.append("sellerid",sellerid);
               axios.post('model/sellerModel.php',data)
                .then(function(r){
                    vue.fnGetSellers();
                })
            }
        },
        fnGetSellers:function(sellerid){
            const vm = this;
            const data = new FormData();
            data.append("method","fnGetSellers");
            data.append("sellerid",sellerid);
            axios.post('model/sellerModel.php',data)
            .then(function(r){
                if(sellerid == 0){
                    vm.sellers = [];
                    
                    r.data.forEach(function(v){
                        
                            vm.sellers.push({
                                fullname: v.fullname,
                                username: v.username,
                                address: v.address,
                                mobile:v.mobile,
                                email: v.email,
                                datecreated : v.date_created,
                                sellerid:v.sellerid,
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
                        vm.sellerid = v.sellerid;
                    })
                }
            })
        }
    },
    created:function(){
        this.fnGetSellers(0);
    }
}).mount('#sellerregister-app')