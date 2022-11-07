<script>
    // Set Toast Message Error
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
    })
</script>
<?php if ($this->session->flashdata('success')){ ?>
    <script>
        Toast.fire({
            icon: 'success',
            title: `&nbsp; <?= $this->session->flashdata('success') ?>`
        })
    </script>
    <?php }else if($this->session->flashdata('error')){ ?>
    <script>
        Toast.fire({
            icon: 'error',
            title: `&nbsp; <?= $this->session->flashdata('error') ?>`
        })
    </script>
<?php } ?>