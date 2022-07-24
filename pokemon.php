<?php
// Config php
include './includes/config.php';

// HEADER
include './chunks/header.php';

if (isset($_GET['id'])) {
    $pokemon = apiCall("https://pokeapi.co/api/v2/pokemon/" . $_GET['id']);
    $rand = $_GET['id'];
} elseif (isset($_GET['name'])) {
    $pokemon = apiCall("https://pokeapi.co/api/v2/pokemon/" . $_GET['name']);
    $rand = $pokemon->id;
} else {
    $nbrPoke = apiCall("https://pokeapi.co/api/v2/pokemon/")->count;
    $pokemon = null;
    while ($pokemon == null) {
        $rand = rand(1, $nbrPoke);
        $pokemon = apiCall("https://pokeapi.co/api/v2/pokemon/" . $rand);
        if ($pokemon != null) {
            if ($pokemon->sprites->other->{'official-artwork'}->front_default == null) {
                $sprite = "./unknow.png";
            }
        }
    }
}
$pokemonSpeciesURL = $pokemon->species->url;
$pokemonSpecies = apiCall($pokemonSpeciesURL);
if ($pokemon->sprites->other->{'official-artwork'}->front_default == null) {
    $sprite = "./assets/images/unknow.png";
} else {
    $sprite = $pokemon->sprites->other->{'official-artwork'}->front_default;
}

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
    default:
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
        <img src=<?= $sprite; ?> alt="">
    </div>
    <div class="menu">
        <div class="panelBtn infosBtn active">Infos</div>
        <div class="panelBtn statsBtn">Stats</div>
    </div>
    <div class="infos active">
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
                    echo '<img src="./assets/images/svg/Type/' . $type->type->name . 'Type.svg" alt="">';
                }
                ?>
            </span>
        </div>
        <div class="info evolChainInfo">
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
                <a class="evol" href="./pokemon.php?name=<?= $evolution ?>"><img src="<?= $rslt->sprites->other->{'official-artwork'}->front_default; ?>" alt=""></a>
            <?php
            }
            ?>
        </div>
        <div class="info varieties">
            <span class="infoLabel">Varieties</span>
            <div class="infoContent variet">
                <?php
                if ($pokemonSpecies->forms_switchable) {
                    foreach ($pokemonSpecies->varieties as $varieties) {
                        if (!$varieties->is_default) {
                            $var = apiCall($varieties->pokemon->url);
                ?>
                            <a class="evol" href="./pokemon.php?name=<?= $var->id ?>"><img src=" <?= $var->sprites->other->{'official-artwork'}->front_default; ?>" alt=""></a>

                <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
        <div class="info description">
            <div class="infoLabel descriptionLabel">Description</div>
            <span class="infoContent descriptionContent"><?= $desc ?></span>
        </div>
    </div>
    <div class="rightPanel">
        <span class="id"><?= $id ?></span>
        <div class="stats">
            <div class="stat hp">
                <span class="statLabel">HP</span>
                <div class="statContent">
                    <span class="value"><?= $hp ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="transform: translateX(<?= (($hp / 2) - 100) ?>%);"></div>
                    </div>
                </div>
            </div>
            <div class="stat attack">
                <span class="statLabel">Attack</span>
                <div class="statContent">
                    <span class="value"><?= $attack ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="transform: translateX(<?= (($attack / 2) - 100) ?>%);"></div>
                    </div>
                </div>
            </div>
            <div class="stat defence">
                <span class="statLabel">Defence</span>
                <div class="statContent">
                    <span class="value"><?= $defense ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="transform: translateX(<?= (($defense / 2) - 100) ?>%);"></div>
                    </div>
                </div>
            </div>
            <div class="stat spAttack">
                <span class="statLabel">Sp.Attack</span>
                <div class="statContent">
                    <span class="value"><?= $SA ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="transform: translateX(<?= (($SA / 2) - 100) ?>%);"></div>
                    </div>
                </div>
            </div>
            <div class="stat spDefence">
                <span class="statLabel">Sp.Defence</span>
                <div class="statContent">
                    <span class="value"><?= $SD ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="transform: translateX(<?= (($SD / 2) - 100) ?>%);"></div>
                    </div>
                </div>
            </div>
            <div class="stat speed">
                <span class="statLabel">Speed</span>
                <div class="statContent">
                    <span class="value"><?= $speed ?></span>
                    <div class="barre">
                        <div class="valueBarre" style="transform: translateX(<?= (($speed / 2) - 100) ?>%);"></div>
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
                <a class="evol" href="./pokemon.php?name=<?= $evolution ?>"><img src="<?= $rslt->sprites->other->{'official-artwork'}->front_default; ?>" alt="<?= $evolution ?>"></a>
            <?php
            }
            ?>
        </div>
</main>
<script type="application/javascript">
    let color = "<?= $pokemonSpecies->color->name ?>"
    let hp = "<?= (($hp / 2) - 100) ?>"
    let attack = "<?= (($attack / 2) - 100) ?>"
    let defence = "<?= (($defense / 2) - 100) ?>"
    let SA = "<?= (($SA / 2) - 100) ?>"
    let SD = "<?= (($SD / 2) - 100) ?>"
    let Speed = "<?= (($speed / 2) - 100) ?>"
    let stats = [hp, attack, attack, defence, SA, SD, Speed]
</script>
<script src="./assets/scripts/main.js"></script>
</body>

</html>