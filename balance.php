<?php 
// Get All Combination without duplicate
function getCombinations($array, $n) {
    $count = count($array);
    $combinations = [];

    if ($n > $count) {
        return $combinations;
    }

    for ($i = 0; $i < $count; $i++) {
        $temp = [$array[$i]];

        if ($n == 1) {
            $combinations[] = $temp;
        } else {
            $remaining = array_slice($array, $i + 1);
            $subcombinations = getCombinations($remaining, $n - 1);

            foreach ($subcombinations as $subarray) {
                $combinations[] = array_merge($temp, $subarray);
            }
        }
    }

    return $combinations;
}

function compareByEloSum($a, $b) {
    global $balance_elo;
    $a_sum = abs(array_sum(array_column($a, 'elo')) - $balance_elo);
    $b_sum = abs(array_sum(array_column($b, 'elo')) - $balance_elo);
    return $a_sum > $b_sum?1:-1;
}

function filterByEloSum($array, $target_sum) {
    return array_filter($array, function($element) use ($target_sum) {
        return array_sum(array_column($element, 'elo')) === $target_sum;
    });
}

function udiffCompare($a, $b)
{
    return $a['name'] <=> $b['name'];
}

//example usage

// Define the list of players
$players = [
    ['name' => 'Yans', 'elo' => 90],
    ['name' => 'Zhombie', 'elo' => 65],
    ['name' => 'Apple', 'elo' => 85],
    ['name' => 'Lelembut', 'elo' => 55],
    ['name' => 'VGB', 'elo' => 85],
    ['name' => 'Godeg', 'elo' => 70],
    ['name' => 'Kaipang', 'elo' => 75],
    ['name' => 'Putih', 'elo' => 65],
];

$combinationPlayers = getCombinations($players, 4);
// Get the balance number
$total_elo = array_sum(array_column($players, 'elo'));
$balance_elo = ceil($total_elo/2);
usort($combinationPlayers,'compareByEloSum');
$target_elo = array_sum(array_column($combinationPlayers[0], 'elo'));
$selected_team = filterByEloSum($combinationPlayers, $target_elo);

$half = ceil(count($selected_team)/2);
$i = 0;
foreach (array_slice($selected_team,0,$half) as $team_member) {
    echo "Team " . ($i+1) . ":\n";
    foreach ($team_member as $player) {
        echo $player['name'] . " (Elo: " . $player['elo'] . ") ";
    }
    echo "\nTotal:".array_sum(array_column($team_member, 'elo'))."\nVS\n";
    $other_player = array_udiff($players, $team_member,'udiffCompare');
    // print_r($other_player);
    foreach ($other_player as $player) {
        echo $player['name'] . " (Elo: " . $player['elo'] . ") ";
    }
    echo "\nTotal:".array_sum(array_column($other_player, 'elo'))."\n\n";
    $i++;
}
