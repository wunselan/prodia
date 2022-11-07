<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top py-sm-3">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('') ?>"><img src="<?= base_url('assets/img/prodia.png') ?>" alt="" width="100"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="<?= base_url('') ?>">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $this->prodia->session_user()['name'] ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?= base_url('keluar') ?>">Keluar</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>