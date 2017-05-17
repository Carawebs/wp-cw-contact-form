<?php
?>
<div class="alert alert-danger" role="alert">
    <p><strong>Oops!</strong> There were some errors with your form entries.</p>
    <ul>
        <?php
        foreach ($_SESSION['formErrors'] as $error) {
            echo "<li>$error</li>";
        }
        ?>
    </ul>
    <p>Please amend your form and try submitting again.</p>
</div>
