    <?php
$con = mysqli_connect('localhost', 'nimbo_tex', 'tex', 'nimbo_tex');

/* check connection */
if (!$con) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>