<template>
    <div class="my-bg">
        <!--Navbar-->
        <nav class="navbar navbar-expand-lg  navbar-dark my-bg">
            <a class="navbar-brand" href="#">Šokių Studija LetsGoDance</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active hoveris" href="#myCarousel">Nuotraukos</a>
                    <a class="nav-link active hoveris" href="#užsiėmimai">Užsiėmimų tvarkaraštis</a>
                    <a class="nav-link active hoveris" href="#mapas">Kontaktai</a>
                    

                </div>
            </div>
        </nav>
        <!--Navbar pabaiga-->
        <!--Skaidres-->
        <section>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active img-height">
                    <img :src="getImage()" alt="logo">
                </div>

                <div class="item img-height">
                    <img :src="getImage2()" alt="logo">
                </div>

                <div class="item img-height">
                    <img :src="getImage3()" alt="logo">
                </div>

                <div class="item img-height">
                    <img :src="getImage4()" alt="logo">
                </div>
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        </section>
        <!--Skaidrius pabaiga-->
        <!--Kalendorius-->
        <section class="my-bg">
            <h2 class="my-bg bg-up-calendar text-center" id="užsiėmimai">Užsiėmimų tvarkaraštis</h2>
            <div class="container col-12 py-5">
                <full-calendar class="kalendorius cal-color"
                    :events="events"
                    :config="config"
                    :header="{
                left: 'prev,next, today',
                center: 'title',
                right: 'month,listWeek',
            }"
                >
                </full-calendar>
            </div>
        </section>
        <!--kalendoriaus pabaiga-->
<!--        <mapas>-->
        <section>
            <h2 class="text-center">Kur mus rasti?</h2>
        <iframe id="mapas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d146862.7816757761!2d23.786835641022527!3d54.89009150551184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46e7220acad26eb9%3A0x315e5404c4ab4413!2sVelni%C5%B3%20muziejus!5e0!3m2!1slt!2sro!4v1637234390962!5m2!1slt!2sro" width="100%" height="50%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </section>
<!--        </mapas>-->
        <!--        <kantakt>-->
        <div class="footer-dark">
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-3 item">
                            <h3>Kontaktai :</h3>
                            <ul>
                                <li><a class="list-group-item disabled rounded-pill mt-1" href="#">3706060999</a></li>
                                <li><a class="list-group-item disabled rounded-pill mt-1" href="#">test@gmail.com</a></li>
                                <li><a class="list-group-item disabled rounded-pill mt-1" href="#">test2@gmail.com</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-3 item">
                            <h3>Adresas</h3>
                            <ul>
                                <li><a class="list-group-item disabled rounded-pill mt-1" href="#">Kaunas</a></li>
                                <li><a class="list-group-item disabled rounded-pill mt-1" href="#">siaurse pr</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6 item text">
                            <h3>LetsGoDance</h3>
                            <p class="list-group-item disabled rounded-pill">Praesent sed lobortis mi. Suspendisse vel placerat ligula. Vivamus ac sem lacus. Ut vehicula rhoncus elementum. Etiam quis tristique lectus. Aliquam in arcu eget velit pulvinar dictum vel in justo.</p>
                        </div>
                        <div class="col item social">
                            <a class="hoveris" href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
                            <a class="hoveris" href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
                            <a class="hoveris" href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!--        </kantakt>-->
    </div>

</template>

<script>

export default {
    data() {
        return {
            events: [],
            config: {
                locale: 'lt',
                defaultView: 'month',
            },
        };
    },
    created() {
        this.getEvents();
    },
    methods: {
        getEvents() {
            axios
                .get("/api/calendar")
                .then(resp => (this.events = resp.data.data))
                .catch(err => console.log(err.response.data));
        },

        getImage() {
            return 'img/1.jpg'
        },
        getImage2() {
            return 'img/2.jpg'
        },
        getImage3() {
            return 'img/3.jpg'
        },
        getImage4() {
            return 'img/4.jpg'
        },
    },
}
</script>
