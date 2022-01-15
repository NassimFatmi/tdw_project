<?php
\TDW\Templates\Templates::navbar();
?>

<section class="stars">
    <div class="container">
        <h2 class="main-heading">Notez votre transporteur</h2>
        <div class="content">
            <h4>Noter le transporteur</h4>
            <form method="POST">
                <select name="stars">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <span> Sur 5</span>
                <input type="submit" name="submit" value="Envoyer" class="link-btn">
            </form>
        </div>
    </div>
</section>
