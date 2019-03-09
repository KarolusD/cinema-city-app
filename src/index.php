<?php require_once('./includes/cinemavariables.php') ?>
<?php require_once('./includes/head.php') ?>

<body>
    <div class="app">
        <?php require_once('./includes/navbar.php') ?>
        <?php require_once('./includes/selects.php') ?>
        <div id="movieList"></div>
    </div>
    <script src="./assets/js/all.js?v=<?= date("ymsd") ?>"></script>
</body>

</html> 