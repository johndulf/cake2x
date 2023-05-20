const {createApp} = Vue;

createApp({
    data(){
        return{
            products:[],
            productid:0,
            productname:'',
            description:'',
            quantity:'',
            image:"",
        }
    },
    methods:{
        fnSave:function(e){
            const vm = this;
            e.preventDefault();    
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append("productid",this.productid);
            data.append('method','fnSave');
            axios.post('model/productModel.php',data)
            .then(function(r){
                console.log(r);
                if(r.data == 1){
                    alert("Product successfully saved");
                    window.location.href = 'products.php';
                    vm.fnGetProdcuts(0);
                }
                else{
                    alert('There was an error.');
                }
            })
        },
         DeleteProducts:function(productid){
            if(confirm("Are you sure you want to delete this product?")){
                window.location.href = 'products.php';
               const data = new FormData();
                  const vm = this;
                data.append("method","DeleteProducts");
                data.append("productid",productid);
                axios.post('model/productModel.php',data)
                .then(function(r){
                    vm.fnGetProdcuts();
                })
            }
        },
        fnGetProdcuts:function(productid){
            const vm = this;
            const data = new FormData();
            data.append("method","fnGetProducts");
            data.append("productid",productid);
            axios.post('model/productModel.php',data)
            .then(function(r){
                if(productid == 0){
                    vm.products = [];
                    
                    r.data.forEach(function(v){
                        
                            vm.products.push({
                                productname: v.productname,
                                description: v.description,
                                quantity : v.quantity,
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
                        vm.quantity = v.quantity;
                        vm.price = v.price;
                        vm.productid = v.productid;
                    })
                }
            })
        }
    },
      
    created:function(){
        this.fnGetProdcuts(0);
    }
}).mount('#products-app')