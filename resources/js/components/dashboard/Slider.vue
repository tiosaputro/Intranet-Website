<template>
    <div class="col-xl-8 col-12">
        <div class="card">
            <div class="card-header border-top-success border-3 p-1">
                <h4 class="card-title fw-bolder">EMP News <i data-feather="globe"></i></h4>
            </div>
            <div class="card-body">
                <div id="carousel-example-caption" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carousel-example-caption" data-bs-slide-to="0" class="active"></li>
                        <li data-bs-target="#carousel-example-caption" data-bs-slide-to="1"></li>
                        <!-- <li data-bs-target="#carousel-example-caption" data-bs-slide-to="2"></li> -->
                    </ol>
                    <div class="carousel-inner" style="" v-if="image">
                        <div class="carousel-item" v-bind:class="[ idx == 0 ? 'active' : '']" v-for="(row, idx) in image" :key="row.id"  style="max-height: 300px;">
                            <router-link :to="`${ 'emp-news/detail/'+row.id }`">
                            <img class="img-fluid img-rounded" :src="'../'+row.banner_path" alt="First slide" style="width:100%;" />
                            <div class="carousel-caption d-none d-md-block">
                                <h3 class="text-dark">-</h3>
                                <p class="text-white fw-bolder">
                                    {{ row.title }}
                                </p>
                            </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="carousel-inner" v-if="!image">
                        <div class="alert alert-danger">
                            <p>News EMP Belum Diinput!</p>
                        </div>
                    </div>
                    <a class="carousel-control-prev" data-bs-target="#carousel-example-caption" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" data-bs-target="#carousel-example-caption" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // props : ['image'],
        name : 'Slider',
        data(){
            return {
                images : this.image,
                // image : [
                //     { path : '../storage/media/ak1_1641377617.png', title : '-', content : 'Workshop She Departement EMP'},
                //     { path : 'file-manager/emp_news/gambar-2.png', title : '-', content : 'Workshop She Departement EMP di Banten'},
                //     // { path : 'app-assets/images/slider/08.jpg', title : '', content : 'EMP Increased Its Stake in the Kangean Block.'},
                // ]
            }
        },
        computed : {
            // this.image = this.$props.image
        },
        props : {
            image : {
                type : Array,
                default : []
            }
        },
    }
</script>
