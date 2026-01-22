<?php 
    if (isset($_SESSION['messageType']) && isset($_SESSION['messageText'])) {
        switch ($_SESSION['messageType']) {
            case 'success':
                echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">';
                break;
            case 'info':
                echo '<div class="alert alert-info alert-dismissible fade show mt-3" role="alert">';
                break;
            default: // type: error
                echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">';
                break;
        }
        echo $_SESSION['messageText'];
        echo '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

        unset($_SESSION['messageType']);
        unset($_SESSION['messageText']);
    }
?>