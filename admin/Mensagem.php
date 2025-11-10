<?php 
    if (isset($_SESSION['message_type']) && isset($_SESSION['message_text'])) {
        switch ($_SESSION['message_type']) {
            case 'success':
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                break;
            case 'info':
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                break;
            default: // type: error
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                break;
        }
        echo $_SESSION['message_text'];
        echo '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';

        unset($_SESSION['message_type']);
        unset($_SESSION['message_text']);
    }
?>