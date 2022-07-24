<?php
// Config php
include './includes/config.php';
// HEADER
include './chunks/header.php';
?>

<!-- <div class="leftPanel">
    <div class="search">
        <input type="search" placeholder="Type id or Pokémon name">
    </div>
    <div class="filter">

    </div>
</div> -->
<div class="contents">
    <div class="navBar">
        <a class="title" href="./index.php">Pokédex</a>
        <div class="menuNav">
            <a href="./pokemon.php">Random Pokémon</a>
            <a href="./about.php">About</a>
            <form action="" method="post"><input type="search" name="SEARCH" placeholder="Type id or name"></form>
        </div>
    </div>
    <div class="cardContainer">
        <?php
        if (isset($_GET['page'])) {
            if ($_GET['page'] < 1) {
                $page = 1;
                header('Location: ./index.php?page=1');
            } else {
                $page = $_GET['page'];
            }
        } else {
            $page = 1;
        }
        if (isset($_POST['SEARCH'])) {
            $page = 1;
            $pageMax = 1;
            $pokeInfos = apiCall("https://pokeapi.co/api/v2/pokemon/" . strtolower($_POST['SEARCH']));
            if ($pokeInfos != null) {
                $num = $pokeInfos->id;
                $id = "";
                if ($pokeInfos->sprites->other->{'official-artwork'}->front_default == null) {
                    $sprite = "./assets/images/unknow.png";
                } else {
                    $sprite = $pokeInfos->sprites->other->{'official-artwork'}->front_default;
                }
                $color = apiCall($pokeInfos->species->url)->color->name;

                switch ($color) {
                    case 'black':
                        $colorBackground = '#2e2e2e';
                        $colorText = '#8d8d8d';
                        break;

                    case 'blue':
                        $colorBackground = '#90c7ff';
                        $colorText = '#dfeaff';
                        break;

                    case 'brown':
                        $colorBackground = '#ad8f76';
                        $colorText = '#fde7e1';
                        break;

                    case 'gray':
                        $colorBackground = '#bbbbbb';
                        $colorText = '#ebebeb';
                        break;

                    case 'green':
                        $colorBackground = '#65a57f';
                        $colorText = '#a1fbce';
                        break;

                    case 'pink':
                        $colorBackground = '#f5bbc3';
                        $colorText = '#ffeaf2';
                        break;

                    case 'purple':
                        $colorBackground = '#ad90ac';
                        $colorText = '#efcaff';
                        break;

                    case 'red':
                        $colorBackground = '#FC6C6D';
                        $colorText = '#FFDFDF';
                        break;

                    case 'white':
                        $colorBackground = '#efefef';
                        $colorText = '#bbbbbb';
                        break;

                    case 'yellow':
                        $colorBackground = '#ffd49e';
                        $colorText = '#ffedd1';
                        break;
                }
                switch (true) {
                    case $num <= 9:
                        $id = "#00" . $num;
                        break;
                    case $num <= 99:
                        $id = "#0" . $num;
                        break;
                    case $num <= 999:
                        $id = "#" . $num;
                        break;
                }
                $name = $pokeInfos->name;
        ?>
                <a class="pokeDiv <?= $id ?>" style="background-color: <?= $colorBackground ?>" href="./pokemon.php?id=<?= $num ?>">
                    <img src="<?= $sprite; ?>" alt="">
                    <div class="bottom" style="color: <?= $colorText ?>;">
                        <span class="nameBottom"><?= $name ?></span>
                        <span class="idBottom"><?= $id ?></span>
                    </div>
                </a>

            <?php
            } else {
            ?>
                <h2 style="color: #666666; margin-top:20vh">This pokémon does not exist</h2>
            <?php
            }
        } else {
            $limit = 18;
            $offset = ($page - 1) * 18;
            $pokemons = apiCall("https://pokeapi.co/api/v2/pokemon/?offset=" . $offset . "&limit=" . $limit);
            $pageMax = ceil($pokemons->count / 18);


            foreach ($pokemons->results as $pokemon) {
                $pokeInfos = apiCall($pokemon->url);
                $num = $pokeInfos->id;
                $id = "";
                if ($pokeInfos->sprites->other->{'official-artwork'}->front_default == null) {
                    $sprite = "./assets/images/unknow.png";
                } else {
                    $sprite = $pokeInfos->sprites->other->{'official-artwork'}->front_default;
                }
                $color = apiCall($pokeInfos->species->url)->color->name;

                switch ($color) {
                    case 'black':
                        $colorBackground = '#2e2e2e';
                        $colorText = '#8d8d8d';
                        break;

                    case 'blue':
                        $colorBackground = '#90c7ff';
                        $colorText = '#dfeaff';
                        break;

                    case 'brown':
                        $colorBackground = '#ad8f76';
                        $colorText = '#fde7e1';
                        break;

                    case 'gray':
                        $colorBackground = '#bbbbbb';
                        $colorText = '#ebebeb';
                        break;

                    case 'green':
                        $colorBackground = '#65a57f';
                        $colorText = '#a1fbce';
                        break;

                    case 'pink':
                        $colorBackground = '#f5bbc3';
                        $colorText = '#ffeaf2';
                        break;

                    case 'purple':
                        $colorBackground = '#ad90ac';
                        $colorText = '#efcaff';
                        break;

                    case 'red':
                        $colorBackground = '#FC6C6D';
                        $colorText = '#FFDFDF';
                        break;

                    case 'white':
                        $colorBackground = '#efefef';
                        $colorText = '#bbbbbb';
                        break;

                    case 'yellow':
                        $colorBackground = '#ffd49e';
                        $colorText = '#ffedd1';
                        break;
                }
                switch (true) {
                    case $num <= 9:
                        $id = "#00" . $num;
                        break;
                    case $num <= 99:
                        $id = "#0" . $num;
                        break;
                    case $num <= 999:
                        $id = "#" . $num;
                        break;
                }
                $name = $pokemon->name;
            ?>
                <a class="pokeDiv <?= $id ?>" style="background-color: <?= $colorBackground ?>" href="./pokemon.php?id=<?= $num ?>">
                    <img src="<?= $sprite; ?>" alt="">
                    <div class="bottom" style="color: <?= $colorText ?>;">
                        <span class="nameBottom"><?= $name ?></span>
                        <span class="idBottom"><?= $id ?></span>
                    </div>
                </a>

        <?php
            }
        }
        ?>
    </div>
    <div class="pagin">
        <a class="leftPagin" href="./index.php?page=<?= $page - 1 ?>">
            <div class="paginate left"></div>
            <div class="paginate left"></div>
        </a>
        <div class="counter"><span class="currentPage"><?= $page ?></span>/<span class="maxPage"><?= $pageMax ?></span></div>
        <a class="rightPagin" href="./index.php?page=<?= $page + 1 ?>">
            <div class="paginate right one"></div>
            <div class="paginate right"></div>
        </a>
    </div>
</div>
<script src="./assets/scripts/index.js"></script>
</body>

</html>