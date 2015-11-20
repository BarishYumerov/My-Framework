<?php
if (isset($_SESSION['messages'])) {
    echo '<div id="msgs">';
    foreach ($_SESSION['messages'] as $msg) {
        echo '<p class="' . $msg['type'] . '">';
        echo htmlspecialchars($msg['text']);
        echo '<p>';
    }
    echo '</div>';
    unset($_SESSION['messages']);
}