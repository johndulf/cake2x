const {createApp} = Vue;

createApp({
    data(){
        return{
            products:[],
            productid:0,
            productname:'',
            description:'',
            quantity:'',
            num:1,
            image:"",
            sizes:'small',
            price:undefined,
            smallPrice:undefined,
            isLoggedIn:false,
            showReserve:false,
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
                            id:v.productid,
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
                        vm.price = Number(v.price);
                        vm.smallPrice = vm.price;
                        vm.productid = v.productid;
                    })
                }
            })
        },
        checkStatus:function(){
            const vm = this;
            const data = new FormData();
            data.append("method","fnCheckStatus");
            axios.post('model/userModel.php',data).then(function(r){
                if(r.data == 1){
                    vm.isLoggedIn = true;
                }else{
                    vm.isLoggedIn = false;
                }
            })
        },
        fnReserve:function(e){
            const vm = this;
            const data = new FormData(e.currentTarget);
            data.append("method","fnReserve");
            data.append('reserved_id',0)
            data.append('status',0)
            axios.post('model/userModel.php',data).then(function(r){
                console.log(r.data);
                if(r.data == 1){
                    alert("Product successfully reserved");
                    window.location.href = 'index.php';
                }else{
                    alert('There was an error.');
                }
            })
        },
    },
    // fnDeleteReserve(reserved_id) {
    //     if (confirm("Are you sure you want to delete this reserved item?")) {
    //       const data = new FormData();
    //       const vm = this;
    //       data.append("method", "fnDeleteReserve");
    //       data.append("reserved_id", reserved_id);
    //       axios.post('model/userModel.php', data)
    //         .then(function(r) {
    //           if (r.data == 1) {
    //             alert("Reserved item successfully deleted");
    //             vm.fnGetReserve(0); // Refresh the list of reserved items
    //           } else {
    //             alert('There was an error deleting the reserved item.');
    //           }
    //         })
    //         .catch(function(error) {
    //           console.log(error);
    //         });
    //     }
    //   },
      
    // fnGetReserve(reserved_id) {
    //     const vm = this;
    //     const data = new FormData();
    //     data.append("method", "fnGetReserve");
    //     data.append("reserved_id", reserved_id);
        
    //     axios.post('model/userModel.php', data)
    //       .then(function(r) {
    //         if (reserved_id == 0) {
    //           vm.products = [];
    //           r.data.forEach(function(v) {
    //             vm.products.push({
    //               productname: v.productname,
    //               description: v.description,
    //               quantity: v.quantity,
    //               price: v.price,
    //               id: v.productid,
    //               image: v.image
    //             });
    //           });
    //         } else {
    //           r.data.forEach(function(v) {
    //             vm.productname = v.productname;
    //             vm.description = v.description;
    //             vm.quantity = v.quantity;
    //             vm.price = Number(v.price);
    //             vm.smallPrice = vm.price;
    //             vm.productid = v.productid;
    //           });
    //         }
    //       })
    //       .catch(function(error) {
    //         console.log(error);
    //       });
    //   },
      
    created:function(){
        // this.fnGetReserved(0);
        this.fnGetProdcuts(0);
        this.checkStatus();
    },
    watch:{
        sizes(newValue,oldValue){
            if(newValue =='small'){
                this.price = this.smallPrice;
            }else if(newValue == 'medium'){
                this.price = this.smallPrice + (this.smallPrice * 0.25);
            }else{
                this.price = this.smallPrice + (this.smallPrice * 0.5);          
            }
        }
    }
}).mount('#products-app')