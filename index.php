<?php
// Config php
include './includes/config.php';
?>

<!-- HEADER -->
<?php include './chunks/header.php' ?>

<?php
$nbrPoke = apiCall("https://pokeapi.co/api/v2/pokemon/")->count;
$rand = rand(1, $nbrPoke);
$pokemon = apiCall("https://pokeapi.co/api/v2/pokemon/" . $rand);
$pokemonSpecies = apiCall("https://pokeapi.co/api/v2/pokemon-species/" . $rand);

foreach ($pokemonSpecies as $key => $val) {
    if ($key == "genera") {
        foreach ($val as $value) {
            if ($value->language->name == "en") {
                $genus = $value->genus;
            }
        }
    }
    if ($key == "flavor_text_entries") {
        foreach ($val as $value) {
            if ($value->language->name == "en") {
                $desc = $value->flavor_text;
            }
        }
    }
}

foreach ($pokemon as $key => $val) {
    if ($key == "stats") {
        foreach ($val as $value) {
            if ($value->stat->name == "hp") {
                $hp = $value->base_stat;
            }
            if ($value->stat->name == "attack") {
                $attack = $value->base_stat;
            }
            if ($value->stat->name == "defense") {
                $defense = $value->base_stat;
            }
            if ($value->stat->name == "special-attack") {
                $SA = $value->base_stat;
            }
            if ($value->stat->name == "special-defense") {
                $SD = $value->base_stat;
            }
            if ($value->stat->name == "speed") {
                $speed = $value->base_stat;
            }
        }
    }
}

switch (true) {
    case $rand <= 9:
        $id = "#00" . $pokemon->id;
        break;
    case $rand <= 99:
        $id = "#0" . $pokemon->id;
        break;
    case $rand <= 999:
        $id = "#" . $pokemon->id;
        break;
}
switch ($pokemonSpecies->color->name) {
    case 'blue':
        echo '<img src="./assets/images/svg/Background/backgroundBlue.svg" alt="" class="background">';
        break;
    case 'red':
        echo '<img src="./assets/images/svg/Background/backgroundRed.svg" alt="" class="background">';
        break;
    case 'green':
        echo '<img src="./assets/images/svg/Background/backgroundGreen.svg" alt="" class="background">';
        break;
    case 'pink':
        echo '<img src="./assets/images/svg/Background/backgroundPink.svg" alt="" class="background">';
        break;
    case 'purple':
        echo '<img src="./assets/images/svg/Background/backgroundPurple.svg" alt="" class="background">';
        break;
    case 'white':
        echo '<img src="./assets/images/svg/Background/backgroundWhite.svg" alt="" class="background">';
        break;
    case 'brown':
        echo '<img src="./assets/images/svg/Background/backgroundBrown.svg" alt="" class="background">';
        break;
    case 'black':
        echo '<img src="./assets/images/svg/Background/backgroundBlack.svg" alt="" class="background">';
        break;
    case 'gray':
        echo '<img src="./assets/images/svg/Background/backgroundGray.svg" alt="" class="background">';
        break;
    case 'yellow':
        echo '<img src="./assets/images/svg/Background/backgroundYellow.svg" alt="" class="background">';
        break;
}
?>

