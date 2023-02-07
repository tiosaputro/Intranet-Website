<template>
<!-- BEGIN: Header-->
<div style="background-image: linear-gradient(to top, #dfe9f3 0%, white 100%);">
<nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center" data-nav="brand-center">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav">
                <li class="nav-item">
				</li>
            </ul>
        </div>

        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <span class="brand-logo">
                    <img :src="logo" style="max-width:136px; max-height: 40px;" />
                    <!-- {{-- <b class="shadow-siap" style="margin-left:-5%; font-size:20pt;">- SIAP</b> --}} -->
                </span>
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#">
                        <feather-icon icon="MenuIcon" class="ficon" />
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto" v-if="loggedin">
                <li class="nav-item dropdown dropdown-notification me-25">
                    <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <feather-icon icon="BellIcon" class="ficon" />
                    <!-- span jumlah -->
                    <!-- <span class="badge rounded-pill bg-danger badge-up">
                    </span> -->
                    </a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                        <li class="dropdown-menu-header">
                            <div class="dropdown-header d-flex">
                                <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                                <div class="badge rounded-pill badge-light-primary">6 New</div>
                            </div>
                        </li>
                        <li class="scrollable-container media-list"><a class="d-flex" href="#">
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar"><img :src="avatar" alt="avatar" width="32" height="32"></div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading"><span class="fw-bolder">Congratulation Sam 🎉</span>winner!</p><small class="notification-text"> Won the monthly best seller badge.</small>
                                    </div>
                                </div>
                            </a><a class="d-flex" href="#">
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar"><img :src="avatar" alt="avatar" width="32" height="32"></div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading"><span class="fw-bolder">New message</span>&nbsp;received</p><small class="notification-text"> You have 10 unread messages</small>
                                    </div>
                                </div>
                            </a><a class="d-flex" href="#">
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar bg-light-danger">
                                            <div class="avatar-content">MD</div>
                                        </div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading"><span class="fw-bolder">Revised Order 👋</span>&nbsp;checkout</p><small class="notification-text"> MD Inc. order updated</small>
                                    </div>
                                </div>
                            </a>
                            <div class="list-item d-flex align-items-center">
                                <h6 class="fw-bolder me-auto mb-0">System Notifications</h6>
                                <div class="form-check form-check-primary form-switch">
                                    <input class="form-check-input" id="systemNotification" type="checkbox" checked="">
                                    <label class="form-check-label" for="systemNotification"></label>
                                </div>
                            </div><a class="d-flex" href="#">
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar bg-light-danger">
                                            <div class="avatar-content"><feather-icon class="avatar-icon" icon="XIcon"></feather-icon></div>
                                        </div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading"><span class="fw-bolder">Server down</span>&nbsp;registered</p><small class="notification-text"> USA Server is down due to hight CPU usage</small>
                                    </div>
                                </div>
                            </a><a class="d-flex" href="#">
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar bg-light-success">
                                            <div class="avatar-content"><feather-icon class="avatar-icon" icon="CheckIcon"></feather-icon></div>
                                        </div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading"><span class="fw-bolder">Sales report</span>&nbsp;generated</p><small class="notification-text"> Last month sales report generated</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">Read all notifications</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">{{ auth.name }}</span><span class="user-status">{{ auth.email }}</span></div><span class="avatar"><img class="round" :src="avatar" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="#/profile"><feather-icon class="me-50" icon="UserIcon"></feather-icon> Profile</a>
                        <a class="dropdown-item" href="#/inbox"><feather-icon class="me-50" icon="MailIcon"></feather-icon> Inbox</a>
                        <a class="dropdown-item" href="#/my-tasks"><feather-icon class="me-50" icon="CheckSquareIcon"></feather-icon> Task</a>
                        <a class="dropdown-item" href="#/my-chats"><feather-icon class="me-50" icon="MessageSquareIcon"></feather-icon> Chats</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" @click="logout"><feather-icon class="me-50" icon="PowerIcon"></feather-icon> Logout</a>
                    </div>
                </li>
            </ul>

        </div>
</nav>
<!-- Modal -->
    <div
        class="modal fade text-start"
        id="inlineForm"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Login</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                <label>Email: </label>
                <div class="mb-1">
                    <input type="text" placeholder="Email Address" class="form-control" />
                </div>

                <label>Password: </label>
                <div class="mb-1">
                    <input type="password" placeholder="Password" class="form-control" />
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Login View</button>
                </div>
            </form>
            </div>
        </div>
    </div>
<!-- END: Header-->
</div>
</template>

<script>
import {mapGetters} from 'vuex'
import FeatherIcon from '../../@core/components/feather-icon/FeatherIcon.vue'
export default {
  components: { FeatherIcon },
    name : "HeaderNavbar",
    // props : ["auth","loggedin"],
    data() {
        return {
            logo : 'app-assets/images/logo/logo.png',
            avatar : 'app-assets/images/portrait/small/avatar-s-15.jpg',
            icon_xls : 'app-assets/images/icons/xls.png',
            // authCheck : null
        }
    },
    methods : {
        authUser(){
            // this.authCheck = this.$props.auth
        },
        logout: function() {
            this.$store.dispatch("logout").then(() => {
            // this.$router.push("login");
                window.location.href="#/login"
                window.location.reload()
            })
        }
    },
    computed : {
        ...mapGetters({
            loggedin : 'isLoggedIn',
            authCheck : 'user',
            auth : 'user'
        })
    }
}
</script>
