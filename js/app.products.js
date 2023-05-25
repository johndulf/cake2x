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
              fnSave: function(e) {
            const vm = this;
            e.preventDefault();
            var form = e.currentTarget;
            const data = new FormData(form);
            data.append("productid", this.productid);
            data.append("method", "fnSave");
            axios.post("model/productModel.php", data)
              .then(function(r) {
                console.log(r);
                if (r.data == 1) {
                  Swal.fire({
                    title: "Product successfully saved",
                    icon: "success"
                  }).then(function() {
                    window.location.href = "products.php";
                    vm.fnGetProdcuts(0);
                  });
                } else {
                  Swal.fire({
                    title: "Error",
                    text: "There was an error.",
                    icon: "error"
                  });
                }
              });
          },
          DeleteProducts: function(productid) {
            const vm = this;
            Swal.fire({
              title: "Confirmation",
              text: "Are you sure you want to delete this product?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Yes, delete it!",
              cancelButtonText: "Cancel"
            }).then(function(result) {
              if (result.isConfirmed) {
                const data = new FormData();
                data.append("method", "DeleteProducts");
                data.append("productid", productid);
                axios.post('model/productModel.php', data)
                  .then(function(r) {
                    // Show success message using SweetAlert
                    Swal.fire({
                      title: "Success",
                      text: "Product successfully deleted",
                      icon: "success"
                    }).then(function() {
                      // Redirect to "products.php"
                      window.location.href = "products.php";
                    });
                  })
                  .catch(function(error) {
                    console.error(error);
                    // Show error message using SweetAlert
                    Swal.fire({
                      title: "Error",
                      text: "Failed to delete product",
                      icon: "error"
                    });
                  });
              }
            });
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