<template>
<!-- <div class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="blank-page"> -->
<div class="blank-page" data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
 <!-- BEGIN: Content-->
 <div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <div class="auth-wrapper auth-cover" style="overflow:hidden !important;">
          <div class="auth-inner row m-0" style="overflow:hidden !important;">
            <!-- Brand logo-->
            <a class="brand-logo" href="#">
              <img :src="logo" style="max-width:180px;"/>
            </a>
            <!-- /Brand logo-->
            <!-- Left Text-->
            <div class="d-none d-lg-flex col-lg-8 align-items-center p-5" style="background-image: url('app-assets/images/pages/login/emp.jpg'); background-repeat:no-repeat; background-size:cover;">
              <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                  <!-- <img class="img-fluid" src="app-assets/images/pages/login/emp.jpg" alt="Login V2"/> -->
                </div>
            </div>
            <!-- /Left Text-->
            <!-- Login-->
            <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
              <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                <h2 class="card-title fw-bold mb-1">Selamat Datang di Intranet! 👋</h2>
                <p class="card-text mb-2">Silahkan Sign-in menggunakan akun anda</p>
                 <div class="alert alert-danger p-2" v-if="errors">
                    <p>{{ errors }}</p>
                </div>
                <form class="auth-login-form mt-2" action="#" method="POST" autocomplete="off" @submit.prevent="userLogin">
                  <div class="mb-1">
                    <label class="form-label" for="login-email">Email</label>
                    <input class="form-control" id="login-email" type="email" v-model="form.email" name="email" placeholder="" aria-describedby="email" autofocus="" tabindex="1" autocomplete="off" required/>
                    <!-- <span class="text-danger"><strong>error email</strong></span> -->
                  </div>
                  <div class="mb-1">
                    <div class="d-flex justify-content-between">
                      <!-- <label class="form-label" for="password">Password</label><a href="#"><small>Lupa Password ?</small></a> -->
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                      <input class="form-control form-control-merge" v-model="form.password" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" autocomplete="off" value="" required/>
                      <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                    <!-- <span class="text-danger mt-2"><b>error password </b></span> -->
                  </div>
                  <div class="mb-1">
                    <div class="form-check">
                      <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" checked/>
                      <label class="form-check-label" for="remember-me"> Remember Me</label>
                    </div>
                  </div>
                  <button class="btn btn-primary w-100" type="submit" name="submit" tabindex="4" :disabled="disabled">Sign in</button>
                </form>
                <p class="text-center mt-2" v-if="hide"><span>Versi Mobile Silahkan Download & Install Disini</span></p>
                <div class="divider my-2" v-if="hide">
                  <div class="divider-text">Mobile</div>
                </div>
                <div class="auth-footer-btn d-flex justify-content-center" v-if="hide">
                    <a class="btn btn-success" href="#"><i data-feather="smartphone"></i> Android</a>
                    <a class="btn btn-twitter white" href="#"><i data-feather="smartphone"></i> IOS</a>
                </div>
              </div>
            </div>
            <!-- /Login-->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Content-->
</div>
</template>
<style scoped>
@import '/app-assets/css/pages/authentication.css';
</style>
<script>
 export default {
    data(){
      return {
        hide : false,
        logo : 'app-assets/images/logo/logo.png',
        form: {
          email: '',
          password: '',
        },
        errors: false,
        disabled : false
      }
    },
    methods: {
      userLogin () {
     this.disabled = true;
      this.$store.dispatch('login', this.form)
      .then(response => {
        if(response.status === 200){
            this.disabled = false;
            this.$toasted.show('Akun anda berhasil login!', {
                position : 'top-right',
                type : 'success',
                theme : 'toasted-primary'
            })
            setTimeout(function(){
                $(".horizontal-menu-wrapper").show();
                window.location.href = "#/dashboard"
                location.reload()
            },900)
  	        // this.$router.push({name: 'dashboard'})
            // this.$router.go('dashboard');
        }
      }).catch(error => {
        this.errors = error.response?.data?.message
        this.$toasted.show('Mohon periksa kembali akun anda!', {
            position : 'top-right',
            type : 'error',
            theme : 'toasted-primary'
        })
        this.disabled = false;
      })
    }
    }
  }
</script>
