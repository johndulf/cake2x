
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