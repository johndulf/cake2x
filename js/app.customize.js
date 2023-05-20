const {createApp} = Vue;

createApp({
    data(){
        return{
            users:[],
            reserveid:0,
            fullname:'',
            suggestion:'',
            date_created:'',
            // userid:[],
            flavor:'',
            size:'',
            quantity:'',
            image:"",
        }
    },
    methods:{
        fnSaveCustomize:function(e){
            const vm = this;
            e.preventDefault();    
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append("reserveid",this.reserveid);
            data.append('method','fnSaveCustomize');
            axios.post('model/customizeModel.php',data)
            .then(function(r){
                console.log(r);
                if(r.data == 1){
                    alert("customize successfully saved");
                    // window.location.href = 'products.php';
                    vm.fnGetCustomize(0);
                }
                else{
                    alert('There was an error.');
                }
            })
        },
        DeleteCustomize:function(reserveid){
            if(confirm("Are you sure you want to delete this product?")){
                // window.location.href = 'products.php';
               const data = new FormData();
                  const vm = this;
                data.append("method","DeleteCustomize");
                data.append("reserveid",reserveid);
                axios.post('model/customizeModel.php',data)
                .then(function(r){
                    vm.fnGetCustomize();
                })
            }
        },
        fnGetCustomize:function(reserveid){
            const vm = this;
            const data = new FormData();
            data.append("method","fnGetCustomize");
            data.append("reserveid",reserveid);
            axios.post('model/customizeModel.php',data)
            .then(function(r){
                if(reserveid == 0){
                    vm.users = [];
                    
                    r.data.forEach(function(v){
                        
                            vm.users.push({
                                fullname: v.productname,
                                suggestion: v.description,
                                quantity : v.quantity,
                                message:v.message,
                                size:v.size,
                                flavor:v,flavor,
                                reserveid:v.reserveid,
                                // image: v.image
                            })
                                            
                        
                    });
                    //console.log(vm.products);
                }
                else{
                    r.data.forEach(function(v){
                        vm.fullname = v.fullname;
                        vm.suggestion = v.suggestion;
                        vm.quantity = v.quantity;
                        vm.message = v.price;
                        vm.size = v.price;
                        vm.flavor = v.price;
                        vm.price = v.price;
                        vm.price = v.price;
                        vm.reserveid = v.reserveid;
                    })
                }
            })
        }
    },
      
    created:function(){
        this.fnGetCustomize(0);
    }
}).mount('#customize-app')