const { createApp } = Vue;
createApp({
  data() {
    return {
      users: [],
      userid: 0,
      username: '',
      fullname: '',
      address: '',
      mobile: '',
      email: '',
      password: ''
    }
  },
  methods: {
    fnupdateUser: function(e) {
    e.preventDefault();
    const vm = this;
    var form = e.currentTarget;
    const data = new FormData(form);

    if (confirm("Are you sure you want to update this User")) {
        data.append('method', 'fnupdateUser');
     
        axios.post('model/userModel.php', data)
            .then(function(r) {
                console.log(r);
                if (r.data == 1) {
                    alert("Your personal information has been updated.");
                    window.location.href = "profile.php";
                } else if (r.data == 2) {
                    alert("There was an error updating your user!");
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }
},
    updateUserPassword: function(e) {
      const vm = this;
      e.preventDefault();
      var form = e.currentTarget;
      const data = new FormData(form);

      if (confirm('Are you sure you want to update this User')) {
        data.append('method', 'updateUserPassword');
        axios.post('model/userModel.php', data).then(function(r) {
          console.log(r);
          if (r.data == 1) {
            alert('Your password has been updated');
            window.location.href = 'profile.php';
          } else if (r.data == 2) {
            alert('The password you entered does not match!');
          } else if (r.data == 3) {
            alert('Account not exist. Please try again!');
          } else {
            alert('There was an error updating your password!');
          }
        });
      }
    }
  },
  created: function() {},
}).mount('#profile-app');
