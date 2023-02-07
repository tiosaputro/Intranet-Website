//auth.js
import { setHeaderToken } from '../utils/auth'
import { removeHeaderToken } from '../utils/auth'
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
export default{
  state: {
    user: null,
    isLoggedIn: false,
    loggedin : false
  },
  mutations: {
    set_user (state, data) {
      state.user = data
      state.isLoggedIn = true
      state.loggedin = true
    },
    reset_user (state) {
      state.user = null
      state.isLoggedIn = false
      state.loggedin = false
    }
  },
  getters:{
    isLoggedIn (state){
      return state.isLoggedIn
    },
    user (state) {
      return state.user
    },
    loggedin (state) {
      return state.loggedin
    }
  },
  actions: {
    login({ dispatch, commit }, data) {
      return new Promise((resolve, reject) => {
        axios.post('login', data)
         .then(response => {
           const token = response.data.token
           localStorage.setItem('token', token)
           setCookie('idu', response.data.id, 1);
           setHeaderToken(token)
            dispatch('get_user')
            // window.location.href="#/dashboard"
            resolve(response)
         })
         .catch(err => {
           console.log(err)
           commit('reset_user')
           localStorage.removeItem('token')
           reject(err)
        })
      })
    },
    async get_user({commit}){
      try{
        if(!localStorage.getItem('token')){
            commit('reset_user')
            localStorage.removeItem('token')
            await axios.get('logout')
        }else{
        let response = await axios.get('user')
         if(response.data.loggedin == 0){
            await axios.get('logout')
         }
          commit('set_user', response.data)
          return response.data;
        }
      } catch (error){
          commit('reset_user')
          removeHeaderToken()
          localStorage.removeItem('token')
          return error
      }
    },
    logout({ commit }) {
        return new Promise((resolve) => {
         commit('reset_user')
         localStorage.removeItem('token')
         removeHeaderToken()
         resolve()
        // window.location.href="#/login"
        // this.$route.push({'name' : 'login'});
        // window.location.reload();
        })
    } //endlogout
  }
}
