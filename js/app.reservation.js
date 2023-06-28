
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
        getReserveList:function(id){
            const vm = this;
            const data = new FormData();
            data.append('method','getReserveList')
            data.append('id',id)
            axios.post('model/adminModel.php',data).then(r =>{
                // console.log(r.data)
                r.data.forEach(list => {
                    vm.lists.push({
                        //user-details
                        userid : list.userid,
                        fullname: list.fullname,
                        //
                        //reserve-details
                        product_name: list.productname,
                        order_quantity: list.rq,
                        size: list.size,
                        price: list.price,
                        total: list.total,
                        status: list.status,
                        date_reserve : list.date_inserted,
                        reserve_id : list.reserved_id
                        
                    })
                });
            })
            // console.log(this.lists)
        },
       deleteReservation:function(reserved_id) {
        // console.log(reserved_id);
  if (confirm("Are you sure you want to delete this reservation?")) {
    const vm = this;
    const data = new FormData();
    data.append("method", "deleteReservation");
    data.append("reserved_id",reserved_id);
    axios.post("model/adminModel.php", data)
      .then(response => {
        // Check the response and perform actions accordingly
        if (response.data = 'success') {
          alert("Reservation deleted successfully");
          window.location.href = 'reservation.php';   
          // Refresh the reservation list or perform any other necessary actions
        //   vm.getReserveList();
          vm.getAllUsers();
        } else {
          alert("Failed to delete reservation");
        }
      })
      .catch(error => {
        console.log(error);
        alert("An error occurred while deleting the reservation");
      });
  }
},

        viewUser:function(id){
            this.userDetail = this.users.filter(user => user.userid == id)

        },
        showReserve:function(id){
            this.detail  = this.lists.filter(list => list.reserve_id == id)
            console.log(this.detail)
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
        this.getReserveList(0);
        this.getAllUsers(0);
    }
}).mount('#reservation-app');