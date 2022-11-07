<!doctype html>
<html lang="id">
    <?php 

        // HEAD
        include './application/views/template/head.php';
        
        // Sidebar
        $this->load->view('template/header');
        
        // CSS EACH PAGE
        echo "<style>";
            @include './application/views/'.$content.'.css';
        echo "</style>";

        // BODY
        $this->load->view($content);

        // FOOTER
        include './application/views/template/footer.php';
        
        // SCRIPT
        include './application/views/template/script.php';

        // JS SCRIPT EACH PAGE
        echo "<script type='text/javascript'>";
            @include './application/views/'.$content.'.js';
        echo "</script>";
    ?>
</html>
