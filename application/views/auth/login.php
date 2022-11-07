<div class="container">
	<div class="row my-auto p-3 mt-custom">
		<?php $this->load->view('template/swal'); ?>
		<div class="card mb-3 rounded shadow" data-aos="fade-left" data-aos-duration="1000">
			<div class="row g-0">
				<div class="col-md-4 py-3 d-none d-sm-none d-md-none d-lg-flex">
					<div class="card h-100 rounded bg-custom text-dark border-0">
						<div class="card-body m-4 d-flex flex-column border-0">
							<h3 class="card-title text-uppercase fw-bold">Prodia</h3>
							<h5 class="card-text mt-5">Visi Prodia sebagai Centre of Excellence, membawa Prodia untuk terus meningkatkan kualitas dan layanan kepada para pelanggan.</h5>
							<!-- <div class="card bg-custom-2 rounded shadow mt-auto">
								<div class="card-body">
									<small>Prodia merupakan layanan kesehatan yang bagus dan bermutu</small>
									<div class="d-flex mt-2">
										<div class="flex-shrink-0">
											<img src="<?= base_url('assets/img/profile.png') ?>" class="rounded-circle" alt="..." style="width: 3rem">
										</div>
										<div class="flex-grow-1 ms-3">
											<p class="mb-0">Wunsel Arto</p>
											<small class="mb-0">Direktur PT Kita Harus Bisa</small>
										</div>
									</div>
								</div>
							</div> -->
                            
                            <img class="bg-img" src="<?= base_url('assets/img/bg-nurse.png') ?>" alt="" width="250px">
						</div>
					</div>
				</div>
				<div class="col-lg-8 d-flex">
					<div class="card w-100 my-auto p-1 p-lg-5 border-0">
						<div class="card-body">
							<form action="<?= base_url('submit-masuk') ?>" method="post">
								<h1 class="fw-bold">Masuk</h1>
								<p class="mb-3">Silahkan masuk menggunakan akun yang sudah anda daftarkan!</p>
								<div class="mb-3">
									<label for="inputEmail" class="form-label">Email</label>
									<input type="email" class="form-control" id="inputEmail" name="email" required>
								</div>
								<div class="mb-3">
									<label for="inputPassword" class="form-label">Password</label>
									<input type="password" class="form-control" id="inputPassword" name="password" required>
								</div>
								<div class="mb-3">
									<label for="captcha" class="form-label">Captcha</label><br>
									<div class="d-flex">
										<?=$captcha?>
										<input type="text" class="form-control ms-2" id="captcha" name="captcha" aria-describedby="captchaHelp" required>
									</div>
								</div>
                                <p>Belum memiliki akun? silahkan <a href="<?= base_url('daftar') ?>">daftar</a> terlebih dahulu!</p>
								<button type="submit" class="btn-2 btn-custom float-end">Masuk</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>