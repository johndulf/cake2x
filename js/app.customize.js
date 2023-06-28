const {createApp} = Vue;

createApp({
    data(){
        return{
            users:[],
            reserveid:0,
            // fullname:'',
            suggestion:'',
            date_created:'',
            message:'',
            // userid:[],
            // flavor:'',
            price:250,
            sizes:'small',
            quantity:'',
            image:"",
            mobile:'',
            date:'',
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
                console.log(r.data);
                if(r.data == 1){
                    alert("customize successfully saved");
                    window.location.href="reserve.php"
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
        fnGetCustomize:function(){
            const vm = this;
            const data = new FormData();
            data.append("method","fnGetCustomize");
            data.append("reserveid",this.reserveid);
            axios.post('model/customizeModel.php',data)
            .then(function(r){
                // if(this.reserveid == 0){
                //     vm.users = [];
                    
                //     r.data.forEach(function(v){
                        
                //             vm.users.push({ 
                //                 suggestion: v.productname,
                //                 message: v.message,
                //                 quantity : v.quantity,
                //                 price:v.price,
                //                 reserveid:v.reserveid,
                //                 image: v.image,
                //                 size :v.size,
                //                 flavor :v.flavor,
                //                 quantity:v.quantity,
                //                 mobile:v.mobile
                //             })
                                            
                        
                //     });
                //     //console.log(vm.products);
                // }
                // else{
                //     r.data.forEach(function(v){
                //         vm.fullname = v.fullname;
                //         vm.suggestion = v.suggestion;
                //         vm.quantity = v.quantity;
                //         vm.message = v.price;
                //         vm.size = v.price;
                //         vm.flavor = v.price;
                //         vm.price = v.price;
                //         vm.price = v.price;
                //         vm.reserveid = v.reserveid;
                //     })
                // }
            })
        }
    },
    created:function(){
        this.fnGetCustomize();
    },
    watch:{
        sizes(newValue,oldValue){
            if(newValue =='small'){
                this.price = 250;
            }else if(newValue == 'medium'){
                this.price = 400;
            }else if(newValue == 'large'){
                this.price = 550;          
            }
        }
    }
}).mount('#customize-app')