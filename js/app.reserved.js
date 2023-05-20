const {createApp} = Vue;

createApp({
    data(){
        return{
            products:[],
            productid:0,
            productname:'',
            description:'',
            flavor:'',
            image:"",        }
    },
    methods:{
        fnSave:function(e){
            const vm = this;
            e.preventDefault();    
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append("productid",this.productid);
            data.append('method','fnSave');
            axios.post('model/reservedModel.php',data)
            .then(function(r){
                console.log(r);
                if(r.data == 1){
                    alert("User successfully saved");
                    vm.fnGetReserved(0);
                }
                else{
                    alert('There was an error.');
                }
            })
        },
         DeleteReserved:function(productid){
            if(confirm("Are you sure you want to delete this product?")){
               const data = new FormData();
                  const vm = this;
                data.append("method","DeleteReserved");
                data.append("productid",productid);
                axios.post('model/reservedModel.php',data)
                .then(function(r){
                    vm.fnGetReserved();
                })
            }
        },
        fnGetReserved:function(productid){
            const vm = this;
            const data = new FormData();
            data.append("method","fnGetReserved");
            data.append("productid",productid);
            axios.post('model/reservedModel.php',data)
            .then(function(r){
                if(productid == 0){
                    vm.products = [];
                    
                  r.data.forEach(function(v){
                        
                            vm.products.push({
                                productname: v.productname,
                                description: v.description,
                                flavor : v.flavor,
                                price:v.price,
                                productid:v.productid,
                                image: v.image
                            })
                                            
                        
                    });
                    //console.log(vm.products);
                }
                else{
                    r.data.forEach(function(v){
                        vm.productname = v.productname;
                        vm.description = v.description;
                        vm.flavor = v.flavor;
                        vm.date = v.date;
                        vm.price = v.price;
                        vm.productid = v.productid;
                    })
                }
            })
        }
    },
      
    created:function(){
        this.fnGetReserved(0);
    }
}).mount('#products-app')