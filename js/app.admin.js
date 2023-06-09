
const {createApp} = Vue;

createApp({
    data(){
        return{
            lists:[],
            users:[],
            detail:[],
            userDetail:[]
        }
    },
    methods:{
        updateStatus:function(id){
            const vm = this
            const data = new FormData
            data.append('method','updateStatusReserve')
            data.append('status','1')
            data.append('id',id)
            axios.post('model/adminModel.php',data).then(r=>{
                console.log(r.data)
                if(r.data == 1 ){
                    alert('Reserved Approved')
                    window.location.href = 'reservation.php';   
                }else{
                    alert('something went wrong')
                }
            })
        },
getCustomizeList: function(id) {
  const vm = this;
  const data = new FormData();
  data.append('method', 'getCustomizeList');
  data.append('id', id);
  
  axios.post('model/adminModel.php', data).then(r => {
    r.data.forEach(list => {
      vm.lists.push({
        userid: list.userid,
        fullname: list.fullname,
        product_name: list.productname,
        order_quantity: list.rq,
        price: list.price,
        total: list.total,
        status: list.status,
        date_reserve: list.date_inserted,
        reserve_id: list.reserved_id,
        customize: list.customize // Add the customize options to the list object
      });
    });
  });
},
      deleteCustomize: function(reserveid) {
  if (confirm("Are you sure you want to delete this customize item?")) {
    const vm = this;
    const data = new FormData();
    data.append("method", "deleteCustomize");
    data.append("reserveid", reserveid);
    axios.post("model/adminModel.php", data)
      .then(response => {
        // Check the response and perform actions accordingly
        if (response.data === 'success') {
          alert("Customize item deleted successfully");
          // Refresh the customize item list or perform any other necessary actions
          vm.getCustomizeList();
        } else {
          alert("Failed to delete customize item");
        }
      })
      .catch(error => {
        console.log(error);
        alert("An error occurred while deleting the customize item");
      });
  }
},


        viewUser:function(id){
            this.userDetail = this.users.filter(user => user.userid == id)

        },
        showCustomize: function(reserveid) {
  this.detail = this.lists.filter(list => list.reserveid === reserveid);
  console.log(this.detail);
        },

        getAllUsers:function(id){
            const vm = this
            const data = new FormData
            data.append('method','getAllUser');
            data.append('userid',id)
            axios.post('model/adminModel.php',data).then(r =>{
                // console.log(r.data)
                r.data.forEach(user=>{
                    vm.users.push({
                        userid: user.userid,
                        fullname: user.fullname,
                        address: user.address,
                        mobile: user.mobile,
                        email: user.email,
                        status: user.user_status
                    })
                })
            })
        }

    },
    created:function(){
        this.getCustomizeList(0);
        this.getAllUsers(0);
    }
}).mount('#reservation-app');