<main class="">
    <div class="header">
        <h1 class="name"><?= $pokemon->name ?></h1>
        <span class="idMobil"><?= $id ?></span>
        <div class="typeGenera">
            <?php
            foreach ($pokemon->types as $type) {
                // var_dump($type);
                echo '<img src="./assets/images/svg/Type/' . $type->type->name . 'Type.svg" alt="">';
            }
            ?>
            <h2 class="genera"><?= $genus ?></h2>
        </div>
    </div>
    <div class="sprite">
        <img src=<?= $pokemon->sprites->other->{'official-artwork'}->front_default ?> alt="">
    </div>
    <div class="menu">
        <div class="panelBtn infosBtn active">Infos</div>
        <div class="panelBtn statsBtn">Stats</div>
    </div>
    <div class="infos">
        <div class="info height">
            <span class="infoLabel">Height</span>
            <span class="infoContent text-xl"><?= $pokemon->height / 10 . "m" ?></span>
        </div>
        <div class="info weight">
            <span class="infoLabel">Weight</span>
            <span class="infoContent text-xl"><?= $pokemon->weight / 10 . "kg" ?></span>
        </div>
        <div class="info typeInfo">
            <span class="infoLabel">Type</span>
            <span class="infoContent">
                <?php
                foreach ($pokemon->types as $type) {
                    var_dump($type);
                    echo '<img src="./assets/images/svg/Type/' . $type->type->name . 'Type.svg" alt="">';
                }
                ?>
            </span>
        </div>
        <div class="info evolChainInfo">
            <img src="./assets/images/4.png" alt="">
            <div class="levelTo w-12 h-11 text-xs flex items-center font-medium">+16</div>
            <img src="./assets/images/4.png" alt="">
            <div class="levelTo w-12 h-11 text-xs flex items-center font-medium">+32</div>
            <img src="./assets/images/4.png" alt="">
        </div>
        <div class="info varieties">
            <span class="infoLabel">Varieties</span>
            <span class="infoContent text-xl"></span>
        </div>
        <div class="info description">
            <div class="infoLabel descriptionLabel">Description</div>
            <span class="infoContent descriptionContent"><?= $desc ?></span>
        </div>
    </div>
    <div class="rightPanel active">
        <span class="id"><?= $id ?></span>
        <div class="stats">
            <div class="stat hp">
                <span class="statLabel">HP</span>
                <div class="statContent">
                    <span class="value"><?= $hp ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="width: <?= ($hp / 2) . "%" ?>;"></div>
                    </div>
                </div>
            </div>
            <div class="stat attack">
                <span class="statLabel">Attack</span>
                <div class="statContent">
                    <span class="value"><?= $attack ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="width: <?= ($attack / 2) . "%" ?>;"></div>
                    </div>
                </div>
            </div>
            <div class="stat defence">
                <span class="statLabel">Defence</span>
                <div class="statContent">
                    <span class="value"><?= $defense ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="width: <?= ($defense / 2) . "%" ?>;"></div>
                    </div>
                </div>
            </div>
            <div class="stat spAttack">
                <span class="statLabel">Sp.Attack</span>
                <div class="statContent">
                    <span class="value"><?= $SA ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="width: <?= ($SA / 2) . "%" ?>;"></div>
                    </div>
                </div>
            </div>
            <div class="stat spDefence">
                <span class="statLabel">Sp.Defence</span>
                <div class="statContent">
                    <span class="value"><?= $SD ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="width: <?= ($SD / 2) . "%" ?>;"></div>
                    </div>
                </div>
            </div>
            <div class="stat speed">
                <span class="statLabel">Speed</span>
                <div class="statContent">
                    <span class="value"><?= $speed ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="width: <?= ($speed / 2) . "%" ?>;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="abilities">
            <?php
            foreach ($pokemon->abilities as $value) {
                echo '<div class="abilitie">' . $value->ability->name . '</div>';
            }
            ?>
        </div>
        <div class="evolChain flex items-center">

            <?php
            $pokemonEvolChain = apiCall($pokemonSpecies->evolution_chain->url);
            $evol1 =  $pokemonEvolChain->chain->species->name;
            $evolArray = [$evol1];
            if (!empty($pokemonEvolChain->chain->evolves_to)) {
                $evolto2 = $pokemonEvolChain->chain->evolves_to[0]->evolution_details[0]->min_level;
                $evolToArray = [$evolto2];
                $evol2 = $pokemonEvolChain->chain->evolves_to[0]->species->name;
                array_push($evolArray, $evol2);
                if (!empty($pokemonEvolChain->chain->evolves_to[0]->evolves_to)) {
                    $evolto3 = $pokemonEvolChain->chain->evolves_to[0]->evolves_to[0]->evolution_details[0]->min_level;
                    array_push($evolToArray, $evolto3);
                    $evol3 = $pokemonEvolChain->chain->evolves_to[0]->evolves_to[0]->species->name;
                    array_push($evolArray, $evol3);
                }
            }
            foreach ($evolArray as $key => $evolution) {
                $rslt = apiCall('https://pokeapi.co/api/v2/pokemon/' . $evolution)
            ?>
                <div class="evol"><img src="<?= $rslt->sprites->other->{'official-artwork'}->front_default; ?>" alt=""></div>
            <?php
            }
            ?>
        </div>
</main>
<script type="application/javascript">
    let color = "<?= $pokemonSpecies->color->name ?>";
    console.log(color);
</script>
<script src="./assets/scripts/main.js"></script>
</body>

</html>