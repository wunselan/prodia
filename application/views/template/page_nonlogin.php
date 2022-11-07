<!doctype html>
<html lang="id">
    <?php 
        
        // HEAD
        include './application/views/template/head.php';

        // CSS EACH PAGE
        echo "<style>";
            @include './application/views/'.$content.'.css';
        echo "</style>";

        // BODY
        $this->load->view($content);
        
        // SCRIPT
        include './application/views/template/script.php';

        // JS SCRIPT EACH PAGE
        echo "<script type='text/javascript'>";
            @include './application/views/'.$content.'.js';
        echo "</script>";

    ?>
</html>
