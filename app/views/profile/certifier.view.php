<?php
\TDW\Templates\Templates::navbar();
function showForm()
    {
    ob_start();
    ?>
    <section class="certifer">
        <div class="container">
            <h2 class="main-heading">Demande de vérification:</h2>
            <form method="POST" enctype="multipart/form-data">
                <input required type="text" placeholder="Titre" name="title">
                <textarea required name="description" maxlength="1024" placeholder="Description"></textarea>
                <input type="file" name="file" required accept="image/jpeg,image/jpg,image/png"/>
                <input class="link-btn" value="Demander" type="submit" name="submit">
            </form>
        </div>
    </section>
<?php
echo ob_get_clean();
}

showForm();