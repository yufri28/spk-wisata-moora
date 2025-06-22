  <!-- Hero Section -->
  <section id="hero" class="hero section dark-background">

      <img src="<?=base_url()?>assets/img/hero.jpg" alt="" data-aos="fade-in">

      <div class="container d-flex flex-column align-items-center text-center">
          <h2 data-aos="fade-up" data-aos-delay="100">SISTEM PENDUKUNG KEPUTUSAN REKOMENDASI WISATA</h2>
          <p data-aos="fade-up" data-aos-delay="200">DI KABUPATEN KABUPATEN MANGGARAI BARAT
          </p>
          <div data-aos="fade-up" data-aos-delay="300">
              <a href="<?=base_url('pages/rekomendasi');?>" class="btn rounded-pill text-white"
                  style="background:#009991">Cari
                  Rekomendasi
                  Wisata</a>
          </div>
      </div>
  </section><!-- /Hero Section -->

  <!-- Recent Posts Section -->
  <section id="recent-posts" class="recent-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
          <h2>WISATA</h2>
          <p>Berikut beberapa wisata yang tersedia.</p>
      </div><!-- End Section Title -->

      <div class="container">

          <div class="row gy-4 d-flex justify-content-center">
              <?php foreach ($listWisata as $key => $wisata) :?>
              <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                  <article>

                      <div class="post-img">
                          <img src="<?=base_url('uploads/').$wisata['gambar'];?>" alt="" class="img-fluid">
                      </div>

                      <h2 class="title">
                          <a
                              href="<?= base_url('pages/detail_rekomendasi/'.$wisata['id_alternatif']); ?>"><?=$wisata['nama_alternatif'];?></a>
                      </h2>
                  </article>
              </div>
              <?php endforeach;?>
              <!-- End post list item -->

          </div><!-- End recent posts list -->

      </div>

  </section><!-- /Recent Posts Section -->


  <script>
document.getElementById('formKontak').addEventListener('submit', function(e) {
    e.preventDefault(); // Cegah submit bawaan

    const form = e.target;
    const formData = new FormData(form);

    fetch("<?= base_url('pages/proses') ?>", {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const alertBox = document.getElementById('alertKontak');
            if (data.status === 'success') {
                alertBox.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                form.reset();
            } else {
                alertBox.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(() => {
            document.getElementById('alertKontak').innerHTML =
                `<div class="alert alert-danger">Terjadi kesalahan saat mengirim.</div>`;
        });
});
  </script>

  <!-- /Contact Section -->
  <?php if($this->session->flashdata('success')): ?>
  <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
  <?php endif; ?>

  <?php if($this->session->flashdata('error')): ?>
  <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
  <?php endif; ?>