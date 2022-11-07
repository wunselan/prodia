<div class="main mb-5">
    <?php $this->load->view('template/swal'); ?>
    <div class="jumbotron d-flex">
        <div class="container my-auto">
            <div class="row">
                <div class="col-12 col-lg-6 text-start text-darrk align-self-center">
                    <h3 class="fw-bold">Prodia</h3>
                    <p>Laboratorium Klinik Prodia didirikan pertama kali di Solo, Jawa Tengah, pada tanggal 7 Mei 1973 oleh beberapa orang idealis berlatar belakang pendidikan farmasi. Sejak awal, Drs. Andi Wijaya, MBA, PhD. beserta seluruh pendiri lainnya tetap menjaga komitmen untuk mempersembahkan hasil pemeriksaan terbaik dengan layanan sepenuh hati.</p>
                </div>
                <div class="col-6 d-none d-lg-block text-end">
                    <img class="mb-min-custom" src="<?= base_url('assets/img/mobile-prodia.png') ?>" alt="" width="300">
                </div>
            </div>
        </div>
    </div>
    <section class="data-cuaca mt-5">
        <div class="container">
            <div class="col-12 col-md-12 text-center m-auto my-4 p-4">
                <h5 class="fw-bold">Data Cuaca Saat Ini</h5>
                <h3 class="fw-bolder">Waktu: <?= $this->prodia->dateIndonesia(date('Y-m-d', strtotime(@$cuaca[0]['created_at']))).' '.date('H:i:s', strtotime(@$cuaca[0]['created_at'])) ?></h3>
                <div class="card rounded shadow p-lg-2s p-1 mx-auto my-5 text-center">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-2">
                                <h5><span class="value fw-bold"><?= @$cuaca[0]['coord_lat'] ?></span></h5>
                                <p>Latitude</p>
                            </div>
                            <div class="col-2">
                                <h5 class="value fw-bold"><?= @$cuaca[0]['coord_lon'] ?></h5>
                                <p>Longitude</p>
                            </div>
                            <div class="col-2">
                                <h5 class="value fw-bold"><?= @$cuaca[0]['timezone'] ?></h5>
                                <p>Timezone</p>
                            </div>
                            <div class="col-2">
                                <h5 class="value fw-bold"><?= @$cuaca[0]['main_pressure'] ?></h5>
                                <p>Pressure</p>
                            </div>
                            <div class="col-2">
                                <h5 class="value fw-bold"><?= @$cuaca[0]['main_humidity'] ?></h5>
                                <p>Humidity</p>
                            </div>
                            <div class="col-2">
                                <h5 class="value fw-bold"><?= @$cuaca[0]['wind_speed'] ?></h5>
                                <p>Wind Speed</p>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('perbarui-data-cuaca') ?>"><button type="button" class="btn-2 btn-custom"><i class="fas fa-sync-alt"></i>&nbsp; Perbarui Data</button></a>
            </div>
        </div>
    </section>
    <section class="py-5 bg-white">
        <div class="container">
            <h4 class="fw-bold mb-3">List Weather</h4>
            <div class="row">
                <div class="col-12">
                    <table id="table-weather" class="table table-striped table-bordered">
                        <thead>
                            <tr class="header-prodia text-center">
                                <th>ID</th>
                                <th>Main</th>
                                <th>Description</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $listWeather as $tr ) { ?> 
                            <tr>
                                <?php foreach( $tr as $td ) { ?>
                                    <td><?= $td ?></td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>